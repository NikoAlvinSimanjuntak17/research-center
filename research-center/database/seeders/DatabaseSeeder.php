<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laratrust\Models\Role;
use Laratrust\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // Buat roles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ], [
            'display_name' => 'Administrator',
            'description' => 'Admin yang dapat mengelola sistem',
        ]);

        $researcherRole = Role::firstOrCreate([
            'name' => 'researcher',
        ], [
            'display_name' => 'Researcher',
            'description' => 'Peneliti di platform',
        ]);

        // Buat permissions
        $createResearcherPermission = Permission::firstOrCreate([
            'name' => 'create researcher',
        ], [
            'display_name' => 'Create Researcher',
            'description' => 'Dapat menambah akun peneliti',
        ]);

        // Hubungkan permission ke role admin
        if (!$adminRole->permissions->contains($createResearcherPermission->id)) {
            $adminRole->permissions()->attach($createResearcherPermission);
        }

        // Assign role dan permission ke user dengan email spesifik
        $adminUser = User::firstOrCreate(
            ['email' => 'johndoe@example.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password123'),
            ]
        );

        // Assign role ke user
        if (!$adminUser->hasRole('admin')) {
            $adminUser->addRole('admin');
        }

        // Berikan permission langsung ke user
        if (!$adminUser->can('create researcher')) {
            $adminUser->givePermission('create researcher');
        }
    }
}
