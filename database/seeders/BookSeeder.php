<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'publisher_id' => 2,
                'category_id' => 1,
                'title' => 'Clean Code',
                'pages' => 434,
                'borrowed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'publisher_id' => 3,
                'category_id' => 1,
                'title' => 'Code Complete: A Practical Handbook of Software Construction, Second Edition',
                'pages' => 960,
                'borrowed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'publisher_id' => 1,
                'category_id' => 2,
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'pages' => 309,
                'borrowed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('books')->insert($books);
    }
}
