<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }



    public function getFiltered(array $filters, $page, $perPage)
    {
        $query = $this->model->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.id', 'products.name', 'products.price', 'products.category_id', 'products.image_url', 'categories.name as category_name'); // Unir con 'categories' y seleccionar el nombre de la categoría

        Log::info('name searched', [$filters]);

        if ($filters && isset($filters['name']) && $filters['name']) {
            $query = $query->where('products.name', 'like', '%' . $filters['name'] . '%');
            Log::info('name searched::' . $filters['name']);
        }

        if ($filters && isset($filters['category']) && $filters['category']) {
            $query = $query->where('products.category_id', $filters['category']);
        }

        if ($filters && isset($filters['priceRange']) && is_array($filters['priceRange']) && count($filters['priceRange']) === 2) {
            $minPrice = min($filters['priceRange'][0], $filters['priceRange'][1]);
            $maxPrice = max($filters['priceRange'][0], $filters['priceRange'][1]);
            Log::info('SQL $maxPrice', [$maxPrice]);
            Log::info('SQL $minPrice', [$minPrice]);

            $query = $query->whereBetween('products.price', [$minPrice, $maxPrice]);
        }

        Log::info('SQL Query', [$query->toSql()]);

        return $query->paginate($perPage, ['products.id', 'products.name', 'products.price', 'products.category_id', 'products.image_url', 'category_name'], 'page', $page);
    }

}
