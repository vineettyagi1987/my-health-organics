@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-5">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid">
            @endif
        </div>

        <div class="col-md-7">
            <h2>{{ $product->name }}</h2>
            <h4 class="text-success">₹{{ $product->price }}</h4>

            <p>{{ $product->description }}</p>

            <form method="POST" action="/cart/add">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
@endsection
