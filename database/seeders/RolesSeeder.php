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
        $roles = [
            ['name' => 'superadmin'],
            ['name' => 'tester'],
            ['name' => 'developer'],
            ['name' => 'admin'],
            ['name' => 'manager'],
            ['name' => 'staff'],
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
            'superadmin@shaz3e.com' => 'superadmin',
            'tester@shaz3e.com' => 'tester',
            'developer@shaz3e.com' => 'developer',
            'admin@shaz3e.com' => 'admin',
            'manager@shaz3e.com' => 'manager',
            'staff@shaz3e.com' => 'staff',
        ];

        foreach ($users as $email => $roleName) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->assignRole($roleName);
            }
        }
    }
}
