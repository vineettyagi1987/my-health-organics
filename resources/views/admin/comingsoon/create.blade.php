@extends('layouts.app')

@section('content')

<div class="container">
 <div class="row justify-content-center">
        <div class="col-md-6">
<h3>Add Coming Soon Item</h3>
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
<form method="POST" action="{{ route('admin.comingsoon.store') }}" enctype="multipart/form-data">
@csrf

<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control">
</div>

<div class="mb-3">
<label>Type</label>
<select name="type" class="form-control">
<option value="product">Product</option>
<option value="meeting">Meeting</option>
<option value="seminar">Seminar</option>
<option value="place">Place</option>
</select>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Launch Date</label>
<input type="date" name="launch_date" class="form-control">
</div>

<div class="mb-3">
<label>Location</label>
<input type="text" name="location" class="form-control">
</div>

<div class="mb-3">
<label>Image</label>
<input type="file" name="image" class="form-control">
</div>

<button class="btn btn-success">Save</button>

</form>

</div>
</div>
</div>
@endsection