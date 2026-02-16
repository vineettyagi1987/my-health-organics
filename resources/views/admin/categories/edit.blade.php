@extends('layouts.app')
@section('title','Edit Category')


@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-6">
<h4>Edit Category</h4>
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

<form method="POST" action="{{ route('admin.categories.update',$category) }}">
@csrf
@method('PUT')


@include('admin.categories.form', ['category' => $category])
</form>
</div>
</div>
</div>
@endsection