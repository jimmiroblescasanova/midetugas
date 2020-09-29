<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
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

        // Permisos para los clientes
        Permission::create(['name' => 'show_clients']);
        Permission::create(['name' => 'create_clients']);
        Permission::create(['name' => 'edit_clients']);
        Permission::create(['name' => 'edit_contacts']);
        Permission::create(['name' => 'edit_addresses']);
        Permission::create(['name' => 'delete_clients']);
        // Permisos para los medidores
        Permission::create(['name' => 'show_measurers']);
        Permission::create(['name' => 'create_measurers']);
        Permission::create(['name' => 'edit_measurers']);
        Permission::create(['name' => 'delete_measurers']);
        // Permisos para los documentos
        Permission::create(['name' => 'show_documents']);
        Permission::create(['name' => 'create_documents']);
        Permission::create(['name' => 'authorize_documents']);
        Permission::create(['name' => 'cancel_documents']);
        Permission::create(['name' => 'pay_documents']);
        // Permisos para los usuarios
        Permission::create(['name' => 'show_users']);
        Permission::create(['name' => 'create_users']);
        Permission::create(['name' => 'edit_users']);
        Permission::create(['name' => 'delete_users']);
    }
}
