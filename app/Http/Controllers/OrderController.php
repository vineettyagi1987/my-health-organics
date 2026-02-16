<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

use Razorpay\Api\Api;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id',auth()->id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error','Cannot cancel');
        }

        $order->update(['status'=>'cancelled']);
        return back()->with('success','Order cancelled');
    }
}
