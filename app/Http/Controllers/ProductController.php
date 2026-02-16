<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Product listing page
     */
    public function index()
    {
        $products = Product::where('status', 1)
            ->latest()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Product details page
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
