@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <!-- HERO -->
    <section class="position-relative text-center text-white rounded shadow overflow-hidden mb-5"
    style="min-height:420px;
    background:linear-gradient(rgba(25,135,84,.85),rgba(13,110,253,.85)),
    url('{{ asset('images/banner.jpg') }}') center/cover no-repeat;">

        <div class="d-flex flex-column justify-content-center align-items-center h-100 p-4">
            <h1 class="display-4 fw-bold mb-3">Welcome to <strong>The Health Organics</strong></h1>
            <p class="lead mb-4">Project of the Save the Nature Foundation (Trust)!</p>

            <div class="d-flex gap-3 flex-wrap justify-content-center">
                <a href="{{ route('products.list') }}" class="btn btn-warning btn-lg">Shop All Products</a>
                <a href="{{ route('benefits') }}" class="btn btn-light btn-lg">Join Our Community</a>
            </div>
        </div>
    </section>


    <!-- ABOUT -->
    <section class="row align-items-center bg-light rounded shadow p-4 mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold mb-3">About The Health Organics</h2>

            <p class="text-muted">
               In today’s rapidly changing world, adapting to the times is essential for success and well-being. While we all dream big, the reality is that we often lack even the basic resources to meet our needs-and the few resources we do have are frequently polluted or unhealthy, leaving both our bodies and minds stressed, unwell, and dissatisfied.
</p>

            <p class="text-muted">
Despite our best intentions, it has become increasingly difficult to access pure and natural food products in a world flooded with synthetic/contaminated/adulterated/plasticized alternatives. Recognizing this urgent need, we are proud to launch “The Health Organics”, a chapter dedicated to offering you natural, healthy, and sustainable organic alternatives to improve your health, uplift your spirit, and transform your lifestyle.
            </p>

            <a href="{{ route('home') }}" class="btn btn-success mt-3">Discover Our Story</a>
        </div>

        <div class="col-md-6 text-center">
             <img src="{{ asset('images/plant.jpg') }}"
         class="img-fluid rounded shadow">
        </div>
    </section>


    <!-- FEATURED PRODUCTS -->
    <section class="mb-5">
        <h2 class="text-center fw-bold mb-4">Featured Products</h2>

        <div class="row g-4">
            <!-- @foreach($products->take(4) as $product)
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" height="200">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5>{{ $product->name }}</h5>
                        <p class="text-muted flex-grow-1">{{ Str::limit($product->description, 60) }}</p>
                        <p class="fw-bold text-success">₹{{ $product->price }}</p>
                        <div class="d-flex gap-2 mt-auto">
                            <button class="btn btn-success w-100">Add to Cart</button>
                            <a href="/products/{{ $product->id }}" class="btn btn-outline-secondary w-100">View</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach -->

            <div id="productSlider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

        @foreach($products->chunk(4) as $chunkIndex => $chunk)
            <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                <div class="container">
                    <div class="row">

                        @foreach($chunk as $product)
                            <div class="col-md-3">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="card-img-top" 
                                         style="height:200px; object-fit:cover;">

                                    <div class="card-body d-flex flex-column">
                                        <h5>{{ $product->name }}</h5>
                                        <p class="text-muted flex-grow-1">
                                            {{ Str::limit($product->description, 60) }}
                                        </p>
                                        <p class="fw-bold">₹{{ $product->price }}</p>

                                        <div class="mt-auto d-flex gap-2">

                                            <a href="{{ url('/product/' . $product->slug) }}" 
                                               class="btn btn-outline-primary w-50">
                                                View
                                            </a>

                                            <form action="{{ url('/cart/add') }}" 
                                                  method="POST" 
                                                  class="w-50">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    Add
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

<div id="productSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">

        </div>

        <div class="text-center mt-4">
            <a href="{{ route('products.list') }}" class="btn btn-outline-dark">View All Products</a>
        </div>
    </section>


    <!-- SPECIAL / BENEFITS -->
    <section class="row align-items-center bg-light rounded shadow p-4 mb-5">
        <div class="col-md-6 order-md-2">
            <h2 class="fw-bold mb-3">What makes The Health Organics special?</h2>
            <p class="text-muted">
              Our organic products and services are designed to benefit everyone- no matter who you are or where you come from. Anyone can purchase our products and services, take advantage of our wellness services, and share these benefits with friends, family, relatives, neighbors, and their broader community.
            </p>
            <a href="{{ route('benefits') }}" class="btn btn-success">Explore Our Values</a>
        </div>

        <div class="col-md-6 order-md-1 text-center">
            <img src="{{ asset('images/banner.jpg') }}"
                 class="img-fluid rounded shadow">
        </div>
    </section>


    <!-- OFFERINGS -->
    <section class="row align-items-center bg-light rounded shadow p-4 mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold mb-3">With The Health Organics, we offer you:</h2>
            <p>We are dedicated to providing a holistic approach to wellness. Our offerings are carefully curated to ensure they meet the highest standards of quality and efficacy, supporting your journey towards a healthier and more vibrant life.</p>
            <ul class="list-unstyled">
                <li>✅ Nutrient-rich organic products</li>
                <li>✅ Eco-friendly living solutions</li>
                <li>✅ Expert health guidance</li>
                <li>✅ Financial assistance opportunities</li>
                <li>✅ Respectable social work opportunities</li>
                <li>✅ Clean and healthy environment</li>
            </ul>

            <a href="{{ route('products.list') }}" class="btn btn-success mt-2">Explore Offerings</a>
        </div>

       <div class="col-md-6 text-center">
            <img src="{{ asset('images/dashboard.jpg') }}"
                class="img-fluid rounded shadow">
        </div>
    </section>


    <!-- QUOTE -->
    <section class="text-center bg-light rounded shadow p-5 mb-5">
        <p class="text-muted">We firmly believe:</p>
        <blockquote class="blockquote">
            <p class="fs-3 text-success fst-italic">
                “Health is the first wealth; the greatest happiness is a healthy body.”
            </p>
        </blockquote>
        <p class="text-muted">
           For your strong body, joyful mind, and fulfilling life, our foundation offers a simple, natural path- delivered through the pure products and meaningful services of The Health Organics.
        </p>
    </section>


    <!-- PRINCIPLES -->
    <section class="text-center mb-5">
        <h2 class="fw-bold mb-4">Our Guiding Principles</h2>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow-sm h-100"><div class="card-body">
                    <h5>Purity & Authenticity</h5>
                    <p class="text-muted small">We are committed to providing pure, authentic, organic products.</p>
                </div></div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm h-100"><div class="card-body">
                    <h5>Transparency & Honesty</h5>
                    <p class="text-muted small">We respect open, honest, and transparent thinking.</p>
                </div></div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm h-100"><div class="card-body">
                    <h5>Well-being & Growth</h5>
                    <p class="text-muted small">We strive to see every individual healthy, happy, and thriving.</p>
                </div></div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm h-100"><div class="card-body">
                    <h5>Commitment & Integrity</h5>
                    <p class="text-muted small">We will always uphold and live by these core values.</p>
                </div></div>
            </div>
        </div>
    </section>


    <!-- CONTACT -->
    <section class="text-center bg-light rounded shadow p-5">
        <h2 class="fw-bold mb-3">Get in Touch</h2>
        <p class="text-muted mb-4">
            Join us on this journey toward better health, sustainable living, and a happier, more fulfilled you.

            With The Health Organics, let’s embrace nature, restore balance, and create a healthier future together.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-success btn-lg">Contact Us</a>
    </section>



@endsection
