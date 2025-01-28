<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'All electronic devices and accessories.'],
            ['name' => 'Furniture', 'description' => 'Furniture for homes and offices.'],
            ['name' => 'Clothing', 'description' => 'Men and women clothing and apparel.'],
            ['name' => 'Sports', 'description' => 'Sports equipment and apparel.'],
            ['name' => 'Toys', 'description' => 'Toys and games for children.'],
            ['name' => 'Beauty', 'description' => 'Beauty products and accessories.'],
            ['name' => 'Books', 'description' => 'Books, novels, and educational materials.'],
            ['name' => 'Food & Drink', 'description' => 'Groceries and beverages.'],
            ['name' => 'Automotive', 'description' => 'Car parts and accessories.'],
            ['name' => 'Health', 'description' => 'Health products and supplements.']
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category['name']
            ], [
                'description' => $category['description']
            ]);
        }
    }
}
