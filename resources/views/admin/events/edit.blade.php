@extends('layouts.app')

@section('title','Edit Event')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
<h3>Edit Event</h3>

{{-- Validation Errors --}}
@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach ($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif


<form action="{{ route('admin.events.update',$event->id) }}" method="POST">

@csrf
@method('PUT')


<div class="mb-3">

<label>Event Title</label>

<input type="text"
name="title"
class="form-control"
value="{{ $event->title }}"
required>

</div>



<div class="mb-3">

<label>Description</label>

<textarea name="description"
class="form-control"
rows="4"
required>{{ $event->description }}</textarea>

</div>



<div class="mb-3">

<label>Category</label>

<select name="event_category_id" class="form-control" required>

<option value="">Select Category</option>

@foreach($categories as $category)

<option value="{{ $category->id }}"
@if($event->event_category_id == $category->id) selected @endif>

{{ $category->name }}

</option>

@endforeach

</select>

</div>



<div class="mb-3">

<label>Team Members</label>

<select name="faculties[]" class="form-control" multiple required>

@foreach($faculties as $faculty)

<option value="{{ $faculty->id }}"
@if($event->faculties->contains($faculty->id)) selected @endif>

{{ $faculty->name }}

</option>

@endforeach

</select>

</div>



<div class="mb-3">

<label>Event Date</label>

<input type="date"
name="event_date"
class="form-control"
value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}">
required>

</div>



<div class="mb-3">

<label>Event Time</label>

<input type="time"
name="event_time"
class="form-control"
value="{{ \Carbon\Carbon::parse($event->event_date)->format('H:i') }}">

</div>



<div class="mb-3">

<label>Price</label>

<input type="number"
name="price"
class="form-control"
value="{{ $event->price }}"
required>

</div>



<div class="mb-3">

<label>Meeting Link</label>

<input type="text"
name="meeting_link"
class="form-control"
value="{{ $event->meeting_link }}"
placeholder="Zoom / Google Meet link">

</div>



<button class="btn btn-success">

Update Event

</button>

<a href="{{ route('admin.events.index') }}"
class="btn btn-secondary">

Back

</a>


</form>

</div>
</div>
</div>
@endsection