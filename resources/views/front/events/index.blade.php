@extends('layouts.app')
@section('title','Events Listing')
@section('content')

<h2>Upcoming Events</h2>

<div class="row">
@foreach($events as $event)
<div class="col-md-4">
    <div class="card mb-3">
        <img src="{{ asset('storage/'.$event->faculty->image) }}" class="card-img-top">

        <div class="card-body">
            <h5>{{ $event->title }}</h5>
            <p>{{ $event->faculty->name }}</p>

            @if($event->price > 0)
                <span class="badge bg-danger">Paid - ₹{{ $event->price }}</span>
            @else
                <span class="badge bg-success">Free</span>
            @endif

            <a href="{{ route('event.show',$event->id) }}" class="btn btn-primary mt-2">
                View
            </a>
        </div>
    </div>
</div>
@endforeach
</div>

@endsection