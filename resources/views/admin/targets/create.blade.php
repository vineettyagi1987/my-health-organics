@extends('layouts.app')

@section('content')

<div class="container">

<h3>Add Employee Target</h3>

<form method="POST" action="{{ route('admin.targets.store') }}">

@csrf

<div class="mb-3">
<label>Select Employee</label>

<select name="user_id" class="form-control">

@foreach($employees as $emp)

<option value="{{ $emp->id }}">
{{ $emp->name }}
</option>

@endforeach

</select>
</div>


<div class="mb-3">
<label>Weekly Target</label>

<input type="number" name="weekly_target" class="form-control">
</div>


<button class="btn btn-success">
Save Target
</button>

</form>

</div>

@endsection