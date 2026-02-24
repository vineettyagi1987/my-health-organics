@extends('layouts.app')

@section('content')

<div class="container">

<h3>Edit Target</h3>

<form method="POST" action="{{ route('admin.targets.update',$target->id) }}">

@csrf
@method('PUT')

<div class="mb-3">

<label>Employee</label>

<select name="user_id" class="form-control">

@foreach($employees as $emp)

<option value="{{ $emp->id }}" 
{{ $target->user_id == $emp->id ? 'selected' : '' }}>

{{ $emp->name }}

</option>

@endforeach

</select>

</div>


<div class="mb-3">

<label>Weekly Target</label>

<input type="number" name="weekly_target" class="form-control"
value="{{ $target->weekly_target }}">

</div>


<button class="btn btn-success">
Update Target
</button>

</form>

</div>

@endsection