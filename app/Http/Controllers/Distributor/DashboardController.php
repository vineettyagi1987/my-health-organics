<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeSale;
use App\Services\WalletService;
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
          $request->validate([
            'product_name'=>'required',
            'quantity'=>'required|numeric',
            'amount'=>'required|numeric',
            'sale_date'=>'required|date'
        ]);
          $user = Auth::user();
        $sale = EmployeeSale::create([
            'user_id'=>$user->id,
            'product_name'=>$request->product_name,
            'quantity'=>$request->quantity,
            'amount'=>$request->amount,
            'sale_date'=>$request->sale_date
        ]);

        // Commission calculation
        $commissionRate = $user->commission_rate ?? 0;

        $commission = ($sale->amount * $commissionRate)/100;

        if($commission > 0){

            WalletService::credit(
                $user->id,
                $commission,
                'Distributor Sale Commission',
                $sale->id
            );

        }

        return back()->with('success','Sale Added & Commission Credited');

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
         $request->validate([
            'product_name'=>'required',
            'quantity'=>'required|numeric',
            'amount'=>'required|numeric',
            'sale_date'=>'required|date'
        ]);
        $sale = EmployeeSale::findOrFail($id);

        if($sale->user_id != Auth::id()){
            abort(403);
        }
        $oldAmount = $sale->amount;
        $sale->update([
            'product_name'=>$request->product_name,
            'quantity'=>$request->quantity,
            'amount'=>$request->amount,
            'sale_date'=>$request->sale_date
        ]);
         $user = Auth::user();

        $commissionRate = $user->commission_rate ?? 0;

        $oldCommission = ($oldAmount * $commissionRate)/100;
        $newCommission = ($sale->amount * $commissionRate)/100;

        // adjust wallet difference
        $difference = $newCommission - $oldCommission;

        if($difference > 0){

            WalletService::credit(
                $user->id,
                $difference,
                'Distributor Sale Adjustment',
                $sale->id.'-update'
            );

        }

        if($difference < 0){

            WalletService::debit(
                $user->id,
                abs($difference),
                'Distributor Sale Adjustment'
            );

        }

        return redirect()->route('distributor.dashboard')
        ->with('success','Sales Updated');

    }

}