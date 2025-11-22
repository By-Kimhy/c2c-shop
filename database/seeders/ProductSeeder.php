<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // get 1 seller or create one
        $seller = User::first() ?? User::factory()->create([
            'name' => 'Demo Seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('12345678'),
        ]);

        // create 3 categories if not exists
        $categories = Category::pluck('id')->toArray();
        if (count($categories) < 3) {
            $categories = [];
            $categories[] = Category::create(['name' => 'Electronics'])->id;
            $categories[] = Category::create(['name' => 'Clothes'])->id;
            $categories[] = Category::create(['name' => 'Home'])->id;
        }

        // generate 20 products
        for ($i = 1; $i <= 20; $i++) {
            Product::create([
                'name' => "Sample Product $i",
                'slug' => Str::slug("sample-product-$i-".Str::random(4)),
                'price' => rand(5, 500),
                'stock' => rand(0, 50),
                'description' => "This is sample product number $i.",
                'status' => 'published',
                'user_id' => $seller->id,
                'category_id' => $categories[array_rand($categories)],
                'images' => [
                    "demo/sample" . rand(1, 3) . ".jpg"
                ],
            ]);
        }

        echo "✔ 20 products seeded successfully.\n";
    }
}
