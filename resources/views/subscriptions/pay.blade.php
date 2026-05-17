@extends('layouts.app')

@section('content')

<div class="container mt-5 text-center">

    <h2>Complete Membership Payment</h2>

    <button id="rzp-button" class="btn btn-primary mt-4">
        Pay Now
    </button>

</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

var options = {

    "key": "{{ config('razorpay.key') }}",

    "subscription_id": "{{ $subscription_id }}",

    "name": "Save The Nature",

    "description": "Membership Payment",

    "handler": function (response){

        fetch("{{ route('payment.success') }}", {

            method: "POST",

            headers: {

                "Content-Type": "application/json",

                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },

            body: JSON.stringify(response)

        }).then(() => {

            window.location.href = "/";
        });
    },

    "modal": {

        "ondismiss": function(){

            window.location.href = "{{ route('payment.failed') }}";
        }
    }
};

var rzp = new Razorpay(options);

document.getElementById('rzp-button').onclick = function(e){

    rzp.open();

    e.preventDefault();
}

</script>

@endsection