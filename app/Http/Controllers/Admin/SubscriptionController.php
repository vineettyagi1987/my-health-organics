<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Razorpay\Api\Api;

class SubscriptionController extends Controller
{
    /** List all subscriptions */
    public function index()
    {
        $subscriptions = Subscription::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    /** Show single subscription */
    public function show($id)
    {
        $subscription = Subscription::with('user')->findOrFail($id);

        return view('admin.subscriptions.show', compact('subscription'));
    }

    /** Admin cancel subscription */
    public function cancel($id)
    {
        $subscription = Subscription::findOrFail($id);

        try {
            $api = new Api(config('razorpay.key'), config('razorpay.secret'));

            $rzpSub = $api->subscription->fetch($subscription->razorpay_subscription_id);
           
            if ($rzpSub['status'] === 'active') {
              
                $rzpSub->cancel();
            }

            $subscription->update([
                'status' => 'cancelled',
                'end_date' => now(),
            ]);

            return back()->with('success', 'Subscription cancelled successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Unable to cancel subscription.');
        }
    }
}

