@extends('layouts.app')
@section('title','Edit Image')


@section('content')
<div class="container">
       <div class="row justify-content-center">
        <div class="col-md-6"> 
<h4>Edit Image</h4>

 {{-- Flash Error Message --}} 
@if($errors->any()) 
<div class="alert alert-danger"> 
    <ul class="mb-0"> @foreach($errors->all() as $error) 
        <li>{{ $error }}</li>
         @endforeach
         </ul>
         </div>
 @endif
<form method="POST" action="{{ route('admin.gallery.update',$gallery) }}" enctype="multipart/form-data">
@csrf @method('PUT')


<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" value="{{ old('title',$gallery->title) }}">
</div>


<div class="mb-3">
<label>Current Image</label><br>
<img src="{{ asset('storage/'.$gallery->image) }}" width="150" class="mb-2">
</div>


<div class="mb-3">
<label>Change Image</label>
<input type="file" name="image" class="form-control">
</div>


<button class="btn btn-primary">Update</button>
<a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Back</a>
</form>
</div>
@endsection