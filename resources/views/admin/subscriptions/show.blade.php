@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">Subscription Details</h2>

    {{-- Subscription Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>User:</strong> {{ $subscription->user->name ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($subscription->status) }}</p>
            <p><strong>Start Date:</strong> {{ $subscription->start_date ?? '-' }}</p>
            <p><strong>End Date:</strong> {{ $subscription->end_date ?? '-' }}</p>
            <p><strong>Razorpay Subscription ID:</strong> {{ $subscription->razorpay_subscription_id }}</p>
            <p><strong>Created At:</strong> {{ $subscription->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    {{-- Cancel Button (only if active) --}}
    @if($subscription->status === 'active')
        <form method="POST" action="{{ route('admin.subscriptions.cancel', $subscription->id) }}"
              onsubmit="return confirm('Are you sure you want to cancel this subscription?')">
            @csrf
            <button class="btn btn-danger mb-3">
                Cancel Subscription
            </button>
        </form>
    @endif

    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
        ← Back to Subscriptions
    </a>

</div>
@endsection
