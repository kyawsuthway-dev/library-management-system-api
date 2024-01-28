<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'superadmin@gmail.com',
                'user_type_id' => 1,
                'status' => 'active',
                'password' => Hash::make('StrongPassword'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'first_name' => 'Su',
                'last_name' => 'Su',
                'email' => 'susu@gmail.com',
                'user_type_id' => 2,
                'status' => 'active',
                'password' => Hash::make('StrongPassword'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'first_name' => 'Kyaw',
                'last_name' => 'Kyaw',
                'email' => 'kyawkyaw@gmail.com',
                'user_type_id' => 3,
                'status' => 'active',
                'password' => Hash::make('StrongPassword'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'first_name' => 'Aung',
                'last_name' => 'Aung',
                'email' => 'aungaung@gmail.com',
                'user_type_id' => 4,
                'status' => 'active',
                'password' => Hash::make('StrongPassword'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('users')->insert($users);
    }
}
