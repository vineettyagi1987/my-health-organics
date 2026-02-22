@extends('layouts.app')
@section('title','Events ')
@section('content')

<h3>{{ $event->title }}</h3>

<img src="{{ asset('storage/'.$event->faculty->image) }}" width="200">

<p><strong>Faculty:</strong> {{ $event->faculty->name }}</p>
<p>{{ $event->description }}</p>

<p><strong>Date:</strong> {{ $event->event_date }} {{ $event->event_time }}</p>

@if(auth()->check())
    <form method="POST" action="{{ route('event.register',$event->id) }}">
        @csrf
        <button class="btn btn-success">
            Register @if($event->price>0) - ₹{{ $event->price }} @endif
        </button>
    </form>

    <a href="{{ route('event.join',$event->id) }}" class="btn btn-primary mt-2">
        Join Event
    </a>
@else
    <a href="{{ route('login') }}" class="btn btn-warning">Login to Register</a>
@endif

@endsection