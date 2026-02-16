@extends('layouts.app')
@section('title','Add FAQ')

@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-6"> 
    <h4>Add FAQ</h4>
 {{-- Flash Error Message --}} 
@if($errors->any()) 
<div class="alert alert-danger"> 
    <ul class="mb-0"> @foreach($errors->all() as $error) 
        <li>{{ $error }}</li>
         @endforeach
         </ul>
         </div>
 @endif
    <form method="POST" action="{{ route('admin.faq.store') }}">
        @csrf
        @include('admin.faq.form')
    </form>
</div>
<div></div>
@endsection
