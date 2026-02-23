<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserReferralController extends Controller
{

public function index()
{

$user = auth()->user();

$levels = $this->getLevels($user->my_referral_code);

$commissionSummary = [];

if(!empty($levels)){
$commissionSummary = $this->calculateLevelCommission($levels);
}

return view('user.referral.tree',compact('levels','commissionSummary'));

}



private function getLevels($code,$maxLevel=10)
{

$levels = [];
$currentCodes = [$code];

for($level=1;$level<=$maxLevel;$level++)
{

$users = User::whereIn('referral_code',$currentCodes)
            ->whereHas('activeSubscription')
            ->get();

if($users->isEmpty())
break;

$levels[$level] = $users;

$currentCodes = $users->pluck('my_referral_code')->toArray();

}

return $levels;

}



private function calculateLevelCommission($levels)
{

$membershipAmount = 500;

$percentages = [
1=>10,
2=>5,
3=>4,
4=>3,
5=>2,
6=>2,
7=>2,
8=>1,
9=>1,
10=>1
];

$totalCommission = 0;
$commissionData = [];

foreach($levels as $level=>$users){

$activeUsers = $users->count();

$eligibleUsers = min($activeUsers,999);

$levelAmount = $eligibleUsers * $membershipAmount;

$commission = ($levelAmount * $percentages[$level]) / 100;

$commissionData[$level] = [
'users'=>$activeUsers,
'eligible'=>$eligibleUsers,
'commission'=>$commission
];

$totalCommission += $commission;

}

if(isset($commissionData[1])){

$level1Users = $commissionData[1]['users'];

if($level1Users >= 5){

$bonusBase = 5 * 500;

$bonus = ($bonusBase * 2)/100;

$commissionData[1]['bonus'] = $bonus;

$totalCommission += $bonus;

}

}

return [
'levels'=>$commissionData,
'total'=>$totalCommission
];

}

}