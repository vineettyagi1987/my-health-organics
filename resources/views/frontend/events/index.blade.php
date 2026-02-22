@extends('layouts.app')
@section('content')

<div class="container-fluid py-5">

    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold">Upcoming Events</h2>
            <p class="text-muted">Join our live webinars and training sessions</p>
        </div>
    </div>
    <div class="row mb-4 justify-content-center">

    <div class="col-md-4">

        <form method="GET" action="{{ url()->current() }}">
              @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
            <select name="category" class="form-select" onchange="this.form.submit()">

                <option value="">All Categories</option>    

                @foreach($categories as $category)

                <option value="{{ $category->id }}"
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>

                @endforeach

            </select>

        </form>

    </div>

</div>
    <div class="row">

        @forelse($events as $event)

        <div class="col-12 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="row">

                        {{-- Event Info --}}
                        <div class="col-lg-5">
                            @if($event->category)
                            <span class="badge bg-info mb-2">
                                {{ $event->category->name }}
                            </span>
                            @endif
                            <h4 class="fw-bold mb-2">
                                {{ $event->title }}
                            </h4>

                            <p class="text-muted">
                                {{ $event->description }}
                            </p>

                            <div class="mb-2">
                                <strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y H:i') }}
                            </div>

                            <div class="mb-3">
                                <strong>Price:</strong>
                                <span class="text-success fw-bold fs-5">
                                    ₹{{ $event->price }}
                                </span>
                            </div>
                            @if($event->status == 'active')
                                <span class="badge bg-success">Active</span>
                                @elseif($event->status == 'completed')
                                <span class="badge bg-secondary">Completed</span>
                                @elseif($event->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                                @endif
                        </div>


                        {{-- Faculty Section --}}
                        <div class="col-lg-5">

                            <strong>Event Team Members</strong>

                            <div class="mt-3">

                                @foreach($event->faculties as $faculty)

                                <div class="d-flex align-items-start mb-3 border rounded p-2">

                                    {{-- Faculty Image --}}
                                    @if($faculty->image)
                                    <img src="{{ asset('storage/'.$faculty->image) }}"
                                        class="rounded-circle me-3"
                                        width="60"
                                        height="60">
                                    @else
                                    <img src="https://via.placeholder.com/60"
                                        class="rounded-circle me-3">
                                    @endif

                                    {{-- Faculty Details --}}
                                    <div>

                                        <h6 class="mb-1 fw-bold">
                                            {{ $faculty->name }}
                                        </h6>

                                        @if($faculty->designation)
                                        <div class="text-muted small">
                                            {{ $faculty->designation }}
                                        </div>
                                        @endif
                                         @if($faculty->qualifications)
                                        <div class="text-muted small">
                                            {{ $faculty->qualifications }}
                                        </div>
                                        @endif

                                        @if($faculty->bio)
                                        <div class="small mt-1">
                                            {{ Str::limit($faculty->bio,80) }}
                                        </div>
                                        @endif

                                    </div>

                                </div>

                                @endforeach

                            </div>


                            {{-- Book Button --}}
                            <form method="POST" action="{{ url('/events/book/'.$event->id) }}">
                                @csrf

                                <button class="btn btn-primary w-100 mt-2">
                                    Book Event
                                </button>

                            </form>

                        </div>

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