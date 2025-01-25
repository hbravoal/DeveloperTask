<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    // Fetch all products with pagination
    public function index()
    {
        $products = $this->productRepository->getAll();
        return response()->json($products);
    }

    // Fetch a single product by ID
    public function show($id)
    {
        $product = $this->productRepository->getById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    private function fetchImageFromAPI()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://picsum.photos/200/300');

        // La respuesta es una redirección a la URL de la imagen
        $imageUrl = $response->getHeaderLine('Location');
        return $imageUrl;
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category' => 'required|string',
            'image_url' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            // Upload the image to an external service
            $imageUrl = $this->uploadImageToExternalService($request->file('image'));
        } else {
            // Fetch a random image from an external API
            $imageUrl = $this->fetchImageFromAPI($request->input('name'));
        }
            $data = $request->all();
        $data['image_url'] = $imageUrl;

        $product = $this->productRepository->create($data);

        return response()->json($product, 201);
    }




    // Update a product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category' => 'required|string',
            'image_url' => 'nullable|image',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadImageToExternalService($request->file('image'));
            $data['image_url'] = $imageUrl;
        }

        $product = $this->productRepository->update($id, $data);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    // Delete a product
    public function destroy($id)
    {
        $deleted = $this->productRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product deleted']);
    }

    // Helper function to upload the image to an external service
    private function uploadImageToExternalService($image)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://external-image-service.com/upload', [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($image->getPathname(), 'r'),
                    'filename' => $image->getClientOriginalName(),
                ]
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['url'];  // Assuming the response contains the image URL
    }

}
