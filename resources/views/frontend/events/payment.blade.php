@extends('layouts.app')

@section('title','Event Payment')

@section('content')

<div class="container text-center mt-5">

<h3>Processing Payment...</h3>

<p>Please wait while we redirect you to Razorpay.</p>

</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

var options = {

    "key": "{{ config('razorpay.key') }}",

    "amount": "{{ $event->price * 100 }}",

    "currency": "INR",

    "name": "Event Booking",

    "description": "{{ $event->title }}",

    "order_id": "{{ $order['id'] }}",

    "handler": function (response){

        window.location.href = "/payment-success?razorpay_payment_id="
        + response.razorpay_payment_id
        + "&razorpay_order_id="
        + response.razorpay_order_id;

    },

    "modal": {
        "ondismiss": function(){
            window.location.href = "{{ route('events.index') }}?error=payment_cancelled";
        }
    }

};

var rzp = new Razorpay(options);


rzp.on('payment.failed', function (response){

   // window.location.href = "{{ route('events.index') }}?error=payment_failed";

});


window.onload = function(){

    rzp.open();

}

</script>

@endsection