@extends('layouts.app')
@section('title','Edit Terms')

@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-6"> 
    <h4>Edit Terms & Conditions</h4>
    @if($errors->any()) 
<div class="alert alert-danger"> 
    <ul class="mb-0"> @foreach($errors->all() as $error) 
        <li>{{ $error }}</li>
         @endforeach
         </ul>
         </div>
 @endif
    <form method="POST" action="{{ route('admin.terms.update', $term) }}">
        @csrf
        @method('PUT')

        @include('admin.terms.form', ['term' => $term])
    </form>
</div>
@endsection
