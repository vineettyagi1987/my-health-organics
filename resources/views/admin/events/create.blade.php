@extends('layouts.app')

@section('title','Manage Events')
@section('content')
<div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
<h3>Add Event</h3>
{{-- Flash Error Message --}} 
@if($errors->any()) 
<div class="alert alert-danger"> 
    <ul class="mb-0"> @foreach($errors->all() as $error) 
        <li>{{ $error }}</li>
         @endforeach
         </ul>
         </div>
 @endif
<form method="POST" action="{{ route('admin.events.store') }}">
    @csrf
    <div class="mb-3">
        <label>Category</label>
        <select name="event_category_id" class="form-control">

            @foreach($categories as $category)

            <option value="{{ $category->id }}">
            {{ $category->name }}
            </option>

            @endforeach

            </select>
    </div>
     <div class="mb-3">

        <label>Select Team Members</label>

      

       @foreach($faculties as $faculty)

<div class="form-check">

<input type="checkbox"
       name="faculties[]"
       value="{{ $faculty->id }}"
       class="form-check-input">

<label class="form-check-label">
{{ $faculty->name }}
</label>

</div>

@endforeach

        </select>

   </div>

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="event_date" class="form-control">
    </div>

    <div class="mb-3">
        <label>Time</label>
        <input type="time" name="event_time" class="form-control">
    </div>

    <div class="mb-3">
        <label>Price (0 for free)</label>
        <input type="number" name="price" class="form-control">
    </div>
    <div class="mb-3">

        <label>Meeting Link</label>

        <input type="text"
        name="meeting_link"
        class="form-control"
        placeholder="Zoom / Google Meet link">

        </div>
        <div class="mb-3">
            <label>Status</label>

        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        </div>
    <button class="btn btn-success">Create Event</button>
</form>
</div>
</div>
</div>
@endsection