@extends('layouts.app')
@section('title','Categories')


@section('content')
<div class="container">


<div class="d-flex justify-content-between mb-3">
<h4>Categories</h4>
<a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add Category</a>
</div>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


<table class="table table-bordered">
<tr>
<th>Name</th>
<th>Status</th>
<th width="150">Action</th>
</tr>


@foreach($categories as $category)
<tr>
<td>{{ $category->name }}</td>
<td>
<span class="badge bg-{{ $category->status ? 'success' : 'danger' }}">
{{ $category->status ? 'Active' : 'Inactive' }}
</span>
</td>
<td>
<a href="{{ route('admin.categories.edit',$category) }}" class="btn btn-sm btn-primary">Edit</a>


<form method="POST" action="{{ route('admin.categories.destroy',$category) }}" class="d-inline">
@csrf @method('DELETE')
<button onclick="return confirm('Delete category?')" class="btn btn-sm btn-danger">Delete</button>
@endforeach
</form>
</td>
</tr>
</table>
@endsection