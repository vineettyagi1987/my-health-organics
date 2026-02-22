@extends('layouts.app')

@section('content')

<h3>{{ $event->title }}</h3>

<iframe
  src="https://meet.jit.si/{{ $event->video_room_id }}"
  allow="camera; microphone; fullscreen"
  style="height:600px;width:100%;">
</iframe>

@endsection