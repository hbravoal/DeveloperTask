<?php

namespace App\Providers;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Models\Product;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository(new Product());
        });
        $this->app->bind(CategoryRepository::class, function ($app) {
            return new CategoryRepository(new Category());
        });
    }

    public function boot()
    {
    }
}
