@extends('layouts.app')
@section('content')
<div class="container">

<h3>Network Growth</h3>
<form method="GET">

    <select name="user_id" class="form-control" onchange="this.form.submit()">

    <option value="">Select User</option>

    @foreach($users as $user)

    <option value="{{$user->id}}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
    {{$user->name.'('.$user->email.') ('.$user->my_referral_code.')'}}
    </option>

    @endforeach

    </select>

</form>

<br>
@if(!empty($commissionSummary))

<h3>Total Commission: ₹ {{ $commissionSummary['total'] }}</h3>

<table class="table table-bordered">
<tr>
<th>Level</th>
<th>Total Users</th>
<th>Eligible Users</th>
<th>Commission</th>
<th>Bonus</th>
</tr>

@foreach($commissionSummary['levels'] as $level => $data)

<tr>
<td>{{ $level }}</td>
<td>{{ $data['users'] }}</td>
<td>{{ $data['eligible'] }}</td>
<td>₹ {{ $data['commission'] }}</td>
<td>₹ {{ $data['bonus'] ?? 0 }}</td>
</tr>

@endforeach

</table>

@endif


@if(!empty($levels))

@foreach($levels as $level=>$levelUsers)

<h4>Level {{$level}} ({{ $levelUsers->count() }} Users)</h4>

<table class="table table-bordered">

<tr>
<th>User</th>
<th>Email</th>
<th>Referral Code</th>
<th>Membership</th>
</tr>

@foreach($levelUsers as $u)

<tr>

<td>{{$u->name}}</td>

<td>{{$u->email}}</td>

<td>{{$u->my_referral_code}}</td>

<td>

@if($u->activeSubscription)
Active
@else
Inactive
@endif

</td>

</tr>

@endforeach

</table>

@endforeach

@endif

</div>

@endsection