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
@endsection