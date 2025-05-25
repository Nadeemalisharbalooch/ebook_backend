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
                'name' => 'Super Admin',
                'email' => 'superadmin@dc.com.pk',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 2
                'username' => 'developer',
                'name' => 'Developer',
                'email' => 'developer@dc.com.pk',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 3
                'username' => 'tester',
                'name' => 'Tester',
                'email' => 'tester@dc.com.pk',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 4
                'username' => 'admin',
                'name' => 'Main Admin',
                'email' => 'admin@dc.com.pk',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 5
                'username' => 'manager',
                'name' => 'Manager',
                'email' => 'manager@dc.com.pk',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 6
                'username' => 'staff',
                'name' => 'Staff',
                'email' => 'staff@dc.com.pk',
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
                    'name' => 'user',
                    'email' => 'user1@dc.com.pk',
                    'password' => bcrypt('123456789'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'is_admin' => false,
                ],
                [
                    // 8
                    'username' => 'usertwo',
                    'name' => 'user',
                    'email' => 'user2@dc.com.pk',
                    'password' => bcrypt('123456789'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'is_admin' => false,
                ],
                [
                    // 9
                    'username' => 'userthree',
                    'name' => 'user',
                    'email' => 'user3@dc.com.pk',
                    'password' => bcrypt('123456789'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'is_admin' => false,
                ],
                [
                    // 10
                    'username' => 'userfour',
                    'name' => 'user',
                    'email' => 'user4@dc.com.pk',
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
