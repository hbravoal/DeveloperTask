<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $categories = Category::all(); // Obtener todas las categorías existentes

        // Crear 100 productos
        for ($i = 0; $i < 100; $i++) {
            $category = $categories->random(); // Elegir una categoría aleatoria

            Product::firstOrCreate(
                ['name' => $faker->unique()->word], // Producto único por nombre
                [
                    'price' => $faker->randomFloat(2, 5, 500), // Precio aleatorio entre 5 y 500
                    'description' => $faker->sentence, // Descripción aleatoria
                    'category_id' => $category->id, // Asignar categoría aleatoria
                    'image_url' => $faker->imageUrl(640, 480, 'product', true), // URL de imagen aleatoria
                ]
            );
        }
    }
}
