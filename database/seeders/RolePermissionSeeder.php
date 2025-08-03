<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;


class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // Permission::truncate();
        // Role::truncate();
        // Schema::enableForeignKeyConstraints();
        
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage students', 'manage teachers', 'manage staff', 'manage committees',
            'manage classes', 'manage subjects', 'manage exams', 'manage routines',
            'manage marks', 'view results', 'manage attendance', 'manage accounts',
            'manage notices'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $teacherRole->givePermissionTo(['view results', 'manage attendance']);

        $accountantRole = Role::firstOrCreate(['name' => 'accountant']);
        $accountantRole->givePermissionTo(['manage accounts', 'view results']);
        
        $guardianRole = Role::firstOrCreate(['name' => 'guardian']);
        $guardianRole->givePermissionTo(['view results']);
    }
}