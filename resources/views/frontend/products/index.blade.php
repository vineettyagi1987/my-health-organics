@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2 class="text-center mb-4">All Products</h2>

    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">

                <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top">

                <div class="card-body d-flex flex-column">
                    <h5>{{ $product->name }}</h5>
                    <p class="text-muted flex-grow-1">{{ $product->description }}</p>
                    <p class="fw-bold text-success">₹{{ $product->price }}</p>

                    <form method="POST" action="{{ route('cart.add',$product->id) }}">
                        @csrf
                        <button class="btn btn-success w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
