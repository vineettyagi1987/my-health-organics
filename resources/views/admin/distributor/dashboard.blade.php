@extends('layouts.app')

@section('content')

<div class="container">

<h3>Distributor Sales Dashboard</h3>

<form method="GET">

<div class="row mb-3">

<div class="col-md-4">

<select name="distributor_id" class="form-control">

<option value="">Select Distributor</option>

@foreach($distributors as $d)

<option value="{{ $d->id }}"
{{ $selectedDistributor == $d->id ? 'selected' : '' }}>

{{ $d->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-2">

<button class="btn btn-primary">
Load
</button>

</div>

</div>

</form>


@if($selectedDistributor)

<div class="alert alert-info">

Total Collection : ₹ {{ $totalCollection }}

<br>

Commission Rate : {{ $commissionRate }}%

<br>

Total Commission : ₹ {{ $totalCommission }}

</div>


<h4>Product Sales</h4>

<table class="table table-bordered">

<tr>
<th>Product</th>
<th>Total Qty</th>
</tr>

@forelse($products as $p)

<tr>
<td>{{ $p->product_name }}</td>
<td>{{ $p->qty }}</td>
</tr>

@empty

<tr>
<td colspan="2" class="text-center text-danger">
No Record Found
</td>
</tr>

@endforelse

</table>


<h4>Daily Sales</h4>

<table class="table table-bordered">

<tr>
<th>Date</th>
<th>Product</th>
<th>Qty</th>
<th>Amount</th>
</tr>

@forelse($sales as $sale)

<tr>

<td>{{ $sale->sale_date }}</td>

<td>{{ $sale->product_name }}</td>

<td>{{ $sale->quantity }}</td>

<td>₹ {{ $sale->amount }}</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center text-danger">
No Record Found
</td>
</tr>

@endforelse

</table>


<div class="d-flex justify-content-center">
{{ $sales->links() }}
</div>

@endif

</div>

@endsection