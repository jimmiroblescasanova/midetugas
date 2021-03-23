<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TasksPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // Configurations tasks
        Permission::create(['name'=> 'run_tasks']);
        $user = User::find(1);
        $user->givePermissionTo('run_tasks');
    }
}
