<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Services\ReferralService;
class WalletController extends Controller
{

public function index(ReferralService $referralService)
{

    $user = auth()->user();
     $levels = $referralService->getLevels($user->my_referral_code);

    $commissionSummary = [];

    if(!empty($levels)){
   
    $commissionSummary = $referralService->calculateLevelCommission($levels, $user);
    }

    $wallet = $user->wallet;
    $transactions = WalletTransaction::where('user_id',$user->id)
    ->latest()
    ->paginate(10);
    return view('user.wallet.index',compact('wallet','transactions'));

}

}