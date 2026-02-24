@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-4">My Profile</h3>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">

        {{-- Profile Update --}}
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <h5 class="mb-3">Update Details</h5>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control"
                                   value="{{ $user->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}" required>
                        </div>

                        <button class="btn btn-success">Update Profile</button>
                    </form>

                </div>
            </div>
        </div>

        {{-- Referral Section --}}
    @if(!in_array($user->role, ['employee','distributor']))
<div class="col-md-6">
    <div class="card shadow-sm mb-4 text-center">
        <div class="card-body">

            <h5 class="fw-bold text-success mb-3">My Referral Code</h5>

            <div class="fs-4 fw-bold text-primary mb-2">
                {{ $user->my_referral_code }}
            </div>

            <button class="btn btn-outline-success btn-sm mb-3"
                    onclick="copyReferralCode()">
                Copy Code
            </button>

            <p class="small text-muted">
                Share this link:<br>
                <strong>{{ url('/register?ref=' . $user->my_referral_code) }}</strong>
            </p>

        </div>
    </div>
</div>
@endif

    </div>
</div>

<script>
function copyReferralCode() {
    const code = "{{ $user->my_referral_code }}";
    navigator.clipboard.writeText(code);
    alert("Referral code copied: " + code);
}
</script>
@endsection
