<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Str;
class ProductController extends Controller
{
public function index(Request $request)
{
    $query = Product::with('category');

    // Apply search filter
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('price', 'like', "%$search%")
              ->orWhereHas('category', function ($cat) use ($search) {
                  $cat->where('name', 'like', "%$search%");
              });
        });
    }

    $products = $query->latest()
        ->paginate(10)
        ->withQueryString(); // keeps search in pagination

    return view('admin.products.index', compact('products'));
}



public function create()
{
$categories = Category::pluck('name','id');
return view('admin.products.create', compact('categories'));
}


public function store(Request $request)
{
$data = $request->validate([
'category_id' => 'required|exists:categories,id',
'name' => 'required|max:255|unique:products,name',
'price' => 'required|numeric',
'stock'  => ['required','integer','min:0'],   // ← NEW
'description' => 'nullable',
'image' => 'nullable|image|max:2048',
'status' => 'required|boolean'
]);


$data['slug'] = Str::slug($data['name']);


if ($request->hasFile('image')) {
$data['image'] = $request->file('image')->store('products','public');
}


Product::create($data);


return redirect()->route('admin.products.index')->with('success','Product Created Successfully');
}


public function edit(Product $product)
{
$categories = Category::pluck('name','id');
return view('admin.products.edit', compact('product','categories'));
}


public function update(Request $request, Product $product)
{
$data = $request->validate([
'category_id' => 'required|exists:categories,id',
'name' => 'required|max:255|unique:products,name,' . $product->id,
'price' => 'required|numeric',
'stock'  => ['required','integer','min:0'],   // ← NEW
'description' => 'nullable',
'image' => 'nullable|image|max:2048',
'status' => 'required|boolean'
]);


$data['slug'] = Str::slug($data['name']);


if ($request->hasFile('image')) {
if (!empty($product->image) && Storage::disk('public')->exists($product->image)) {
    Storage::disk('public')->delete($product->image);
}
$data['image'] = $request->file('image')->store('products','public');
}


$product->update($data);


return redirect()->route('admin.products.index')->with('success','Product Updated Successfully');
}


public function destroy(Product $product)
{
Storage::disk('public')->delete($product->image);
$product->delete();
return redirect()->route('admin.products.index')->with('success','Product deleted successfully.');
}
}