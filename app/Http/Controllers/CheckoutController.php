<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = getCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect('/')->with('error','Cart empty');
        }

        return view('checkout.index', compact('cart'));
    }

    public function placeOrder()
    {
        $cart = getCart()->load('items');

        return DB::transaction(function () use ($cart) {

            $subtotal = $cart->total();

            $order = Order::create([
                'user_id'=>auth()->id(),
                'order_number'=>'ORD'.time(),
                'subtotal'=>$subtotal,
                'total'=>$subtotal,
                'status'=>'pending',
                'payment_status'=>'unpaid'
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id'=>$item->product_id,
                    'quantity'=>$item->quantity,
                    'price'=>$item->price,
                    'total'=>$item->price * $item->quantity
                ]);
            }

            /** Razorpay order **/
            $api = new Api(config('razorpay.key'), config('razorpay.secret'));

            $rzpOrder = $api->order->create([
                'receipt'=>$order->order_number,
                'amount'=>$order->total * 100,
                'currency'=>'INR'
            ]);

            $order->update(['razorpay_order_id'=>$rzpOrder['id']]);

            return view('checkout.payment', compact('order','rzpOrder'));
        });
    }
}

