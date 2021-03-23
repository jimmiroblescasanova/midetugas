<?php

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
        // Configurations tasks
        Permission::create(['name'=> 'run_tasks']);
    }
}
