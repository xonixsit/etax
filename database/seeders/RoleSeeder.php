<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get existing roles with web guard
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web']);

        // Create permissions if they don't exist
        $permissions = [
            // Assessment management
            'create_assessment',
            'edit_assessment',
            'delete_assessment',
            'view_assessment',
            'assign_assessment',
            
            // Question management
            'create_question',
            'edit_question',
            'delete_question',
            'view_question',
            
            // Report management
            'generate_report',
            'export_report',
            'view_report',
            
            // User management
            'manage_users',
            'view_users',
            
            // Assessment taking
            'take_assessment',
            'view_results'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Sync all permissions to admin (removes any existing and adds new ones)
        $adminRole->syncPermissions($permissions);
        
        // Sync specific permissions to employee
        $employeeRole->syncPermissions([
            'take_assessment',
            'view_assessment',
            'view_results'
        ]);
    }
}