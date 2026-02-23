<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawalRequest;
use WalletService;
class AdminWithdrawalController extends Controller
{

public function index()
{

    $withdrawals = WithdrawalRequest::with('user')
    ->latest()
    ->paginate(20);

    return view('admin.withdrawals.index',compact('withdrawals'));

}


public function approve($id)
{

    $withdraw = WithdrawalRequest::findOrFail($id);

    $user = $withdraw->user;

    $user->wallet->decrement('balance',$withdraw->amount);

    $withdraw->update([
    'status'=>'approved'
    ]);

    return back();

}

}
