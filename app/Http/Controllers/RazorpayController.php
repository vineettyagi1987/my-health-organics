<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

use Razorpay\Api\Api;

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
}
