@extends('layouts.app')

@section('content')
<div class="container mt-4">
 <div class="row justify-content-center">
        <div class="col-md-6">
<h3>Add Event Category</h3>
{{-- Flash Error Message --}} 
@if($errors->any()) 
<div class="alert alert-danger"> 
    <ul class="mb-0"> @foreach($errors->all() as $error) 
        <li>{{ $error }}</li>
         @endforeach
         </ul>
         </div>
 @endif
 {{-- Success Message --}}
@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif
<form action="{{ route('admin.event_categories.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Name</label>

<input type="text"
name="name"
class="form-control"
required>

</div>


<div class="mb-3">

<label>Description</label>

<textarea name="description"
class="form-control"></textarea>

</div>

<button class="btn btn-success">
Save Category
</button>

</form>
</div>
</div>
</div>

@endsection