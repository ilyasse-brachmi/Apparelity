<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        User::create([
            'id'=>'1',
            'name' => 'name1',
            'email' => 'name1@gmail.com',
            'is_admin' => false,
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'remember_token' => str::random(10),
        ]);

        User::create([
            'id'=>'2',
            'name' => 'name2',
            'email' => 'name2@gmail.com',
            'is_admin' => false,
            'email_verified_at' => now(),
            'password' => Hash::make('password456'),
            'remember_token' => str::random(10),
        ]);
        User::create([
            'id'=>'3',
            'name' => 'name3',
            'email' => 'name3@gmail.com',
            'is_admin' => false,
            'email_verified_at' => now(),
            'password' => Hash::make('password789'),
            'remember_token' => str::random(10),
        ]);
        User::create([
            'id'=>'4',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'is_admin' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => str::random(10),
        ]);
    }
}
