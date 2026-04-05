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
            'status' =>  $rzpSub['status'],
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

// public function cancel($id)
// {
//     $subscription = Subscription::where('user_id', auth()->id())
//         ->findOrFail($id);

//     $api = new Api(config('razorpay.key'), config('razorpay.secret'));

//     try {

//         $rzpSub = $api->subscription->fetch($subscription->razorpay_subscription_id);

//         if ($rzpSub['status'] !== 'active') {
//             return back()->with('warning', 'Subscription can not cancel currently. Please check later.');
//         }

//         $api->subscription->cancel($subscription->razorpay_subscription_id);

//         // DO NOT update DB manually
//         // Webhook will update status automatically

//         return back()->with('success', 'Subscription cancellation requested.');

//     } catch (\Exception $e) {
//         return back()->with('error', $e->getMessage());
//     }
// }

public function cancel($id)
{
    $subscription = Subscription::where('user_id', auth()->id())
        ->findOrFail($id);

    // ✅ Prevent repeat cancel
    if ($subscription->status === 'cancelled') {
        return back()->with('info', 'Subscription already cancelled.');
    }

    $api = new Api(config('razorpay.key'), config('razorpay.secret'));

    try {

        $rzpSub = $api->subscription->fetch($subscription->razorpay_subscription_id);

        // ✅ Allow valid statuses
        if (!in_array($rzpSub['status'], ['active', 'authenticated', 'created'])) {

            // sync DB just in case
            $subscription->update(['status' => 'cancelled']);

            return back()->with('warning', 'Subscription already inactive.');
        }

        // ✅ Cancel immediately
        $api->subscription->cancel($subscription->razorpay_subscription_id, [
            'cancel_at_cycle_end' => 0
        ]);

        // ✅ Update DB
        $subscription->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Auto-debit cancelled. No future charges will be made.');

    } catch (\Exception $e) {

        \Log::error('Cancel Subscription Error: '.$e->getMessage());

        // ✅ Handle already cancelled case
        if (str_contains($e->getMessage(), 'already cancelled')) {
            $subscription->update(['status' => 'cancelled']);
            return back()->with('info', 'Subscription already cancelled.');
        }

        return back()->with('error', $e->getMessage());
    }
}


}
