@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Products</h2>
    <form method="GET" action="{{ route('products.list') }}">
    <div class="row mb-4">
        <div class="col-md-4">
            <select name="category" class="form-control" onchange="this.form.submit()">
                <option value="">-- All Categories --</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>
    </div>
</form>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" height="200">
                @endif

                <div class="card-body d-flex flex-column">
    <h5>{{ $product->name }}</h5>
    <p class="text-muted flex-grow-1">
        {{ Str::limit($product->description, 60) }}
    </p>
    <p class="fw-bold">₹{{ $product->price }}</p>

    <div class="mt-auto d-flex gap-2">
        <!-- Add to Cart Button -->
       <form action="{{ url('/cart/add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit" class="btn btn-primary w-100">
            Add to Cart
        </button>
    </form>
        <!-- View Details Button -->
        <a href="{{ url('/product/' . $product->slug) }}" 
           class="btn btn-outline-primary w-50">
            View
        </a>

        
    </div>
</div>

            </div>
        </div>
        @endforeach
    </div>

   {{ $products->withQueryString()->links() }}
</div>
@endsection
