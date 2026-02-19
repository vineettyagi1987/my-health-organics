@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Checkout</h2>
    @php
    use App\Models\Subscription;

    $subtotal = $cart->total();

    $isSubscribed = Subscription::where('user_id', auth()->id())
        ->where('status', 'active')
        ->where(function ($q) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', now());
        })
        ->exists();

    $discount = $isSubscribed ? $subtotal * 0.05 : 0;
    $finalTotal = $subtotal - $discount;
@endphp


{{-- Subscription Message --}}
@if($isSubscribed)
    <div class="alert alert-success d-flex justify-content-between align-items-center">
        <div>
            🎉 <strong>Subscription Active!</strong><br>
            You received an <strong>instant 5% discount</strong> on this order.
        </div>
        <div class="fw-bold text-success">
            Saved ₹{{ number_format($discount, 2) }}
        </div>
    </div>
@else
    <div class="alert alert-info d-flex justify-content-between align-items-center">
        <div>
            💡 <strong>Want 5% OFF on every order?</strong><br>
            Activate Razorpay subscription and enjoy automatic discounts.
        </div>
        <a href="{{ route('membership.offer') }}" class="btn btn-primary btn-sm">
            View Plans
        </a>
    </div>
@endif

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
   <div class="text-end mb-4">
    <p><strong>Subtotal:</strong> ₹{{ number_format($subtotal, 2) }}</p>

    @if($isSubscribed)
        <p class="text-success">
            <strong>Subscription Discount (5%):</strong>
            -₹{{ number_format($discount, 2) }}
        </p>
    @endif

    <h4>Grand Total: ₹{{ number_format($finalTotal, 2) }}</h4>
</div>


    <!-- Checkout Form -->
    <form method="POST" action="/checkout/place-order">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>Pincode</label>
                <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" required>
                @error('pincode') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                @error('city') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>State</label>
                <input type="text" name="state" class="form-control" value="{{ old('state') }}" required>
                @error('state') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label>Full Address</label>
                <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-success btn-lg">Pay with Razorpay</button>
        </div>
    </form>
</div>
@endsection
