<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  \App\Models\Category::factory(7)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('category')->insert([
            ['name' => 'Shoes'],
            ['name' => 'Coat'],
            ['name' => 'Jacket'],
            ['name' => 'Trousers'],
            ['name' => 'Sweetshirt'],
        ]);
    }
}
