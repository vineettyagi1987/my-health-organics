<?php
namespace App\Services;

use App\Models\User;
use App\Models\WalletTransaction;

class ReferralService
{
    public function getLevels($code, $maxLevel = 10)
    {
        $levels = [];
        $currentCodes = [$code];

        for ($level = 1; $level <= $maxLevel; $level++) {

            $users = User::whereIn('referral_code', $currentCodes)
                ->whereHas('activeSubscription')
                ->get();

            if ($users->isEmpty()) break;

            $levels[$level] = $users;
            $currentCodes = $users->pluck('my_referral_code')->toArray();
        }

        return $levels;
    }

    public function calculateLevelCommission($levels, $user)
    {
        $membershipAmount = 500;

        $percentages = [
            1=>10,2=>5,3=>4,4=>3,5=>2,
            6=>2,7=>2,8=>1,9=>1,10=>1
        ];

        $totalCommission = 0;
        $commissionData = [];

        foreach ($levels as $level => $users) {

            $activeUsers = $users->count();
            $eligibleUsers = min($activeUsers, 999);

            $levelAmount = $eligibleUsers * $membershipAmount;
            $commission = ($levelAmount * $percentages[$level]) / 100;

            $commissionData[$level] = [
                'users'=>$activeUsers,
                'eligible'=>$eligibleUsers,
                'commission'=>$commission
            ];

            $totalCommission += $commission;

            // Wallet Logic
            $this->handleWallet($user, $commission, $level);
        }

        return [
            'levels'=>$commissionData,
            'total'=>$totalCommission
        ];
    }

    private function handleWallet($user, $commission, $level)
    {
        if ($commission <= 0) return;

        $source = 'level-' . $level . '-' . $user->my_referral_code;

        $transaction = WalletTransaction::where('user_id', $user->id)
            ->where('source', $source)
            ->where('reference_id', $user->id)
            ->sum('amount');

        if ($transaction) {

            if ($transaction == $commission) return;

            $difference = $commission - $transaction;

            if ($difference > 0) {
                WalletService::creditDifference(
                    $user->id,
                    $difference,
                    $source,
                    $user->id
                );
            }

        } else {
            WalletService::credit(
                $user->id,
                $commission,
                $source,
                $user->id
            );
        }
    }
}