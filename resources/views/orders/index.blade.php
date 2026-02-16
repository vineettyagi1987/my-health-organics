@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Your Orders</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Order No</th>
                <th>Total</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>₹{{ $order->total }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>
                    <a href="/orders/{{ $order->id }}" class="btn btn-sm btn-primary">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection