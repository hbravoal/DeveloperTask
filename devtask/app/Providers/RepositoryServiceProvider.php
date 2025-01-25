<?php

namespace App\Providers;

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
    }

    public function boot()
    {
    }
}
