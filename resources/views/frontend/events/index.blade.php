@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold">Upcoming Events</h2>
            <p class="text-muted">Join our live webinars and training sessions</p>
        </div>
    </div>

    {{-- Alerts Section --}}
    <div class="row justify-content-center">
        <div class="col-md-8">

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

            @if(request('error') == 'payment_failed')
            <div class="alert alert-danger">
                Payment failed. Please try again.
            </div>
            @endif

            @if(request('error') == 'payment_cancelled')
            <div class="alert alert-warning">
                Payment cancelled by user.
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>
    </div>


    {{-- Events List --}}
    <div class="row g-4">

        @forelse($events as $event)

        <div class="col-lg-4 col-md-6">

            <div class="card h-100 shadow-sm border-0">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title fw-semibold">
                        {{ $event->title }}
                    </h5>

                    <p class="text-muted small mb-2">
                        {{ $event->description }}
                    </p>

                    <div class="mb-2">
                        <strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y H:i') }}
                    </div>

                    <div class="mb-2">
                        <strong>Price:</strong>
                        <span class="text-success fw-bold">
                            ₹{{ $event->price }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong>Team Members:</strong><br>

                        @foreach($event->faculties as $faculty)
                        <span class="badge bg-primary me-1">
                            {{ $faculty->name }}
                        </span>
                        @endforeach
                    </div>

                    <div class="mt-auto">

                        <form method="POST" action="{{ url('/events/book/'.$event->id) }}">
                            @csrf

                            <button class="btn btn-primary w-100">
                                Book Event
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12 text-center">
            <div class="alert alert-info">
                No events available at the moment.
            </div>
        </div>

        @endforelse

    </div>

</div>


<script>
setTimeout(function(){
    document.querySelectorAll('.alert').forEach(function(alert){
        alert.style.display='none';
    });
},4000);
</script>

@endsection