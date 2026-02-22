@extends('layouts.app')

@section('title','My Booked Events')

@section('content')

<div class="container mt-4">

<h3>My Booked Events</h3>
<div class="col-md-12">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
</div>
<table class="table table-bordered mt-3">

<tr>
<th>Event</th>
<th>Team Members</th>
<th>Date</th>
<th>Status</th>
<th>Meeting</th>
</tr>

@forelse($bookings as $booking)

<tr>

<td>{{ $booking->event->title }}</td>

<td>

@foreach($booking->event->faculties as $faculty)

<span class="badge bg-info">
{{ $faculty->name }}
</span>

@endforeach

</td>

<td>
{{ $booking->event->event_date }}
</td>

<td>

@if($booking->status == 'paid')

<span class="badge bg-success">Paid</span>

@elseif($booking->status == 'free')

<span class="badge bg-primary">Free (Subscription)</span>

@else

<span class="badge bg-warning">Pending</span>

@endif

</td>

<td>

@if($booking->status == 'paid' || $booking->status == 'free')

<a href="{{ $booking->event->meeting_link }}"
class="btn btn-sm btn-success"
target="_blank">
Join Meeting
</a>

@else

<span class="text-muted">Not Available</span>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center">
No bookings found
</td>
</tr>

@endforelse

</table>

</div>

@endsection