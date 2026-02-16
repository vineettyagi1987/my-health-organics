<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
public function store(Request $request)
{
$order = Order::create([
'user_id' => auth()->id(),
'total_amount' => $request->total,
'payment_status' => 'pending',
'status' => 'new'
]);


foreach ($request->products as $p) {
OrderItem::create([
'order_id' => $order->id,
'product_id' => $p['id'],
'qty' => $p['qty'],
'price' => $p['price'],
]);
}


return redirect('/dashboard')->with('success','Order placed');
}
}
