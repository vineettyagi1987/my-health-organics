<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::latest()->paginate(10);
        return view('admin.terms.index', compact('terms'));
    }

    public function create()
    {
        return view('admin.terms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        Term::create($data);

        return redirect()->route('admin.terms.index')->with('success', 'Term created successfully.');
    }

    public function edit(Term $term)
    {
        return view('admin.terms.edit', compact('term'));
    }

    public function update(Request $request, Term $term)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $term->update($data);

        return redirect()->route('admin.terms.index')->with('success', 'Term updated successfully.');
    }

    public function destroy(Term $term)
    {
        $term->delete();
        return back()->with('success', 'Term deleted successfully.');
    }
}

