<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use App\Models\Subscription;
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

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|digits:6',
        ]);

        $cart = getCart()->load('items');

        return DB::transaction(function () use ($cart,$request) {

            $subtotal = $cart->total();
              /** -------------------------------
         * 2️⃣ Check ACTIVE subscription
         * --------------------------------*/
        $isSubscribed = Subscription::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->exists();

        /** -------------------------------
         * 3️⃣ Apply 5% discount
         * --------------------------------*/
        $discount = $isSubscribed ? round($subtotal * 0.05, 2) : 0;
        $finalTotal = $subtotal - $discount;
            $order = Order::create([
                'user_id'=>auth()->id(),
                'order_number'=>'ORD'.time(),
                'subtotal'=>$subtotal,
                 'discount' => $discount,
                'total'=>$finalTotal,
                'status'=>'pending',
                'payment_status'=>'unpaid',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode
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
                'amount'=> (int) round($finalTotal * 100),
                'currency'=>'INR'
            ]);

            $order->update(['razorpay_order_id'=>$rzpOrder['id']]);

            return view('checkout.payment', compact('order','rzpOrder','discount','isSubscribed'));
        });
    }
}

