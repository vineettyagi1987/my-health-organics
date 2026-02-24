<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeSale;

class DistributorDashboardController extends Controller
{

    public function index(Request $request)
    {

        $distributors = User::where('role','distributor')->get();

        $selectedDistributor = $request->distributor_id;

        $sales = collect();
        $products = collect();
        $totalCollection = 0;
        $commissionRate = 0;
        $totalCommission = 0;

        if($selectedDistributor){

            $user = User::find($selectedDistributor);

            $sales = EmployeeSale::where('user_id',$selectedDistributor)
                    ->orderBy('sale_date','desc')
                    ->paginate(10);

            $products = EmployeeSale::where('user_id',$selectedDistributor)
                    ->selectRaw('product_name, SUM(quantity) as qty')
                    ->groupBy('product_name')
                    ->get();

            $totalCollection = EmployeeSale::where('user_id',$selectedDistributor)
                    ->sum('amount');

            $commissionRate = $user->commission_rate ?? 0;

            $totalCommission = ($totalCollection * $commissionRate) / 100;
        }

        return view('admin.distributor.dashboard',compact(
            'distributors',
            'sales',
            'products',
            'totalCollection',
            'commissionRate',
            'totalCommission',
            'selectedDistributor'
        ));

    }

}