@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show m-3">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show m-3">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

    <h2 class="mb-4">My Membership</h2>

    @if(!$subscription)
        {{-- No subscription --}}
        <div class="card p-4 text-center">
            <h4>No active membership</h4>
            <p class="text-muted">Get 1-year premium membership for ₹500.</p>

            <form method="POST" action="{{ route('subscription.create') }}">
                @csrf
                <button class="btn btn-success">Buy Membership ₹500</button>
            </form>
        </div>

    @elseif($subscription->status === 'active')
        {{-- Active --}}
        <div class="card p-4">
            <h4 class="text-success">Active Membership</h4>

            <p><strong>Start:</strong> {{ $subscription->start_date }}</p>
            <p><strong>Expiry:</strong> {{ $subscription->end_date }}</p>

            <form method="POST" action="{{ route('subscription.cancel', $subscription->id) }}">
                @csrf
                <button class="btn btn-danger"
                    onclick="return confirm('Cancel your membership?')">
                    Cancel Membership
                </button>
            </form>
        </div>

    @else
        {{-- Cancelled / expired --}}
        <div class="card p-4 text-center">
            <h4 class="text-danger">Membership {{ ucfirst($subscription->status) }}</h4>

            <form method="POST" action="{{ route('subscription.create') }}">
                @csrf
                <button class="btn btn-success">Renew Membership ₹500</button>
            </form>
        </div>
    @endif

</div>
@endsection
