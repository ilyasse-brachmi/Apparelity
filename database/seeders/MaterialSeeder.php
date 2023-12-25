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
            'supplier' => 'test',
            'address' => 'Av. Moulay Rachid, Martil 93159',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Material::create([
            'product_id' => '1',
            'name' => 'material2',
            'supplier' => 'test',
            'address' => 'Taşpazar, 804. Sk. No:9 D:C, 68100 Merkez/Aksaray, Turquie',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Material::create([
            'product_id' => '2',
            'name' => 'material1',
            'supplier' => 'test',
            'address' => '27QR+XH8, Jidka Afgooye, Mogadishu, Somalie',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Material::create([
            'product_id' => '2',
            'name' => 'material2',
            'supplier' => 'test',
            'address' => '255 Saint Asaph Street, Christchurch Central City, Christchurch 8011, Nouvelle-Zélande',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Material::create([
            'product_id' => '2',
            'name' => 'material3',
            'supplier' => 'test',
            'address' => '1 Chome-1-1 Uchisaiwaicho, Chiyoda City, Tokyo 100-0011, Japon',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
