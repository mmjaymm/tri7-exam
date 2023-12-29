<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => Str::random(10),
                'username' => 'manager@gmail.com',
                'password' => Hash::make('web_manager'),
                'role' => "Manager",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => Str::random(10),
                'username' => 'web_designer@gmail.com',
                'password' => Hash::make('web_designer'),
                'role' => "Web Designer",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => Str::random(10),
                'username' => 'web_developer@gmail.com',
                'password' => Hash::make('web_developer'),
                'role' => "Web Developer",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
