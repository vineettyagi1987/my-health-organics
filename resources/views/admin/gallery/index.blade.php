@extends('layouts.app')
@section('title','Gallery')
@section('content')
<div class="container">
<div class="d-flex justify-content-between mb-3">
<h4>Gallery</h4>
<a href="{{ route('admin.gallery.create') }}" class="btn btn-success">Upload Image</a>
</div>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


<div class="row">
@foreach($galleries as $g)
<div class="col-md-3 mb-3" style="width:30%">
<div class="card h-100">
<img src="{{ asset('storage/'.$g->image) }}" class="card-img-top" style=object-fit:cover;">


<div class="card-body text-center">
<h6>{{ $g->title }}</h6>


<a href="{{ route('admin.gallery.edit',$g) }}" class="btn btn-sm btn-primary">Edit</a>


<form method="POST" action="{{ route('admin.gallery.destroy',$g) }}" class="d-inline">
@csrf @method('DELETE')
<button onclick="return confirm('Delete image?')" class="btn btn-sm btn-danger">Delete</button>
</form>
</div>
</div>
</div>
@endforeach
</div>


{{ $galleries->links() }}
</div>
@endsection