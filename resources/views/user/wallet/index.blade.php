@extends('layouts.app')

@section('content')

<div class="container">

<h3>Wallet Balance ₹ {{ $wallet->balance ?? 0 }}</h3>

<table class="table table-bordered">

<tr>
<th>Amount</th>
<th>Type</th>
<th>Source</th>
<th>Date</th>
</tr>

@forelse($transactions as $t)

<tr>
<td>{{ $t->amount }}</td>
<td>{{ $t->type }}</td>
<td>{{ $t->source }}</td>
<td>{{ $t->created_at->format('d M Y H:i') }}</td>
</tr>

@empty

<tr>
<td colspan="3" class="text-center">No transactions found</td>
</tr>

@endforelse

</table>

</div>

@endsection