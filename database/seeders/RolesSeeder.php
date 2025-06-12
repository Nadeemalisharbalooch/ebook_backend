<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = 'web';
        $roles = [
            ['name' => 'superadmin', 'guard_name' => $guardName],
            ['name' => 'tester', 'guard_name' => $guardName],
            ['name' => 'developer', 'guard_name' => $guardName],
            ['name' => 'admin', 'guard_name' => $guardName],
            ['name' => 'manager', 'guard_name' => $guardName],
            ['name' => 'staff', 'guard_name' => $guardName],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }

        // Assign roles to specific users if needed
        $this->assignRolesToUsers();
    }

    protected function assignRolesToUsers(): void
    {
        $users = [
            '1' => 'superadmin',
            '2' => 'tester',
            '3' => 'developer',
            '4' => 'admin',
            '5' => 'manager',
            '6' => 'staff',
        ];

        foreach ($users as $id => $roleName) {
            $user = User::where('id', $id)->first();
            if ($user) {
                $user->assignRole($roleName);
            }
        }
    }
}
