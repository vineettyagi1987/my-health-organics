@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Page Heading -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Our Gallery</h2>
        <p class="text-muted">Explore moments from The Health Organics journey.</p>
    </div>

    <div class="row">
        @forelse($galleries as $gallery)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm h-100">

                    <a href="{{ asset('storage/'.$gallery->image) }}" target="_blank">
                        <img src="{{ asset('storage/'.$gallery->image) }}" 
                             class="card-img-top"
                             style="height:250px; object-fit:cover;">
                    </a>

                    @if($gallery->title)
                        <div class="card-body text-center">
                            <h6 class="fw-semibold">{{ $gallery->title }}</h6>
                        </div>
                    @endif

                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                No gallery images available.
            </div>
        @endforelse
    </div>
    {{ $galleries->links() }}
<div class="container py-5">

    <!-- Page Heading -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Frequently Asked Questions</h2>
        <p class="text-muted">Find answers to common questions about our services.</p>
    </div>

    <div class="accordion" id="faqAccordion">

        @forelse($faqs as $faq)
        <div class="accordion-item mb-3 border-0 shadow-sm">
            <h2 class="accordion-header" id="heading{{ $faq->id }}">
                <button class="accordion-button collapsed fw-semibold"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $faq->id }}"
                        aria-expanded="false"
                        aria-controls="collapse{{ $faq->id }}">
                    {{ $faq->question }}
                </button>
            </h2>

            <div id="collapse{{ $faq->id }}"
                 class="accordion-collapse collapse"
                 aria-labelledby="heading{{ $faq->id }}"
                 data-bs-parent="#faqAccordion">
                <div class="accordion-body text-muted">
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
        </div>
        @empty
            <div class="text-center text-muted">
                No FAQs available.
            </div>
        @endforelse

    </div>

</div>
</div>
<div class="container py-0">

<div class="row mb-4 text-center">
<h2 class="fw-bold">Coming Soon</h2>
<p class="text-muted">Stay tuned for our upcoming products, meetings and seminars</p>
</div>

<div class="row">

@forelse($items as $item)

<div class="col-lg-4 col-md-6 mb-4">

<div class="card h-100 shadow-sm border-0">

@if($item->image)
<img src="{{ asset('storage/'.$item->image) }}"
class="card-img-top"
style="height:200px;object-fit:cover;">
@endif

<div class="card-body">

<span class="badge bg-info mb-2">
{{ ucfirst($item->type) }}
</span>

<h5 class="card-title">
{{ $item->title }}
</h5>

<p class="text-muted small">
{{ Str::limit($item->description,100) }}
</p>

@if($item->launch_date)
<p class="mb-1">
<strong>Launch Date:</strong>
{{ \Carbon\Carbon::parse($item->launch_date)->format('d M Y') }}
</p>
@endif

@if($item->location)
<p class="mb-2">
<strong>Location:</strong> {{ $item->location }}
</p>
@endif

<span class="badge bg-warning text-dark">
Coming Soon
</span>

</div>

</div>

</div>

@empty

<div class="col-12 text-center">
<div class="alert alert-info">
No upcoming items available.
</div>
</div>

@endforelse

</div>

</div>
@endsection