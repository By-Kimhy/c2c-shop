<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller = \App\Models\User::where('role','seller')->first();
        $categories = \App\Models\Category::all();
        foreach(range(1,12) as $i){
            $cat = $categories->random();
            \App\Models\Product::create([
                'user_id'=>$seller->id,
                'category_id'=>$cat->id,
                'name'=>"Sample Product {$i}",
                'slug'=>\Str::slug("sample-product-{$i}"),
                'description'=>"Demo description for product {$i}",
                'price'=>rand(50,500)*100,
                'stock'=>rand(1,50),
                'status'=>'published',
                'images'=>json_encode(['frontend/assets/img/demo-product.png']),
            ]);
        }
    }
}
