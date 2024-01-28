<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_types = [
            [
                'value' => 'super_admin',
                'description' => 'super admin have access to all functions',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'value' => 'librarian',
                'description' => 'librarian can create/update/delete staffs, user, and books',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'value' => 'staff',
                'description' => 'staff can create/update books and can view users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'value' => 'member',
                'description' => 'member can view books and can borrow',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('user_types')->insert($user_types);
    }
}
