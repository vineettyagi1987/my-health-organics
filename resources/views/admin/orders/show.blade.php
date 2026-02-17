@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">Order Details</h2>

    {{-- Order Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Order No:</strong> {{ $order->order_number }}</p>
            <p><strong>User:</strong> {{ $order->user->name ?? '-' }}</p>
            <p><strong>Total:</strong> ₹{{ $order->total }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
            <p><strong>Razorpay Payment ID:</strong> {{ $order->razorpay_order_id ?? '-' }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Order Items</div>
        <div class="card-body p-0">
            <table class="table mb-0 table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($order->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td>₹{{ $item->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ $item->price * $item->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No items found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Refunds --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Refunds</div>
        <div class="card-body p-0">
            <table class="table mb-0 table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($order->refunds as $refund)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>₹{{ $refund->amount }}</td>
                        <td>{{ ucfirst($refund->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No refunds</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        ← Back to Orders
    </a>

</div>
@endsection
