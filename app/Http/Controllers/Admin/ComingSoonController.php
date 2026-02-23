<?php

namespace App\Http\Controllers\Admin;
use App\Models\ComingSoonItem;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller; 
class ComingSoonController extends Controller
{

    public function index()
    {
        $items = ComingSoonItem::latest()->paginate(10);

        return view('admin.comingsoon.index',compact('items'));
    }

    public function create()
    {
        return view('admin.comingsoon.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required',
            'type'=>'required',
            'description'=>'nullable',
            'launch_date'=>'nullable',
            'location'=>'nullable',
            'image'=>'nullable|image'
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('comingsoon','public');
        }

        ComingSoonItem::create($data);

        return redirect()->route('admin.comingsoon.index')
               ->with('success','Coming Soon item created successfully');
    }

    public function edit($id)
    {
        $item = ComingSoonItem::findOrFail($id);

        return view('admin.comingsoon.edit',compact('item'));
    }

    public function update(Request $request,$id)
    {
        $item = ComingSoonItem::findOrFail($id);

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('comingsoon','public');
        }

        $item->update($data);

        return redirect()->route('admin.comingsoon.index')
                ->with('success','Coming Soon item updated successfully');
    }

    public function destroy($id)
    {
        ComingSoonItem::findOrFail($id)->delete();

        return back()->with('success','Coming Soon item deleted successfully');
    }
}