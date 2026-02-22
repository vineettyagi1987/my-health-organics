@extends('layouts.app')

@section('title','Manage Events')

@section('content')

<div class="container">

<h3>Events</h3>

<a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">
Add Event
</a>

{{-- Success Message --}}
@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif


<table class="table table-bordered">

<thead>

<tr>
<th>Title</th>
<th>Category</th>
<th>Team Members</th>
<th>Date</th>
<th>Price</th>
<th>Status</th>
<th>Meeting Link</th>
<th width="150">Action</th>
</tr>

</thead>

<tbody>

@forelse($events as $event)

<tr>

<td>{{ $event->title }}</td>

<td>{{ $event->category->name ?? 'No Category' }}</td>

<td>

@foreach($event->faculties as $faculty)

<span class="badge bg-info">
{{ $faculty->name }}
</span>

@endforeach

</td>

<td>

{{ $event->event_date }}

@if($event->event_time)

<br>
<small>{{ $event->event_time }}</small>

@endif

</td>

<td>

₹{{ $event->price }}

</td>
<td>
    @if($event->status == 'active')
    <span class="badge bg-success">Active</span>
    
    @elseif($event->status == 'inactive')
    <span class="badge bg-warning">Inactive</span>
    @elseif($event->status == 'completed')
    <span class="badge bg-secondary">Completed</span>
    @elseif($event->status == 'cancelled')
    <span class="badge bg-danger">Cancelled</span>
    @endif
</td>
<td>
<a href="{{ $event->meeting_link }}" target="_blank">Click Here</a>
</td>

<td>

<a href="{{ route('admin.events.edit',$event->id) }}"
class="btn btn-warning btn-sm">

Edit

</a>


<form action="{{ route('admin.events.destroy',$event->id) }}"
method="POST"
style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this event?')">

Delete

</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center text-muted">
No Events Found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection