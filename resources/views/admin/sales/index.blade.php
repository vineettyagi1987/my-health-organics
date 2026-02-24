@extends('layouts.app')

@section('content')

<div class="container">

<h3>Employee Sales Records</h3>

<div class="card mb-3">
<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-4">

<select name="employee_id" class="form-control">

<option value="">All Employees</option>

@foreach($employees as $emp)

<option value="{{ $emp->id }}"
{{ request('employee_id') == $emp->id ? 'selected' : '' }}>

{{ $emp->name.'('.$emp->emp_id.')' }}

</option>

@endforeach

</select>

</div>

<div class="col-md-2">
<button class="btn btn-primary">
Filter
</button>
</div>

</div>

</form>

</div>
</div>


<div class="alert alert-info">

Total Collection : ₹ {{ $totalCollection }}

</div>



<table class="table table-bordered">

<tr>
<th>Employee</th>
<th>Date</th>
<th>Product</th>
<th>Qty</th>
<th>Amount</th>
</tr>


@forelse($sales as $sale)

<tr>

<td>{{ $sale->user->name.'('.$sale->user->emp_id.')' }}</td>

<td>{{ $sale->sale_date }}</td>

<td>{{ $sale->product_name }}</td>

<td>{{ $sale->quantity }}</td>

<td>₹ {{ $sale->amount }}</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center text-danger">
No Record Found
</td>
</tr>

@endforelse


</table>


<div class="d-flex justify-content-center">
{{ $sales->links() }}
</div>


</div>

@endsection