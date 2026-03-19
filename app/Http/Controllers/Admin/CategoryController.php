<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
class CategoryController extends Controller
{
public function index()
{
$categories = Category::latest()->paginate(10);
return view('admin.categories.index', compact('categories'));
}


public function create()
{
return view('admin.categories.create');
}


public function store(Request $request)
{
$data = $request->validate([
'name' => 'required|max:255|unique:categories,name',
'status' => 'required|boolean'
]);


$data['slug'] = Str::slug($data['name']);


Category::create($data);


return redirect()->route('admin.categories.index')->with('success','Category Created Successfully');
}


public function edit(Category $category)
{
return view('admin.categories.edit', compact('category'));
}


public function update(Request $request, Category $category)
{
$data = $request->validate([
'name' => 'required|max:255|unique:categories,name,' . $category->id,
'status' => 'required|boolean'
]);


$data['slug'] = Str::slug($data['name']);


$category->update($data);


return redirect()->route('admin.categories.index')->with('success','Category Updated Successfully');
}


public function destroy(Category $category)
{
$category->delete();
return back()->with('success','Category Deleted Successfully');
}
}