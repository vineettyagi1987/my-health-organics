<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

use Razorpay\Api\Api;
class RefundController extends Controller
{
    public function refund($id)
    {
        $order = Order::findOrFail($id);

        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $refund = $api->payment
            ->fetch($order->razorpay_payment_id)
            ->refund(['amount'=>$order->total * 100]);

        Refund::create([
            'order_id'=>$order->id,
            'amount'=>$order->total,
            'status'=>'processed',
            'razorpay_refund_id'=>$refund['id']
        ]);

        $order->update([
            'status'=>'refunded',
            'payment_status'=>'refunded'
        ]);

        return back()->with('success','Refund processed');
    }
}
