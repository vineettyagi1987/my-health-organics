@extends('layouts.app')
@section('title','Withdrawal Requests')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">
<h3>Withdrawal Requests</h3>
</div>

<table class="table table-bordered">

<tr>
<th>User</th>
<th>Email</th>
<th>Amount</th>
<th>Bank Details</th>
<th>Status</th>
<th>Action</th>
</tr>

@foreach($withdrawals as $w)

<tr>

<td>{{ $w->user->name }}</td>

<td>{{ $w->user->email }}</td>

<td>₹ {{ $w->amount }}</td>


<td>

@if($w->user->bankAccount)

<strong>Bank :</strong> {{ $w->user->bankAccount->bank_name }} <br>

<strong>Account :</strong> {{ $w->user->bankAccount->account_number }} <br>

<strong>IFSC :</strong> {{ $w->user->bankAccount->ifsc }} <br>

<strong>Name :</strong> {{ $w->user->bankAccount->account_holder }}

@else

<span class="text-danger">
No Bank Details
</span>

@endif

</td>


<td>{{ ucfirst($w->status) }}</td>


<td>

@if($w->status=='pending')

<form method="POST" action="/admin/withdrawals/{{$w->id}}/approve">
@csrf

<button class="btn btn-success btn-sm">
Approve
</button>

</form>

@endif

</td>

</tr>

@endforeach

</table>

{{ $withdrawals->links() }}

</div>

@endsection