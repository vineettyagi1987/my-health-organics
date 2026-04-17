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
    $commissionSummary = $referralService->calculateLevelCommission($levels, $user);
    }
    //print_r($commissionSummary);die;
    $tree = $referralService->buildTree($user->my_referral_code);
     $chartData = $this->formatTreeForChart($tree, $user);
    return view('user.referral.tree',compact('levels','commissionSummary','tree', 'chartData'));

}

/**
 * Convert tree to OrgChart format
 */
private function formatTreeForChart($tree, $rootUser)
{
    $nodes = [];

    $nodes[] = [
        'id' => $rootUser->id,
        'name' => $rootUser->name,
        'img' => $rootUser->profile_photo ?? asset('default-user.png'),
       
        'tags' => ['level0']
    ];

    $this->buildChartNodes($tree, $rootUser->id, $nodes, 1);

    return $nodes;
}

private function buildChartNodes($tree, $parentId, &$nodes, $level)
{
    foreach ($tree as $node) {

        $user = $node['user'];

        $nodes[] = [
            'id' => $user->id,
            'pid' => $parentId,
            'name' => $user->name,
            'phone' => $user->phone,
            'my_referral_code' => $user->my_referral_code,
             'img' => $user->profile_photo ?? asset('default-user.png'),
    
            'tags' => ['level'.$level]
        ];

        if (!empty($node['children'])) {
            $this->buildChartNodes(
                $node['children'],
                $user->id,
                $nodes,
                $level + 1
            );
        }
    }
}

}