<?php
namespace App\Repositories;

use App\Models\Product;

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
}
