@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Hero Section -->
    <div class="text-center mb-5">
        <svg xmlns="http://www.w3.org/2000/svg"
             width="24"
             height="24"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             class="mx-auto mb-4"
             style="width:80px; height:80px; color:#0d6efd;">
            <path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path>
            <circle cx="12" cy="8" r="6"></circle>
        </svg>

        <h1 class="fw-bold mb-3">The Health Organics Membership</h1>

        <p class="text-muted mx-auto" style="max-width:700px;">
            Elevate your wellness journey by becoming a valued member of 
            The Health Organics community. Unlock exclusive benefits, 
            enjoy special discounts, and get more from your organics lifestyle.
        </p>
    </div>


    <!-- Benefits Section -->
    <div class="row mb-5">
        @forelse($benefits as $benefit)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mb-3">
                            {{ $benefit->title }}
                        </h5>
                        <p class="card-text text-muted">
                            {{ $benefit->description }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                No benefits available at the moment.
            </div>
        @endforelse
    </div>


    <!-- Join Membership CTA Section -->
    <div class="card shadow-lg border-0 text-center py-4 mb-5">
        <div class="card-body">
            <h3 class="fw-bold mb-3">Join Membership</h3>

            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     class="me-2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <line x1="19" x2="19" y1="8" y2="14"></line>
                    <line x1="22" x2="16" y1="11" y2="11"></line>
                </svg>
                Create an Account
            </a>
        </div>
    </div>

<!-- Terms & Conditions Section -->
<div class="mb-5 text-center">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Terms & Conditions</h2>
        <p class="text-muted mx-auto" style="max-width:700px;">
            Please read the following terms carefully before becoming a member.
        </p>
    </div>

    <div class="accordion" id="termsAccordion">
        @forelse($terms as $key => $term)
            <div class="accordion-item mb-2 border rounded shadow-sm">
                <h2 class="accordion-header" id="heading{{ $key }}">
                    <button class="accordion-button {{ $key != 0 ? 'collapsed' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $key }}"
                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $key }}">
                        {{ $term->title }}
                    </button>
                </h2>

                <div id="collapse{{ $key }}"
                     class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                     aria-labelledby="heading{{ $key }}"
                     data-bs-parent="#termsAccordion">
                    <div class="accordion-body text-muted">
                        {{ $term->content }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted">
                No terms available at the moment.
            </div>
        @endforelse
    </div>
</div>

</div>
@endsection