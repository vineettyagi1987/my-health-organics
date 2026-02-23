<?php
namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
class WalletService
{

public static function credit($userId,$amount,$source,$referenceId=null)
{

    $exists = WalletTransaction::where('user_id',$userId)
        ->where('source',$source)
        ->where('reference_id',$referenceId)
        ->exists();

    if($exists){
        return;
    }

    $wallet = Wallet::firstOrCreate(['user_id'=>$userId]);

    $wallet->increment('balance',$amount);

    WalletTransaction::create([
        'user_id'=>$userId,
        'wallet_id'=>$wallet->id,
        'amount'=>$amount,
        'type'=>'credit',
        'source'=>$source,
        'reference_id'=>$referenceId
    ]);

}
public static function debit($userId,$amount,$source)
{

    Wallet::where('user_id',$userId)->decrement('balance',$amount);

    WalletTransaction::create([
    'user_id'=>$userId,
    'amount'=>$amount,
    'type'=>'debit',
    'source'=>$source
    ]);

}

}