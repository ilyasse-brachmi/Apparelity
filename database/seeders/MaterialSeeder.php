<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Material::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Material::create([
            'product_id' => '1',
            'name' => 'Cotton',
            'origin' => 'Morroco',
            'supplier' => 'test',
            'address' => 'Morroco,fes av bayrouth',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Material::create([
            'product_id' => '1',
            'name' => 'material2',
            'origin' => 'France',
            'supplier' => 'test',
            'address' => 'France,Paris etc',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Material::create([
            'product_id' => '2',
            'name' => 'material1',
            'origin' => 'Tunusie',
            'supplier' => 'test',
            'address' => 'Tunusie,Tunusie etc',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Material::create([
            'product_id' => '2',
            'name' => 'material2',
            'origin' => 'adrabijan',
            'supplier' => 'test',
            'address' => 'adrabijan,adrabijan etc',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Material::create([
            'product_id' => '2',
            'name' => 'material3',
            'origin' => 'Tunusie',
            'supplier' => 'test',
            'address' => 'Tunusie,Tunusie etc',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
