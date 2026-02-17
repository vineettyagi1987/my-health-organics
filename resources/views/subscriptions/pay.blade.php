<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
var options = {
    key: "{{ config('razorpay.key') }}",
    subscription_id: "{{ $subscription_id }}",
    name: "1 Year Membership",
    description: "₹500 Premium Plan",

    handler: function () {
        window.location.href = "{{ route('subscription.profile') }}";
    },

    modal: {
        ondismiss: function () {
            window.location.href = "/";
        }
    }
};

new Razorpay(options).open();
</script>
