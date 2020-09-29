<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.index', [
            'users' => User::where('admin', false)->get(),
        ]);
    }

    public function create()
    {
        return view('users.create', [
            'user' => new User,
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create( $request->validated() );
        $user->givePermissionTo( Permission::all() );

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $permissionNames = $user->getPermissionNames();

        return view('users.edit', [
            'user' => $user,
            'permissions' => $permissionNames->toArray(),
        ]);
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password') != NULL)
        {
            $user->password = $request->input('password');
        }
        $user->save();

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    public function permissions(User $user, Request $request)
    {
        $user->syncPermissions($request->permissions);

        return redirect()->back();
    }
}
