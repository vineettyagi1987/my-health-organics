<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeTarget;
use App\Models\User;

class EmployeeTargetController extends Controller
{

    public function index()
    {
        $targets = EmployeeTarget::with('user')->get();
        return view('admin.targets.index', compact('targets'));
    }


    public function create()
    {
        $employees = User::where('role','employee')->get();
        return view('admin.targets.create', compact('employees'));
    }


    public function store(Request $request)
    {
        EmployeeTarget::create([
            'user_id'=>$request->user_id,
            'weekly_target'=>$request->weekly_target
        ]);

        return redirect()->route('admin.targets.index')->with('success','Target Added');
    }


    public function edit($id)
    {
        $target = EmployeeTarget::findOrFail($id);
        $employees = User::where('role','employee')->get();

        return view('admin.targets.edit',compact('target','employees'));
    }


    public function update(Request $request,$id)
    {
        $target = EmployeeTarget::findOrFail($id);

        $target->update([
            'user_id'=>$request->user_id,
            'weekly_target'=>$request->weekly_target
        ]);

        return redirect()->route('admin.targets.index')->with('success','Target Updated');
    }


    public function destroy($id)
    {
        EmployeeTarget::destroy($id);
        return back()->with('success','Target Deleted');
    }

}
