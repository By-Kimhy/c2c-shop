<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $names = ['Electronics', 'Fashion', 'Home & Garden', 'Sports', 'Toys'];
        foreach ($names as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
