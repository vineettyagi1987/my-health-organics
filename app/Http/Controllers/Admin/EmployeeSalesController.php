<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeSale;
use App\Models\User;

class EmployeeSalesController extends Controller
{

  public function index(Request $request)
{

    $query = EmployeeSale::with('user')
        ->whereHas('user', function($q){
            $q->where('role', 'employee');
        })
        ->orderBy('sale_date','desc');

    if($request->employee_id){
        $query->where('user_id',$request->employee_id);
    }

    $sales = $query->paginate(10);

    $employees = User::where('role','employee')->get();

    $totalCollection = EmployeeSale::whereHas('user', function($q){
        $q->where('role','employee');
    })->sum('amount');

    return view('admin.sales.index',compact(
        'sales',
        'employees',
        'totalCollection'
    ));
}

}