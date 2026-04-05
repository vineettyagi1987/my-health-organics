<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Razorpay\Api\Api;

class SubscriptionController extends Controller
{
    /** List all subscriptions */
 public function index(Request $request)
{
    $query = Subscription::with('user')->latest();

    // Status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Search filter (user name, email, status)
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('status', 'like', "%$search%")
              ->orWhereHas('user', function ($u) use ($search) {
                  $u->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
              });
        });
    }

    $subscriptions = $query->paginate(20)->withQueryString();

    return view('admin.subscriptions.index', compact('subscriptions'));
}


    /** Show single subscription */
    public function show($id)
    {
        $subscription = Subscription::with('user')->findOrFail($id);

        return view('admin.subscriptions.show', compact('subscription'));
    }

    /** Admin cancel subscription */
    // public function cancel($id)
    // {
    //     $subscription = Subscription::findOrFail($id);

    //     try {
    //         $api = new Api(config('razorpay.key'), config('razorpay.secret'));

    //         $rzpSub = $api->subscription->fetch($subscription->razorpay_subscription_id);
           
    //         if ($rzpSub['status'] === 'active') {
              
    //             $rzpSub->cancel();
    //         }

    //         $subscription->update([
    //             'status' => 'cancelled',
    //             'end_date' => now(),
    //         ]);

    //         return back()->with('success', 'Subscription cancelled successfully.');

    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Unable to cancel subscription.');
    //     }
    // }

public function cancel($id)
{
    $subscription = Subscription::findOrFail($id);

    try {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $rzpSub = $api->subscription->fetch($subscription->razorpay_subscription_id);

        // ✅ Allow all valid statuses (important for eMandate)
        if (in_array($rzpSub['status'], ['active', 'authenticated', 'created'])) {

            // ✅ Proper cancel API call
            $api->subscription->cancel($subscription->razorpay_subscription_id, [
                'cancel_at_cycle_end' => 0 // immediate cancel
            ]);
        }

        // ✅ DO NOT cut user access immediately
        // Only stop future billing
        $subscription->update([
            'status' => 'cancelled',
            // keep existing end_date (important)
        ]);

        return back()->with('success', 'Subscription cancelled (auto-debit stopped).');

    } catch (\Exception $e) {

        \Log::error('Admin Cancel Error: '.$e->getMessage());

        return back()->with('error', $e->getMessage());
    }
}
}

