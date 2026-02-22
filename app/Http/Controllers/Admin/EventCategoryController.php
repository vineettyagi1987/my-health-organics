<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventCategory;

class EventCategoryController extends Controller
{

    public function index()
    {
        $categories = EventCategory::latest()->get();

        return view('admin.event_categories.index',compact('categories'));
    }


    public function create()
    {
        return view('admin.event_categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
    'name' => 'required|unique:event_categories,name'
]);
        EventCategory::create($request->all());

        return redirect()->route('admin.event_categories.index')
            ->with('success','Category Created');
    }


    public function edit($id)
    {
        $category = EventCategory::findOrFail($id);

        return view('admin.event_categories.edit',compact('category'));
    }


    public function update(Request $request,$id)
    {
        $request->validate([
        'name' => 'required|unique:event_categories,name,' . $id
    ]);

        $category = EventCategory::findOrFail($id);

        $category->update($request->all());

        return redirect()->route('admin.event_categories.index')
            ->with('success','Category Updated');
    }


    public function destroy($id)
    {
        EventCategory::destroy($id);

        return redirect()->route('admin.event_categories.index')
            ->with('success','Category Deleted');
    }

}