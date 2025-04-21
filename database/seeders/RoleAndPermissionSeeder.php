<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                 // Create Permissions
                 Permission::create(['name' => 'view_users']);
                 Permission::create(['name' => 'create_users']);
                 Permission::create(['name' => 'edit_users']);
                 Permission::create(['name' => 'delete_users']);
                 Permission::create(['name' => 'view_ranks']);
                 Permission::create(['name' => 'create_ranks']);
                 Permission::create(['name' => 'edit_ranks']);
                 Permission::create(['name' => 'delete_ranks']);
                 Permission::create(['name' => 'view_regiments']);
                 Permission::create(['name' => 'create_regiments']);
                 Permission::create(['name' => 'edit_regiments']);
                 Permission::create(['name' => 'delete_regiments']);
                 Permission::create(['name' => 'view_units']);
                 Permission::create(['name' => 'create_units']);
                 Permission::create(['name' => 'edit_units']);
                 Permission::create(['name' => 'delete_units']);
                 Permission::create(['name' => 'view_medals']);
                 Permission::create(['name' => 'create_medals']);
                 Permission::create(['name' => 'edit_medals']);
                 Permission::create(['name' => 'delete_medals']);
                 
                 // Create Roles
                 $adminRole = Role::create(['name' => 'admin']);
                 $officerRole = Role::create(['name' => 'officer']);
                 $operatorRole = Role::create(['name' => 'operator']);
                 
                 
                 // Assign Permissions to Admin
                 $adminRole->givePermissionTo(Permission::all());
                 
                 // Assign Permissions to Officer
                 $officerRole->givePermissionTo([
                    'view_users',
                    'create_users',
                    'edit_users',
                    'view_ranks',
                    'create_ranks',
                    'edit_ranks',
                    'view_regiments',
                    'create_regiments',
                    'edit_regiments',
                    'view_units',
                    'create_units',
                    'edit_units',
                    'view_medals',
                    'create_medals',
                    'edit_medals',
                ]);
        // Assign Permissions to Operator
                $operatorRole->givePermissionTo([
                    'view_users',
                    'view_ranks',
                    'view_regiments',
                    'view_units',
                    'view_medals',
                 ]);
                
        
    }
}
