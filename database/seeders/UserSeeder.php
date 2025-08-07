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
                'first_name'=>'nadeem',
                'last_name'=>'ali',
                'username' => 'superadmin',
                'email' => 'nadeem123@gmail.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'role'=>'admin',
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 2
                'first_name'=>'naseer',
                'last_name'=>'ali',
                'username' => 'naseer123',
                'email' => 'naseer123@gmail.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'role'=>'publisher',
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                // 3
                'first_name'=>'ghaffar',
                'last_name'=>'ali',
                'username' => 'ghaffar123',
                'email' => 'ghaffar123@gmail.com',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
                'role'=>'customer',
                'is_active' => true,
                'is_admin' => false,
            ],

        ];

        DB::table('users')->insert($users);

        // Create Profiles
        DB::table('profiles')->insert([
            ['user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'created_at' => now(), 'updated_at' => now()],

        ]);


    }
}
