<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
class ProductController extends Controller
{
    /**
     * Product listing page
     */
public function index(Request $request)
{
    $allowedCategories = [
        'Family Care',
        'Personal Care',
        'Organic prducts',
        'Aayurvedic Products',
        'Home & Office Care',
        'Agro Care',
        'Vetorinary Care',
        'Life Care'
    ];

    // Get only allowed categories for dropdown
    $categories = Category::whereIn('name', $allowedCategories)->get();

    $products = Product::where('status', 1)
        ->whereHas('category', function ($query) use ($allowedCategories, $request) {
            $query->whereIn('name', $allowedCategories);

            // If category selected from dropdown
            if ($request->category) {
                $query->where('id', $request->category);
            }
        })
        ->latest()
        ->paginate(12);

    return view('products.index', compact('products', 'categories'));
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
