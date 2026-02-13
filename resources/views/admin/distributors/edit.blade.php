@extends('layouts.app')
@section('title','Edit Distributor')

@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-6">
    <h4>Edit Distributor</h4>
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
    <form method="POST" action="{{ route('admin.distributors.update',$distributor) }}">
        @csrf
        @method('PUT')

        @include('admin.distributors.form', ['distributor' => $distributor])
    </form>
</div>
</div>
</div>
@endsection
