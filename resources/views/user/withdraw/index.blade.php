@extends('layouts.app')

@section('content')

<div class="container">

<h3>Wallet Balance ₹ {{ auth()->user()->wallet->balance ?? 0 }}</h3>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(!auth()->user()->bankAccount)

<div class="alert alert-warning">
Please add bank account first.
</div>

<a href="{{ route('user.bank') }}" class="btn btn-primary">
Add Bank Account
</a>

@else

<form method="POST" action="{{ route('user.withdraw.request') }}">
@csrf

<label>Withdraw Amount</label>
<input type="number" name="amount" class="form-control" required>

<br>

<button class="btn btn-primary">Request Withdrawal</button>

</form>

@endif

<hr>

<h4>Withdrawal History</h4>

<table class="table table-bordered">

<tr>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
</tr>

@forelse($requests as $r)

<tr>
    <td>₹ {{ $r->amount }}</td>
    <td>{{ $r->status }}</td>
    <td>{{ $r->created_at->format('d M Y') }}</td>
</tr>

@empty

<tr>
    <td colspan="3" class="text-center text-muted">
        No withdrawal records found.
    </td>
</tr>

@endforelse

</table>
</div>

@endsection