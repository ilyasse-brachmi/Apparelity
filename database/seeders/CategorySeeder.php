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
            ['id'=>'1','name' => 'Shoes','created_at' => now(),'updated_at' => now()],
            ['id'=>'2','name' => 'Coat','created_at' => now(),'updated_at' => now()],
            ['id'=>'3','name' => 'Jacket','created_at' => now(),'updated_at' => now()],
            ['id'=>'4','name' => 'Trousers','created_at' => now(),'updated_at' => now()],
            ['id'=>'5','name' => 'Sweetshirt','created_at' => now(),'updated_at' => now()],
        ]);
    }
}
