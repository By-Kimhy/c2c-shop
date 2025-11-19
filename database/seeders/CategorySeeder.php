<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['Electronics', 'Fashion', 'Home'])->each(function ($name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        });
    }
}