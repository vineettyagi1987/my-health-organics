@extends('layouts.app')
@section('title','Benefits')


@section('content')
<div class="container">
<div class="d-flex justify-content-between mb-3">
<h4>Benefits</h4>
<a href="{{ route('admin.benefits.create') }}" class="btn btn-success">Add Benefit</a>
</div>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


<table class="table table-bordered">
<tr>
<th>Title</th>
<th>Status</th>
<th width="150">Action</th>
</tr>
@foreach($benefits as $b)
<tr>
<td>{{ $b->title }}</td>
<td>{{ $b->status ? 'Active' : 'Inactive' }}</td>
<td>
<a href="{{ route('admin.benefits.edit',$b) }}" class="btn btn-sm btn-primary">Edit</a>
<form action="{{ route('admin.benefits.destroy',$b) }}" method="POST" class="d-inline">
@csrf @method('DELETE')
<button class="btn btn-sm btn-danger">Delete</button>
</form>
</td>
</tr>
@endforeach
</table>


{{ $benefits->links() }}
</div>
@endsection