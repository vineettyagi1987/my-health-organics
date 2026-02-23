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
<th>User Email</th>
<th>Amount</th>
<th>Status</th>
<th>Action</th>
</tr>

@foreach($withdrawals as $w)

<tr>

<td>{{ $w->user->name }}</td>
<td>{{ $w->user->email }}</td>
<td>{{ $w->amount }}</td>
<td>{{ $w->status }}</td>

<td>

@if($w->status=='pending')

<form method="POST" action="/admin/withdrawals/{{$w->id}}/approve">
@csrf

<button class="btn btn-success">Approve</button>

</form>

@endif

</td>

</tr>

@endforeach

</table>
</div>

@endsection