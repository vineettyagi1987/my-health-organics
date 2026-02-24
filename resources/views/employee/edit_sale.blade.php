@extends('layouts.app')

@section('content')

<div class="container">

<h3>Edit Sales Report</h3>

<form method="POST" action="{{ route('employee.sale.update',$sale->id) }}">

@csrf

<div class="mb-3">
<label>Product Name</label>

<input type="text" name="product_name"
value="{{ $sale->product_name }}"
class="form-control">
</div>


<div class="mb-3">
<label>Quantity</label>

<input type="number" name="quantity"
value="{{ $sale->quantity }}"
class="form-control">
</div>


<div class="mb-3">
<label>Amount</label>

<input type="number" name="amount"
value="{{ $sale->amount }}"
class="form-control">
</div>


<div class="mb-3">
<label>Sale Date</label>

<input type="date" name="sale_date"
value="{{ $sale->sale_date }}"
class="form-control">
</div>


<button class="btn btn-success">
Update Sales
</button>

<a href="{{ route('employee.dashboard') }}"
class="btn btn-secondary">
Back
</a>

</form>

</div>

@endsection