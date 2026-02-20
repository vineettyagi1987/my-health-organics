@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Page Heading -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">Career at The Health Organics</h1>
        <p class="text-muted">Build your future with us and be part of our wellness mission.</p>
    </div>

    <!-- Career Objectives -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">Career Objectives</h3>
        <div class="bg-light p-4 rounded shadow-sm">
           {!! nl2br($career->objectives ?? '') !!}
        </div>
    </div>

    <!-- Sapath Patra Section -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">Sapath Patra (Oath Letter)</h3>
        <div class="border rounded p-4 shadow-sm">
            <p class="text-muted">
               {!! nl2br($career->sapath_patra ?? '') !!}
            </p>
        </div>
    </div>

    <!-- Contact + Address Section -->
    <div class="row">

        <!-- Contact Form -->
        <div class="col-md-6 mb-4">
           <section class="text-center bg-light rounded shadow p-5">
        <h2 class="fw-bold mb-3">Get in Touch</h2>
        <p class="text-muted mb-4">
            Join us on this journey toward better health, sustainable living, and a happier, more fulfilled you.

            With The Health Organics, let’s embrace nature, restore balance, and create a healthier future together.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-success btn-lg">Contact Us</a>
    </section>
        </div>

        <!-- Company Address -->
        <div class="col-md-6 mb-4">
            <h3 class="fw-bold mb-3">Our Address</h3>

            <div class="bg-light p-4 rounded shadow-sm">
                <p class="mb-2"><strong>The Health Organics Pvt. Ltd.</strong></p>
                
                <p class="mb-2"> {{ $career->address ?? '' }}</p>
                <p class="mb-2"> {{ $career->city ?? '' }},  {{ $career->state ?? '' }}</p>
                <!-- <p class="mb-2">India - 247001</p> -->
                <p class="mb-2">Phone: {{ $career->phone ?? '' }}</p>
                <p class="mb-0">Email: {{ $career->email ?? '' }}</p>
            </div>
        </div>

    </div>

</div>
@endsection