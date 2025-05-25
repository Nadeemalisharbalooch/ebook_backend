<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                // 1
                'username' => 'superadmin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'name' => 'Super Admin',
                'email' => 'superadmin@shaz3e.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 2
                'username' => 'developer',
                'first_name' => 'Developer',
                'last_name' => 'Developer',
                'name' => 'Developer',
                'email' => 'developer@shaz3e.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 3
                'username' => 'tester',
                'first_name' => 'Tester',
                'last_name' => 'Tester',
                'name' => 'Tester',
                'email' => 'tester@shaz3e.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 4
                'username' => 'admin',
                'first_name' => 'Main',
                'last_name' => 'Admin',
                'name' => 'Main Admin',
                'email' => 'admin@shaz3e.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 5
                'username' => 'manager',
                'first_name' => 'Manager',
                'last_name' => 'Manager',
                'name' => 'Manager',
                'email' => 'manager@shaz3e.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 6
                'username' => 'staff',
                'first_name' => 'Staff',
                'last_name' => 'Staff',
                'name' => 'Staff',
                'email' => 'staff@shaz3e.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
        ];

        DB::table('users')->insert($users);

        // Create Profiles
        DB::table('profiles')->insert([
            ['user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);

        if (app()->environment('local')) {
            $users = [
                [
                    // 7
                    'username' => 'userone',
                    'first_name' => 'User',
                    'last_name' => 'One',
                    'name' => 'user',
                    'email' => 'user1@shaz3e.com',
                    'password' => bcrypt('123456789'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'is_admin' => false,
                ],
                [
                    // 8
                    'username' => 'usertwo',
                    'first_name' => 'User',
                    'last_name' => 'Two',
                    'name' => 'user',
                    'email' => 'user2@shaz3e.com',
                    'password' => bcrypt('123456789'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'is_admin' => false,
                ],
                [
                    // 9
                    'username' => 'userthree',
                    'first_name' => 'User',
                    'last_name' => 'Three',
                    'name' => 'user',
                    'email' => 'user3@shaz3e.com',
                    'password' => bcrypt('123456789'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'is_admin' => false,
                ],
                [
                    // 10
                    'username' => 'userfour',
                    'first_name' => 'User',
                    'last_name' => 'Four',
                    'name' => 'user',
                    'email' => 'user4@shaz3e.com',
                    'password' => bcrypt('123456789'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'is_admin' => false,
                ],
            ];

            DB::table('users')->insert($users);

            // Create Profiles
            DB::table('profiles')->insert([
                ['user_id' => 7, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => 8, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => 9, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
