@extends('layouts.app')
@section('title','Upload Image')


@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-6"> 
<h4>Upload Image</h4>
 {{-- Flash Error Message --}} 
@if($errors->any()) 
<div class="alert alert-danger"> 
    <ul class="mb-0"> @foreach($errors->all() as $error) 
        <li>{{ $error }}</li>
         @endforeach
         </ul>
         </div>
 @endif

<form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
@csrf


<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" value="{{ old('title') }}">
</div>


<div class="mb-3">
<label>Image</label>
<input type="file" name="image" class="form-control" required>
</div>


<button class="btn btn-success">Upload</button>
<a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Back</a>
</form>
</div>
</div> </div>
@endsection