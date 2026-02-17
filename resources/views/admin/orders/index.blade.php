@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>All Orders</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
               <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Order No</th>
                <th>Total</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
           <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $order->user->name ?? '-' }}</td>
    <td>{{ $order->user->email ?? '-' }}</td>
    <td>{{ $order->order_number }}</td>
    <td>₹{{ $order->total }}</td>
    <td>{{ ucfirst($order->status) }}</td>
    <td>
        <a href="{{ route('admin.orders.show', $order->id) }}"
           class="btn btn-sm btn-primary">View</a>
    </td>
</tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No orders found</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
