@extends('layouts.app')
@section('title','Add Distributor')

@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-6">
    <h4>Add Distributor</h4>
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
    <form method="POST" action="{{ route('admin.distributors.store') }}">
        @csrf
        @include('admin.distributors.form')
    </form>
</div>
</div>
</div>
@endsection
