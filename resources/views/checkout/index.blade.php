@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Checkout</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ $item->price * $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-end">
        <h4>Grand Total: ₹{{ $cart->total() }}</h4>

        <form method="POST" action="/checkout/place-order">
            @csrf
            <button class="btn btn-success">Pay with Razorpay</button>
        </form>
    </div>
</div>
@endsection