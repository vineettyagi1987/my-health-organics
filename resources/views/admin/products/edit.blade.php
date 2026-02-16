@extends('layouts.app')
@section('title','Edit Product')


@section('content')
<div class="container">
<div class="row justify-content-center"> <div class="col-md-6">
<h4>Edit Product</h4>
{{-- Flash Error Message --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

<form method="POST" action="{{ route('admin.products.update',$product) }}" enctype="multipart/form-data">
@csrf
@method('PUT')


@include('admin.products.form', ['product' => $product])
</form>
</div>
</div> </div>
@endsection