@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- Hero --}}
<section class="bg-success text-white text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Welcome to The Health Organics</h1>
        <p class="lead">Project of the Save the Nature Foundation</p>

        <a href="#" class="btn btn-light me-2">Shop Products</a>
        <a href="#" class="btn btn-outline-light">Join Community</a>
    </div>
</section>


{{-- About --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-6">
                <h2 class="fw-bold mb-3">About The Health Organic</h2>
                <p>
                    We provide natural, healthy and sustainable organic products
                    to improve your health and lifestyle.
                </p>
                <a href="#" class="btn btn-success">Discover More</a>
            </div>

            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6"
                     class="img-fluid rounded shadow">
            </div>

        </div>
    </div>
</section>

{{-- Contact CTA --}}
<section class="py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Get in Touch</h2>
        <p class="mb-4">
            Join us toward better health, sustainable living and happy life.
        </p>
        <a href="#" class="btn btn-success btn-lg">Contact Us</a>
    </div>
</section>

@endsection
