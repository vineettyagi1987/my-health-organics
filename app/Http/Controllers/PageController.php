<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Benefit;
use App\Models\Gallery;
use App\Models\Term;
use App\Models\Faq;
use App\Models\Career;
use App\Models\ComingSoonItem;
class PageController extends Controller
{
    public function home()
    {
         $products = Product::where('status', 1)->latest()->get();
        return view('pages.home', compact('products'));
       
    }

    public function products()
    {
        return view('pages.products');
    }

    public function events()
    {
        return view('pages.events');
    }

    public function guidance()
    {
        return view('pages.guidance');
    }

    public function yoga()
    {
        return view('pages.yoga');
    }

    public function benefits()
    {
        $benefits = Benefit::where('status', 1)->latest()->get();
        $terms = Term::latest()->get();
        return view('pages.benefits', compact('benefits', 'terms'));
    }

    public function gallery()
    {
        $galleries = Gallery::latest()->paginate(10);
         $faqs = Faq::where('status', 1)
        ->latest()
        ->get();
        $items = ComingSoonItem::where('status','active')
                    ->orderBy('launch_date','asc')
                    ->get();
        return view('pages.gallery', compact('galleries', 'faqs', 'items'));
    }

    public function career()
    {
         $career = Career::first();
        
        return view('pages.career', compact('career'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        

        // You can store in DB or send email here

        return back()->with('success', 'Your message has been submitted successfully.');
    }
}
