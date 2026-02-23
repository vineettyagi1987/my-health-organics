@extends('layouts.app')

@section('content')

<div class="container">

<h3>Bank Account Details</h3>
{{-- Flash Error Message --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<form method="POST" action="{{ route('user.bank.store') }}">
@csrf

<label>Account Holder</label>
<input type="text" name="account_holder" class="form-control"
value="{{ $bank->account_holder ?? '' }}" required>

<label>Account Number</label>
<input type="text" name="account_number" class="form-control"
value="{{ $bank->account_number ?? '' }}" required>

<label>IFSC</label>
<input type="text" name="ifsc" class="form-control"
value="{{ $bank->ifsc ?? '' }}" required>

<label>Bank Name</label>
<input type="text" name="bank_name" class="form-control"
value="{{ $bank->bank_name ?? '' }}">

<br>

<button class="btn btn-success">Save Bank Details</button>

</form>

</div>

@endsection