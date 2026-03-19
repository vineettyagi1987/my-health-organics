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
   // Get all categories except those containing specific keywords
    $categories = Category::where('name', 'NOT LIKE', '%Plastic Free%')
        ->where('name', 'NOT LIKE', '%Renewable Energy%')
        ->get();

    $products = Product::where('status', 1)
        ->whereHas('category', function ($query) use ($request) {

            // Exclude unwanted categories
            $query->where('name', 'NOT LIKE', '%Plastic Free%')
                  ->where('name', 'NOT LIKE', '%Renewable Energy%');

            // If category selected from dropdown
            if ($request->category) {
                $query->where('id', $request->category);
            }
        })
        ->latest()
        ->paginate(12);

    return view('products.index', compact('products', 'categories'));
}


public function energyProducts(Request $request)
{
    $keywords = [
        'Renewable Energy',
        'Plastic Free'
    ];

    // Get categories that contain the keywords
    $categories = Category::where(function ($query) use ($keywords) {
        foreach ($keywords as $keyword) {
            $query->orWhere('name', 'LIKE', "%{$keyword}%");
        }
    })->get();

    $products = Product::where('status', 1)
        ->whereHas('category', function ($query) use ($keywords, $request) {

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('name', 'LIKE', "%{$keyword}%");
                }
            });

            // If category selected from dropdown
            if ($request->category) {
                $query->where('id', $request->category);
            }
        })
        ->latest()
        ->paginate(12);

    return view('products.energyProducts', compact('products', 'categories'));
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
