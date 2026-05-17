@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card p-4 text-center">

        <h2>Membership Offer</h2>

        <h3 class="mt-3">Pay ₹500 for 2-years membership benefits.</h3>

        <p>
            Become a member volunteer and get your ID Card.
        </p>

        <form action="{{ route('membership.subscribe') }}" method="POST">

            @csrf

            <button type="submit" class="btn btn-success">
                Continue Payment
            </button>

        </form>

    </div>

</div>

@endsection