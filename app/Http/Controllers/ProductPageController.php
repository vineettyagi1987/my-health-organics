<?php
namespace App\Http\Controllers;

use App\Models\Product;

class ProductPageController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('frontend.products.index', compact('products'));
    }
}
