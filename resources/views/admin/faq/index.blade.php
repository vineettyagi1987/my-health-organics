@extends('layouts.app')
@section('title','FAQ')
@section('content')
<div class="container">
<div class="d-flex justify-content-between mb-3">
<h4>FAQ</h4>
<a href="{{ route('admin.faq.create') }}" class="btn btn-success">Add</a>
</div>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


<table class="table table-bordered">
@foreach($faqs as $f)
<tr>
<td>{{ $f->question }}</td>
<td width="150">
<a href="{{ route('admin.faq.edit',$f) }}" class="btn btn-primary btn-sm">Edit</a>
<form method="POST" action="{{ route('admin.faq.destroy',$f) }}" class="d-inline">
@csrf @method('DELETE')
<button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
</form>
</td>
</tr>
@endforeach
</table>


{{ $faqs->links() }}
</div>
@endsection