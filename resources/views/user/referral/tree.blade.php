@extends('layouts.app')

@section('content')

<div class="container">

<h3>My Network Growth</h3>

@if(!empty($commissionSummary))

<h4>Total Earnings ₹ {{ $commissionSummary['total'] }}</h4>

<table class="table table-bordered">

<tr>
<th>Level</th>
<th>Total Users</th>
<th>Eligible Users</th>
<th>Commission</th>
</tr>

@foreach($commissionSummary['levels'] as $level=>$data)

<tr>

<td>{{ $level }}</td>
<td>{{ $data['users'] }}</td>
<td>{{ $data['eligible'] }}</td>
<td>{{ $data['commission'] }}</td>

</tr>

@endforeach

</table>

@endif



@foreach($levels as $level=>$levelUsers)

<h4>Level {{$level}} ({{$levelUsers->count()}} Users)</h4>

<table class="table table-bordered">

<tr>
<th>Name</th>
<th>Email</th>
<th>Referral Code</th>
</tr>

@foreach($levelUsers as $u)

<tr>

<td>{{$u->name}}</td>
<td>{{$u->email}}</td>
<td>{{$u->my_referral_code}}</td>

</tr>

@endforeach

</table>

@endforeach

</div>

@endsection