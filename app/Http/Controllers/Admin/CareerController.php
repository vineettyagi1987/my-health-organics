<?php
namespace App\Http\Controllers\Admin;
use App\Models\Career;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class CareerController extends Controller
{
    public function index()
    {
       
        $career = Career::first();
        return view('admin.career.index', compact('career'));
    }

   public function store(Request $request)
{
   
    $request->validate([
        'objectives' => 'required',
        'sapath_patra' => 'required',
    ]);

    Career::updateOrCreate(
        ['id' => 1],
        [
            'objectives' => $request->objectives,
            'sapath_patra' => $request->sapath_patra,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'phone' => $request->phone,
            'email' => $request->email,
        ]
    );

    return back()->with('success', 'Career content updated successfully');
}
}