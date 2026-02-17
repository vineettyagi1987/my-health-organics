<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Razorpay\Api\Api;
use Exception;

class SubscriptionController extends Controller
{
    /** Show user subscriptions */
    public function index()
    {
        $subscriptions = Subscription::where('user_id', auth()->id())
            ->latest()
            ->get();
       
        return view('subscriptions.index', compact('subscriptions'));
    }

   

    /** Show ₹500 membership page */
    public function offer()
    {
        return view('subscriptions.offer');
    }

    /** Create Razorpay subscription */
    public function subscribe()
    {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $rzpSub = $api->subscription->create([
            'plan_id' => config('razorpay.membership_plan'),
            'customer_notify' => 1,
            'total_count' => 1,
            'notes' => [
                'user_id' => auth()->id(),
            ],
        ]);

        // store locally
        Subscription::create([
            'user_id' => auth()->id(),
            'razorpay_subscription_id' => $rzpSub['id'],
            'status' => 'created',
        ]);

        return view('subscriptions.pay', [
            'subscription_id' => $rzpSub['id']
        ]);
    }

    /** Skip membership */
    public function skip()
    {
        return redirect('/')->with('success', 'Registration completed successfully.');
    }

     /** Show subscription in user profile */
    public function profile()
    {
        $subscription = Subscription::where('user_id', auth()->id())
            ->latest()
            ->first();
        
        return view('subscriptions.profile', compact('subscription'));
    }

    /** Create new subscription from profile */
    public function create()
    {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $rzpSub = $api->subscription->create([
            'plan_id' => config('razorpay.membership_plan'),
            'customer_notify' => 1,
            'total_count' => 1,
            'notes' => [
                'user_id' => auth()->id(),
            ],
        ]);

        $subscription = Subscription::create([
            'user_id' => auth()->id(),
            'razorpay_subscription_id' => $rzpSub['id'],
            'status' => 'created',
        ]);

        return view('subscriptions.pay', [
            'subscription_id' => $subscription->razorpay_subscription_id
        ]);
    }

    /** Cancel active subscription */
    public function cancel($id)
{
    $subscription = Subscription::where('user_id', auth()->id())
        ->findOrFail($id);

    /**
     * If already completed → just mark locally
     * (No Razorpay cancel possible)
     */
    if ($subscription->status === 'completed') {

        $subscription->update([
            'status'   => 'cancelled',
            'end_date' => now(),
        ]);

        return back()->with('info', 'Subscription already completed.');
    }

    /**
     * If active → cancel on Razorpay
     */
 if ($subscription->status === 'active') {

    try {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $api->subscription
            ->fetch($subscription->razorpay_subscription_id)
            ->cancel();

        $subscription->update([
            'status'   => 'cancelled',
            'end_date' => now(),
        ]);

        return back()->with('success', 'Subscription cancelled successfully.');

    } catch (Exception $e) {
       
        /** Optional: log real error for debugging */
      //  \Log::error('Razorpay Cancel Error: ' . $e->getMessage());

       return back()->with('warning', 'Subscription cannot be cancelled in current state.');
    }

    /**
     * Any other state
     */
    return back()->with('warning', 'Subscription cannot be cancelled in current state.');
}

}
}
