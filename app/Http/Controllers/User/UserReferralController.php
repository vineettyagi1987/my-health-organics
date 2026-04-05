<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Services\WalletService;
use App\Services\ReferralService;

class UserReferralController extends Controller
{

public function index(ReferralService $referralService)
{
   
    $user = auth()->user();
     $checkSubs = User::whereHas('activeSubscription')->where('my_referral_code',$user->my_referral_code)->first();
     if(!$checkSubs){
      
      return redirect()->route('subscription.profile')->with('error','Please activate your subscription to access referral tree');
     }
   
    $levels = $referralService->getLevels($user->my_referral_code);

    $commissionSummary = [];

    if(!empty($levels)){
   // $commissionSummary = $this->calculateLevelCommission($levels);
    $commissionSummary = $referralService->calculateLevelCommission($levels, $user);
    }

    return view('user.referral.tree',compact('levels','commissionSummary'));

}

}