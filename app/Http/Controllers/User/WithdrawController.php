<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawalRequest;
use App\Services\WalletService;
use App\Services\ReferralService;
class WithdrawController extends Controller
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

    $requests = WithdrawalRequest::where('user_id',$user->id)
    ->latest()
    ->get();

    return view('user.withdraw.index',compact('wallet','requests'));

}


public function requestWithdraw(Request $request)
{

$request->validate([
'amount'=>'required|numeric|min:100'
]);

$user = auth()->user();

if(!$user->bankAccount){

return back()->with('error','Please add bank account first');

}

if($request->amount > $user->wallet->balance){

return back()->with('error','Insufficient wallet balance');

}

WithdrawalRequest::create([
'user_id'=>$user->id,
'amount'=>$request->amount
]);
 if($request->amount > 0){

            WalletService::debit(
                $user->id,
                $request->amount,
                
                'User Withdrawal Request',
                $user->id,
            );

          
        }
return back()->with('success','Withdrawal request submitted');

}

}