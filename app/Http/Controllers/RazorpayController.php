<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use App\Models\Refund;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;

class RazorpayController extends Controller
{
    public function payment(Request $request)
    {
       
        $order = Order::where('razorpay_order_id',$request->razorpay_order_id)->firstOrFail();

        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $api->utility->verifyPaymentSignature([
            'razorpay_order_id'=>$request->razorpay_order_id,
            'razorpay_payment_id'=>$request->razorpay_payment_id,
            'razorpay_signature'=>$request->razorpay_signature,
        ]);

        DB::transaction(function () use ($order,$request) {

            $order->update([
                'status'=>'paid',
                'payment_status'=>'paid',
                'razorpay_payment_id'=>$request->razorpay_payment_id
            ]);

            /** reduce stock **/
            foreach ($order->items as $item) {
                $item->product->decrement('stock', $item->quantity);
            }

            /** clear cart **/
            getCart()->items()->delete();
        });

        return redirect('/orders/'.$order->id)->with('success','Payment successful');
    }

  public function webhook(Request $request)
{
    $payload   = $request->getContent();
    $signature = $request->header('X-Razorpay-Signature');

    try {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $api->utility->verifyWebhookSignature(
            $payload,
            $signature,
            config('razorpay.webhook_secret')
        );
    } catch (SignatureVerificationError $e) {
        Log::error('Razorpay Webhook Signature Failed');
        return response()->json(['status' => 'invalid signature'], 400);
    }

    $data  = json_decode($payload, true);
    $event = $data['event'] ?? null;

    Log::info('Razorpay Webhook Event: ' . $event);

    switch ($event) {
        
        /** ================= PAYMENT CAPTURED ================= */
        case 'payment.captured':

            $payment = $data['payload']['payment']['entity'];

            DB::transaction(function () use ($payment) {

                $order = Order::where('razorpay_payment_id', $payment['id'])
                    ->orWhere('razorpay_order_id', $payment['order_id'])
                    ->first();

                if ($order && $order->payment_status !== 'paid') {

                    $order->update([
                        'status' => 'paid',
                        'payment_status' => 'paid',
                        'razorpay_payment_id' => $payment['id'],
                    ]);

                    foreach ($order->items as $item) {
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            });

            break;


        /** ================= PAYMENT FAILED ================= */
        case 'payment.failed':

            $payment = $data['payload']['payment']['entity'];

            Order::where('razorpay_order_id', $payment['order_id'])
                ->update([
                    'status' => 'failed',
                    'payment_status' => 'failed',
                ]);

            break;


        /** ================= REFUND PROCESSED ================= */
        case 'refund.processed':

            $refund = $data['payload']['refund']['entity'];

            $order = Order::where('razorpay_payment_id', $refund['payment_id'])->first();

            if ($order) {

                Refund::updateOrCreate(
                    ['razorpay_refund_id' => $refund['id']],
                    [
                        'order_id' => $order->id,
                        'amount'   => $refund['amount'] / 100,
                        'status'   => 'processed',
                    ]
                );

                $order->update([
                    'status' => 'refunded',
                    'payment_status' => 'refunded',
                ]);
            }

            break;


        /** ================= SUBSCRIPTION ACTIVATED ================= */
        case 'subscription.activated':

            $sub = $data['payload']['subscription']['entity'];

            Subscription::where('razorpay_subscription_id', $sub['id'])
                ->update([
                    'status'     => 'active',
                    'start_date' => now(),
                    'end_date'   => now()->addYear(),
                ]);

            break;


        /** ================= SUBSCRIPTION CHARGED (RENEWAL) ================= */
        case 'subscription.charged':

            $sub = $data['payload']['subscription']['entity'];

            $subscription = Subscription::where('razorpay_subscription_id', $sub['id'])->first();

            if ($subscription) {
                $subscription->update([
                    'status'   => 'active',
                    'end_date' => $subscription->end_date
                        ? \Carbon\Carbon::parse($subscription->end_date)->addYear()
                        : now()->addYear(),
                ]);
            }

            break;


        /** ================= SUBSCRIPTION COMPLETED ================= */
        case 'subscription.completed':

            $sub = $data['payload']['subscription']['entity'];

            Subscription::where('razorpay_subscription_id', $sub['id'])
                ->update([
                    'status'   => 'completed',
                    'end_date' => now(),
                ]);

            break;


        /** ================= SUBSCRIPTION CANCELLED ================= */
        case 'subscription.cancelled':

            $sub = $data['payload']['subscription']['entity'];

            Subscription::where('razorpay_subscription_id', $sub['id'])
                ->update([
                    'status'   => 'cancelled',
                    'end_date' => now(),
                ]);

            break;
    }

    return response()->json(['status' => 'success']);
}

}
