<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeSale;
use Auth;

class DashboardController extends Controller
{

    public function index()
    {

        $user = Auth::user();

        $sales = EmployeeSale::where('user_id',$user->id)
                ->orderBy('sale_date','desc')
                ->paginate(10);

        $totalCollection = EmployeeSale::where('user_id',$user->id)
                ->sum('amount');

        $products = EmployeeSale::where('user_id',$user->id)
                ->selectRaw('product_name, SUM(quantity) as qty')
                ->groupBy('product_name')
                ->get();

        $commissionRate = $user->commission_rate;

        $totalCommission = ($totalCollection * $commissionRate)/100;

        return view('distributor.dashboard',compact(
            'sales',
            'totalCollection',
            'products',
            'commissionRate',
            'totalCommission'
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

        if($sale->user_id != Auth::id()){
            abort(403);
        }

        return view('distributor.edit_sale',compact('sale'));
    }



    public function update(Request $request,$id)
    {

        $sale = EmployeeSale::findOrFail($id);

        if($sale->user_id != Auth::id()){
            abort(403);
        }

        $sale->update([
            'product_name'=>$request->product_name,
            'quantity'=>$request->quantity,
            'amount'=>$request->amount,
            'sale_date'=>$request->sale_date
        ]);

        return redirect()->route('distributor.dashboard')
        ->with('success','Sales Updated');

    }

}