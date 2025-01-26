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

    // Add any custom methods related to the Product model here
    public function getByCategory(string $category): LengthAwarePaginator
    {
        return $this->model->where('category', $category)->paginate(10);
    }

    public function getFiltered(array $filters, $page, $perPage)
    {
        $query = $this->model;
        Log::info('name searched',[$filters]);

        if ($filters && isset($filters['name']) && $filters['name']) {
            $query = $query->where('name', 'like', '%' . $filters['name'] . '%');
            Log::info('name searched::'.$filters['name']);

        }

        if ($filters && isset($filters['category']) && $filters['category']) {
            $query =$query->where('category', $filters['category']);
        }

        if ($filters && isset($filters['priceRange']) && is_array($filters['priceRange']) && count($filters['priceRange']) === 2) {
            $minPrice = min($filters['priceRange'][0], $filters['priceRange'][1]);
            $maxPrice = max($filters['priceRange'][0], $filters['priceRange'][1]);
            $query =$query->whereBetween('price', [$minPrice, $maxPrice]);
        }
        Log::info('SQL Query', [$query->toSql()]);

        return $query->paginate($perPage, ['id', 'name', 'price', 'category', 'image_url'], 'page', $page);
    }
}
