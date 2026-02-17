@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">

    <h2 class="mb-3">Become a Premium Member</h2>
    <p class="text-muted">Pay ₹500 for 1-year membership benefits.</p>

    <form method="POST" action="{{ route('membership.subscribe') }}">
        @csrf
        <button class="btn btn-success btn-lg">
            Pay ₹500 & Activate Membership
        </button>
    </form>

    <form method="POST" action="{{ route('membership.skip') }}" class="mt-3">
        @csrf
        <button class="btn btn-outline-secondary">
            Skip for now
        </button>
    </form>

</div>
@endsection
