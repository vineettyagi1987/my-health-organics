@extends('layouts.app')

@section('content')

<div class="container">

<h3>Event Categories</h3>

<a href="{{ route('admin.event_categories.create') }}"
class="btn btn-primary mb-3">
Add Category
</a>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-bordered">

<thead>
<tr>
<th>S.No.</th>
<th>Name</th>
<th>Description</th>
<th width="150">Action</th>
</tr>
</thead>

<tbody>

@forelse($categories as $category)

<tr>

 <td>{{ $loop->index+1 }}</td>

<td>{{ $category->name }}</td>

<td>{{ $category->description }}</td>

<td>

<a href="{{ route('admin.event_categories.edit',$category->id) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('admin.event_categories.destroy',$category->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Delete Category?')">

Delete

</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center text-muted">
No Event Categories Found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection