@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Order Details</h2>

    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ $item->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-end">Grand Total: ₹{{ $order->total }}</h4>

    @if($order->status === 'pending')
        <form method="POST" action="/orders/{{ $order->id }}/cancel">
            @csrf
            <button class="btn btn-danger">Cancel Order</button>
        </form>
    @endif
</div>
@endsection