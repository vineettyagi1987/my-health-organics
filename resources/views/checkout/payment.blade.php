@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h3>Redirecting to Razorpay...</h3>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        key: "{{ config('razorpay.key') }}",
        amount: "{{ $order->total * 100 }}",
        currency: "INR",
        name: "My Store",
        description: "Order Payment",
        order_id: "{{ $order->razorpay_order_id }}",

        /** ✅ SUCCESS */
        handler: function (response) {
            fetch("/razorpay/payment", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(response)
            })
            .then(() => {
                window.location.href = "/orders/{{ $order->id }}";
            });
        },

        /** ❌ PAYMENT FAILED */
        modal: {
            ondismiss: function () {
                window.location.href = "/orders/{{ $order->id }}?status=cancelled";
            }
        }
    };

    var rzp = new Razorpay(options);

    /** ❌ Razorpay failure event */
    rzp.on('payment.failed', function () {
       // window.location.href = "/orders/{{ $order->id }}?status=failed";
    });

    rzp.open();
</script>

@endsection