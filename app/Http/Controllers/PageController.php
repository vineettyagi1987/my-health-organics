<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
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
        return view('pages.benefits');
    }

    public function gallery()
    {
        return view('pages.gallery');
    }

    public function career()
    {
        return view('pages.career');
    }
}
