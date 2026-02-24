@extends('layouts.app')

@section('content')

<div class="container">

<h3>Employee Sales Dashboard</h3>

<h4>Total Collection : ₹ {{ $totalCollection }}</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


<div class="card mb-4">
<div class="card-header">Add Daily Sale</div>

<div class="card-body">

<form method="POST" action="{{ route('employee.sale.store') }}">
@csrf

<div class="row">

<div class="col-md-3">
<input type="text" name="product_name" class="form-control" placeholder="Product Name">
</div>

<div class="col-md-2">
<input type="number" name="quantity" class="form-control" placeholder="Qty">
</div>

<div class="col-md-3">
<input type="number" name="amount" class="form-control" placeholder="Amount">
</div>

<div class="col-md-3">
<input type="date" name="sale_date" class="form-control">
</div>

<div class="col-md-1">
<button class="btn btn-success">Add</button>
</div>

</div>

</form>

</div>
</div>


<h4>Weekly Performance</h4>

@php
$targetAmount = $target->weekly_target ?? 0;
@endphp

<table class="table table-bordered {{ $weeklySale < $targetAmount ? 'table-danger' : 'table-success' }}">

<tr>
<th>Weekly Target</th>
<th>Achieved</th>
</tr>

<tr>
<td>₹ {{ $targetAmount }}</td>
<td>₹ {{ $weeklySale }}</td>
</tr>

</table>



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
<th>Action</th>
</tr>

@forelse($sales as $sale)

<tr>
<td>{{ $sale->sale_date }}</td>
<td>{{ $sale->product_name }}</td>
<td>{{ $sale->quantity }}</td>
<td>₹ {{ $sale->amount }}</td>

<td>
<a href="{{ route('employee.sale.edit',$sale->id) }}" 
class="btn btn-sm btn-primary">
Edit
</a>
</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center text-danger">
No Record Found
</td>
</tr>

@endforelse

</table>
{{ $sales->links() }}
@endsection