<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use Illuminate\Support\Facades\Storage;
class FacultyController extends Controller
{

    public function index()
    {
       $faculties = Faculty::latest()->paginate(10); // 10 records per page

    return view('admin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculties.create');
    }

    public function store(Request $request)
    {
       $request->validate([
            'name'  => 'required',
            'email' => 'nullable|email',
             'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){

            $data['image'] = $request->file('image')->store('faculties','public');

        }

        Faculty::create($data);

        return redirect()->route('admin.faculties.index')
            ->with('success','Member Added');
    }

    public function edit($id)
    {
        $faculty = Faculty::findOrFail($id);
        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'designation' => 'nullable|string|max:255',
        'qualifications' => 'nullable|string',
        'bio' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);


    $faculty = Faculty::findOrFail($id);

    $data = $request->only([
        'name',
        'email',
        'designation',
        'qualifications',
        'bio'
    ]);


    if($request->hasFile('image')){

        if($faculty->image){
            Storage::disk('public')->delete($faculty->image);
        }

        $image = $request->file('image');
        $filename = time().'_'.$image->getClientOriginalName();

        $data['image'] = $image->storeAs('faculties',$filename,'public');
    }


    $faculty->update($data);

    return redirect()->route('admin.faculties.index')
        ->with('success','Member Updated');
    }

    public function destroy($id)
    {
        Faculty::destroy($id);

        return redirect()->route('admin.faculties.index')
            ->with('success','Member Deleted');
    }
}