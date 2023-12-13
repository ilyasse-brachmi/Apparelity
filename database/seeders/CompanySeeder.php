<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Company::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Company::create([
            'user_id' => '1',
            'name' => 'Company1',
            'address' => 'Adress',
            'description' => 'description',
            'zipCode' => 12345,
            'country' => 'country',
            'city' => 'city',
            'phone' => '1234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Company::create([
            'user_id' => '2',
            'name' => 'Company2',
            'address' => 'Adress',
            'description' => 'description',
            'zipCode' => 12345,
            'country' => 'country',
            'city' => 'city',
            'phone' => '1234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Company::create([
            'user_id' => '3',
            'name' => 'Company3',
            'address' => 'Adress',
            'description' => 'description',
            'zipCode' => 12345,
            'country' => 'country',
            'city' => 'city',
            'phone' => '1234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
