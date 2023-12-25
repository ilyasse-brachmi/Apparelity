<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MediaUploader;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $product=new Product();
        $product->fill([
            'id'=>'1',
            'company_id' => '1',
            'category_id' => '1',
            'name' => 'hoodie',
            'price' => '150.00',
            'description' => 'Text Text',
            'address' => '535 Harley Brook Lane',
            'production_date' => '2023-06-07',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $product->save();
        $media=MediaUploader::fromSource(public_path('hoodie.jpg'))
            ->toDestination('local', 'public')
            ->useFilename(Str::uuid())
            ->makePrivate()
            ->onDuplicateReplace()
            ->upload();
        $product->attachMedia($media,'image_product');

        $product=new Product();
        $product->fill([
            'id'=>'2',
            'company_id' => '2',
            'category_id' => '2',
            'name' => 'shoes nike',
            'price' => '200.00',
            'address' => 'Avenue Moulay Hassan, BP : 209 Martil, Martil 93150',
            'description' => 'Text Text',
            'production_date' => '2023-07-07',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $product->save();
        $media=MediaUploader::fromSource(public_path('nikee.jpg'))
            ->toDestination('local', 'public')
            ->useFilename(Str::uuid())
            ->makePrivate()
            ->onDuplicateReplace()
            ->upload();
        $product->attachMedia($media,'image_product');
    }
}
