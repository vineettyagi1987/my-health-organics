<?php

namespace App\Http\Controllers\Admin;

use App\Models\Benefit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {
       
        $benefits = Benefit::latest()->paginate(10);
        return view('admin.benefits.index', compact('benefits'));
    }

    public function create()
    {
        return view('admin.benefits.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'boolean'
        ]);

        Benefit::create($data);

        return redirect()->route('admin.benefits.index')->with('success', 'Benefit created');
    }

    public function edit(Benefit $benefit)
    {
        return view('admin.benefits.edit', compact('benefit'));
    }

    public function update(Request $request, Benefit $benefit)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'boolean'
        ]);

        $benefit->update($data);

        return redirect()->route('admin.benefits.index')->with('success', 'Updated');
    }

    public function destroy(Benefit $benefit)
    {
        $benefit->delete();
        return back()->with('success', 'Deleted');
    }
}

