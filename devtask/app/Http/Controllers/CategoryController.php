<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {

        Log::info('response',[$this->categoryRepository]);
        $response = $this->categoryRepository->getAll();
        return response()->json($response);
    }

}
