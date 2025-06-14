<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Researcher;
use Laratrust\Models\Role;
use Laratrust\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Buat permission
        $createResearcher = Permission::firstOrCreate(['name' => 'create researcher']);

        // Buat role dan berikan permission
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $researcherRole = Role::firstOrCreate(['name' => 'researcher']);

        // Berikan permission hanya ke admin
        $adminRole->hasPermission($createResearcher);
    }
}
