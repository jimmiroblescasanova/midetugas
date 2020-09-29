<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'          => 'Jimmi Robles',
            'email'         => 'jimmirobles@icloud.com',
            'password'      => 'password',
            'admin'         => true,
            'created_at'    => \Carbon\Carbon::now(),
        ]);

        $user->givePermissionTo(Permission::all());
    }
}
