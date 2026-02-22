@extends('layouts.app')

@section('content')

<div class="container mt-4">
 <div class="row justify-content-center">
        <div class="col-md-6">
<h3>Add Member</h3>
 {{-- Flash Error Message --}} 
@if($errors->any()) 
<div class="alert alert-danger"> 
    <ul class="mb-0"> @foreach($errors->all() as $error) 
        <li>{{ $error }}</li>
         @endforeach
         </ul>
         </div>
 @endif
<form action="{{ route('admin.faculties.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="mb-3">
<label>Name</label>

<input type="text"
       name="name"
       class="form-control"
       required>

</div>
<div class="mb-3">
<label>Designation</label>

<input type="text"
name="designation"
class="form-control"
value="{{ old('designation', $faculty->designation ?? '') }}">
</div>


<div class="mb-3">
<label>Qualifications</label>

<textarea name="qualifications"
class="form-control">{{ old('qualifications', $faculty->qualifications ?? '') }}</textarea>
</div>

<div class="mb-3">
<label>Image</label>

<input type="file"
       name="image"
       class="form-control">
</div>


<div class="mb-3">
<label>Bio</label>

<textarea name="bio"
          class="form-control"
          rows="4"></textarea>
</div>


<button class="btn btn-success">
Save Member
</button>

<a href="{{ route('admin.faculties.index') }}"
   class="btn btn-secondary">
Cancel
</a>


</form>

</div>
</div>
</div>

@endsection