<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeSale;
use App\Models\EmployeeTarget;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {

        $userId = Auth::id();

       $sales = EmployeeSale::where('user_id',$userId)
        ->orderBy('sale_date','desc')
        ->paginate(10);

        $totalCollection = EmployeeSale::where('user_id',$userId)
                ->sum('amount');

        $products = EmployeeSale::where('user_id',$userId)
                ->selectRaw('product_name, SUM(quantity) as qty')
                ->groupBy('product_name')
                ->get();

        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $weeklySale = EmployeeSale::where('user_id',$userId)
                ->whereBetween('sale_date',[$weekStart,$weekEnd])
                ->sum('amount');

        $target = EmployeeTarget::where('user_id',$userId)->first();

        return view('employee.dashboard',compact(
            'sales',
            'totalCollection',
            'products',
            'weeklySale',
            'target'
        ));
    }

    public function store(Request $request)
    {

        EmployeeSale::create([
            'user_id'=>Auth::id(),
            'product_name'=>$request->product_name,
            'quantity'=>$request->quantity,
            'amount'=>$request->amount,
            'sale_date'=>$request->sale_date
        ]);

        return back()->with('success','Sale Added');
    }

    public function edit($id)
{
    $sale = EmployeeSale::findOrFail($id);

    // ensure employee edits only his sale
    if($sale->user_id != auth()->id()){
        abort(403);
    }

    return view('employee.edit_sale',compact('sale'));
}



public function update(Request $request,$id)
{
    $sale = EmployeeSale::findOrFail($id);

    if($sale->user_id != auth()->id()){
        abort(403);
    }

    $sale->update([
        'product_name'=>$request->product_name,
        'quantity'=>$request->quantity,
        'amount'=>$request->amount,
        'sale_date'=>$request->sale_date
    ]);

    return redirect()->route('employee.dashboard')
           ->with('success','Sales Report Updated');
}

}
