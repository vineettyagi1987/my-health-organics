@extends('layouts.app')
@section('title','Products')


@section('content')
<div class="container">


<div class="d-flex justify-content-between mb-3">
<h4>Products</h4>
<a href="{{ route('admin.products.create') }}" class="btn btn-success">Add Product</a>
</div>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row mb-3">
    <div class="col-md-6">
        <form method="GET" action="{{ route('admin.products.index') }}">
            <div class="d-flex gap-2">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control"
                    placeholder="Search by name, category, price..."
                    value="{{ request('search') }}"
                >

                <button type="submit" class="btn btn-primary">
                    Search
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered">
<tr>
<th>Image</th>
<th>Name</th>
<th>Category</th>
<th>Price</th>
<th>Stock</th>
<th>Status</th>
<th width="150">Action</th>
</tr>


@foreach($products as $product)
<tr>
<td>
@if($product->image)
<img src="{{ asset('storage/'.$product->image) }}" width="60">
@endif
</td>
<td>{{ $product->name }}</td>
<td>{{ $product->category->name ?? '' }}</td>
<td>₹{{ $product->price }}</td>
<td>
    @if($product->stock > 0)
        <span class="badge bg-success">{{ $product->stock }}</span>
    @else
        <span class="badge bg-danger">Out of stock</span>
    @endif
</td>

<td>
<span class="badge bg-{{ $product->status ? 'success' : 'danger' }}">
{{ $product->status ? 'Active' : 'Inactive' }}
</span>
</td>
<td>
<a href="{{ route('admin.products.edit',$product) }}" class="btn btn-sm btn-primary">Edit</a>


<form method="POST" action="{{ route('admin.products.destroy',$product) }}" class="d-inline">
@csrf @method('DELETE')
<button onclick="return confirm('Delete product?')" class="btn btn-sm btn-danger">Delete</button>
</form>
</td>
</tr>
@endforeach
</table>


{{ $products->links() }}
</div>
@endsection