<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankAccount;

class BankAccountController extends Controller
{

public function index()
{

    $user = auth()->user();

    $bank = $user->bankAccount;

    return view('user.bank.index',compact('bank'));

}

public function store(Request $request)
{

$request->validate([
'account_holder'=>'required',
'account_number'=>'required',
'ifsc'=>'required'
]);

BankAccount::updateOrCreate(
['user_id'=>auth()->id()],
[
'account_holder'=>$request->account_holder,
'account_number'=>$request->account_number,
'ifsc'=>$request->ifsc,
'bank_name'=>$request->bank_name
]
);

return back()->with('success','Bank details saved');

}

}