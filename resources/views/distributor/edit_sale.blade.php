@extends('layouts.app')

@section('content')

<div class="container">

<h3>Edit Sales Report</h3>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif


<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('distributor.sale.update',$sale->id) }}">

@csrf

<div class="row mb-3">

<div class="col-md-6">

<label class="form-label">Product Name</label>

<input type="text"
name="product_name"
value="{{ $sale->product_name }}"
class="form-control"
required>

</div>


<div class="col-md-3">

<label class="form-label">Quantity</label>

<input type="number"
name="quantity"
value="{{ $sale->quantity }}"
class="form-control"
required>

</div>


<div class="col-md-3">

<label class="form-label">Amount</label>

<input type="number"
name="amount"
value="{{ $sale->amount }}"
class="form-control"
required>

</div>

</div>



<div class="row mb-3">

<div class="col-md-4">

<label class="form-label">Sale Date</label>

<input type="date"
name="sale_date"
value="{{ $sale->sale_date }}"
class="form-control"
required>

</div>

</div>



<button class="btn btn-success">
Update Sale
</button>

<a href="{{ route('distributor.dashboard') }}"
class="btn btn-secondary">
Back
</a>

</form>

</div>

</div>

</div>

@endsection