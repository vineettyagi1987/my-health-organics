@extends('layouts.app')
@section('title','Terms')
@section('content')
<div class="container">
<div class="d-flex justify-content-between mb-3">
<h4>Terms</h4>
<a href="{{ route('admin.terms.create') }}" class="btn btn-success">Add</a>
</div>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
@foreach($terms as $t)
<tr>
<td>{{ $t->title }}</td>
<td width="150">
<a href="{{ route('admin.terms.edit',$t) }}" class="btn btn-primary btn-sm">Edit</a>
<form method="POST" action="{{ route('admin.terms.destroy',$t) }}" class="d-inline">
@csrf @method('DELETE')
<button onclick="return confirm('Delete term?')" class="btn btn-danger btn-sm">Delete</button>
</form>
</td>
</tr>
@endforeach
</table>


{{ $terms->links() }}
</div>
@endsection