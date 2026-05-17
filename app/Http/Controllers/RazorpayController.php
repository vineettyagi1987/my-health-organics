<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Subscription;
use DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RazorpayController extends Controller
{
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

            /** ================= REFUND ================= */
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

                // ✅ Start Date from Razorpay
                $startAt = isset($sub['start_at'])
                    ? Carbon::createFromTimestamp($sub['start_at'])
                    : now();

                // ✅ ALWAYS calculate end date yourself (2 YEARS)
                $endAt = $startAt->copy()->addYears(2);

                Subscription::where('razorpay_subscription_id', $sub['id'])
                    ->update([
                        'status'     => 'active',
                        'start_date' => $startAt,
                        'end_date'   => $endAt,
                    ]);

                break;

            /** ================= SUBSCRIPTION RENEWAL ================= */
            case 'subscription.charged':

                $sub = $data['payload']['subscription']['entity'];

                $subscription = Subscription::where('razorpay_subscription_id', $sub['id'])->first();

                if ($subscription) {

                    // ✅ Extend from existing expiry if active
                    if ($subscription->end_date && $subscription->end_date > now()) {
                        $newEndDate = $subscription->end_date->copy()->addYears(2);
                    } else {
                        $newEndDate = now()->addYears(2);
                    }

                    $subscription->update([
                        'status'   => 'active',
                        'end_date' => $newEndDate,
                    ]);
                }

                break;

            /** ================= SUBSCRIPTION COMPLETED ================= */
            case 'subscription.completed':

                $sub = $data['payload']['subscription']['entity'];

                // ✅ Start Date from Razorpay
                $startAt = isset($sub['start_at'])
                    ? Carbon::createFromTimestamp($sub['start_at'])
                    : now();

                // ✅ ALWAYS calculate end date yourself (2 YEARS)
                $endAt = $startAt->copy()->addYears(2);

                Subscription::where('razorpay_subscription_id', $sub['id'])
                    ->update([
                        'status'   => 'completed',
                         'start_date' => $startAt,
                        'end_date'   => $endAt,
                    ]);

                break;

            /** ================= SUBSCRIPTION CANCELLED ================= */
            case 'subscription.cancelled':

                $sub = $data['payload']['subscription']['entity'];

                $endAt = isset($sub['ended_at'])
                    ? Carbon::createFromTimestamp($sub['ended_at'])
                    : now();

                Subscription::where('razorpay_subscription_id', $sub['id'])
                    ->update([
                        'status'   => 'cancelled',
                        'end_date' => $endAt,
                    ]);

                break;
        }

        return response()->json(['status' => 'success']);
    }
}