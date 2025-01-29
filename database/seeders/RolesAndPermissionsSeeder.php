<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $admin = Role::create(['name' => 'Super_admin']);
        $subadmin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);
        $student = Role::create(['name' => 'Student']);

        // Create permissions
        $manageUsers = Permission::create(['name' => 'manage_users']);
        $viewReports = Permission::create(['name' => 'view_reports']);
        $createResource = Permission::create(['name' => 'create']);
        $read = Permission::create(['name' => 'read']);
        $editContent = Permission::create(['name' => 'edit_content']); // cod can edit personal resource
        $removeContent = Permission::create(['name' => 'delete_content']); // cod can remove resouce

        // Assign permissions to roles
        $admin->permissions()->attach([$manageUsers->id, $viewReports->id, $editContent->id, $removeContent->id]);
        $subadmin->permissions()->attach([$manageUsers->id, $viewReports->id, $editContent->id]);
        
        $user->permissions()->attach([$viewReports->id, $createResource->id, $read->id, $removeContent->id, $editContent->id]);

        $student->permissions()->attach([$viewReports->id]);

        // Create roles
        // $admin = Role::firstOrCreate(['name' => 'Super_admin']);
        // $subadmin = Role::firstOrCreate(['name' => 'Admin']);
        // $user = Role::firstOrCreate(['name' => 'User']);
        // $student = Role::firstOrCreate(['name' => 'Student']);

        // // Create permissions
        // $manageUsers = Permission::firstOrCreate(['name' => 'manage_users']);
        // $viewReports = Permission::firstOrCreate(['name' => 'view_reports']);
        // $createResource = Permission::firstOrCreate(['name' => 'create']);
        // $read = Permission::firstOrCreate(['name' => 'read']);
        // $editContent = Permission::firstOrCreate(['name' => 'edit_content']);
        // $removeContent = Permission::firstOrCreate(['name' => 'delete_content']);

        // // Assign permissions to roles
        // $admin->permissions()->syncWithoutDetaching([
        //     $manageUsers->id, 
        //     $viewReports->id, 
        //     $editContent->id, 
        //     $removeContent->id
        // ]);

        // $subadmin->permissions()->syncWithoutDetaching([
        //     $manageUsers->id, 
        //     $viewReports->id, 
        //     $editContent->id
        // ]);

        // $user->permissions()->syncWithoutDetaching([
        //     $viewReports->id, 
        //     $createResource->id, 
        //     $read->id, 
        //     $removeContent->id, 
        //     $editContent->id
        // ]);

        // $student->permissions()->syncWithoutDetaching([
        //     $viewReports->id
        // ]);
    }
}