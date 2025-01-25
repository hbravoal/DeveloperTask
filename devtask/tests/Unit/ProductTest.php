<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;  // This trait ensures the database is refreshed between tests.

    /**
     * Test to get a list of all products.
     *
     * @return void
     */
    public function test_can_get_all_products()
    {
        // Arrange: Create some products using a factory (assuming you have a Product factory).
        Product::factory()->count(10)->create();

        // Act: Send a GET request to the products API endpoint.
        $response = $this->getJson('/api/products');

        // Assert: Check the response status and structure.
        $response->assertStatus(200);  // Expecting status code 200 (OK).
        $response->assertJsonStructure([ // Check the structure of the returned JSON.
            '*' => [
                'id',
                'name',
                'price',
                'description',
                'category',
                'image_url',
            ]
        ]);
    }

    /**
     * Test to create a new product.
     *
     * @return void
     */
    public function test_can_create_product()
    {
        // Arrange: Set up the data for a new product.
        $productData = [
            'name' => 'New Product',
            'price' => 99.99,
            'description' => 'A brand new product.',
            'category' => 'Electronics',
            'image_url' => 'image-url.jpg'
        ];

        // Act: Send a POST request to the products API endpoint.
        $response = $this->postJson('/api/products', $productData);

        // Assert: Check if the response has status 201 (Created) and contains the data.
        $response->assertStatus(201);
        $response->assertJson($productData);  // Assert that the returned JSON matches the sent data.

        // Check if the product was actually saved in the database.
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'price' => 99.99,
        ]);
    }

    /**
     * Test to get a product by ID.
     *
     * @return void
     */
    public function test_can_get_product_by_id()
    {
        // Arrange: Create a product using the factory.
        $product = Product::factory()->create();

        // Act: Send a GET request to fetch the product by ID.
        $response = $this->getJson('/api/products/' . $product->id);

        // Assert: Check the response status and ensure the returned data matches the product.
        $response->assertStatus(200);
        $response->assertJsonFragment([ // Check if the response contains the product's name and ID.
            'id' => $product->id,
            'name' => $product->name
        ]);
    }

    /**
     * Test to update a product.
     *
     * @return void
     */
    public function test_can_update_product()
    {
        // Arrange: Create a product and set up the new data.
        $product = Product::factory()->create();
        $updatedData = [
            'name' => 'Updated Product',
            'price' => 120.00,
            'description' => 'Updated description',
            'category' => 'Home Appliances',
            'image_url' => 'updated-image-url.jpg'
        ];

        // Act: Send a PUT request to update the product.
        $response = $this->putJson('/api/products/' . $product->id, $updatedData);

        // Assert: Check the response and ensure the data was updated.
        $response->assertStatus(200);  // Expect a successful update response.
        $response->assertJsonFragment($updatedData);  // Ensure the updated data is returned.

        // Check that the product data is updated in the database.
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product'
        ]);
    }


}
