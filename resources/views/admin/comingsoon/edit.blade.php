@extends('layouts.app')

@section('content')

<div class="container">
 <div class="row justify-content-center">
        <div class="col-md-6">
<h3 class="mb-4">Edit Coming Soon Item</h3>
    {{-- Flash Error Message --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('admin.comingsoon.update',$item->id) }}" enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Title</label>
<input type="text" name="title" class="form-control"
value="{{ $item->title }}" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Type</label>
<select name="type" class="form-control">

<option value="product" {{ $item->type=='product' ? 'selected' : '' }}>
Product
</option>

<option value="meeting" {{ $item->type=='meeting' ? 'selected' : '' }}>
Meeting
</option>

<option value="seminar" {{ $item->type=='seminar' ? 'selected' : '' }}>
Seminar
</option>

<option value="place" {{ $item->type=='place' ? 'selected' : '' }}>
Place
</option>

</select>
</div>

<div class="col-md-12 mb-3">
<label class="form-label">Description</label>
<textarea name="description" class="form-control" rows="4">
{{ $item->description }}
</textarea>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Launch Date</label>
<input type="date" name="launch_date" class="form-control"
value="{{ $item->launch_date }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Location</label>
<input type="text" name="location" class="form-control"
value="{{ $item->location }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Status</label>
<select name="status" class="form-control">

<option value="active" {{ $item->status=='active' ? 'selected' : '' }}>
Active
</option>

<option value="inactive" {{ $item->status=='inactive' ? 'selected' : '' }}>
Inactive
</option>

</select>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Image</label>
<input type="file" name="image" class="form-control">
</div>

@if($item->image)

<div class="col-md-12 mb-3">
<label class="form-label">Current Image</label><br>

<img src="{{ asset('storage/'.$item->image) }}"
width="150"
class="img-thumbnail">

</div>

@endif

</div>

<button class="btn btn-success">
Update
</button>

<a href="{{ route('admin.comingsoon.index') }}" class="btn btn-secondary">
Back
</a>

</form>

</div>
</div>
</div>
@endsection