@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Your Cart</h2>

    @if($cart->items->count())
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="120">Price</th>
                    <th width="140">Qty</th>
                    <th width="120">Total</th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>₹{{ $item->price }}</td>
                    <td>
                        <form method="POST" action="/cart/update" class="d-flex gap-2">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control">
                            <button class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </td>
                    <td>₹{{ $item->price * $item->quantity }}</td>
                    <td>
                        <form method="POST" action="/cart/remove">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <button class="btn btn-danger btn-sm">X</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <h4>Total: ₹{{ $cart->total() }}</h4>
            <a href="/checkout" class="btn btn-success">Proceed to Checkout</a>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection