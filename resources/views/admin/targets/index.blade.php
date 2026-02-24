@extends('layouts.app')

@section('content')

<div class="container">

<h3>Employee Weekly Targets</h3>

<a href="{{ route('admin.targets.create') }}" class="btn btn-primary mb-3">
Add Target
</a>

<table class="table table-bordered">

<tr>
<th>Employee</th>
<th>Weekly Target</th>
<th>Action</th>
</tr>

@forelse($targets as $t)

<tr>
<td>{{ $t->user->name }}</td>
<td>₹ {{ $t->weekly_target }}</td>

<td>

<a href="{{ route('admin.targets.edit',$t->id) }}" class="btn btn-warning btn-sm">
Edit
</a>

<form method="POST" action="{{ route('admin.targets.destroy',$t->id) }}" style="display:inline">
@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="3" class="text-center text-danger">
No Target Found
</td>
</tr>

@endforelse

</table>

</div>

@endsection