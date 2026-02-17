@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Your Orders</h2>

    @if($orders->count())
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order No</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th width="100"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>₹{{ $order->total }}</td>
                    <td>
                        <span class="badge 
                            @if($order->status == 'paid') bg-success
                            @elseif($order->status == 'pending') bg-warning text-dark
                            @elseif($order->status == 'cancelled') bg-danger
                            @elseif($order->status == 'refunded') bg-secondary
                            @else bg-info
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        {{-- No Orders Found UI --}}
        <div class="text-center py-5">
            <h4 class="mb-3">No orders found</h4>
          
        </div>
    @endif
</div>
@endsection
