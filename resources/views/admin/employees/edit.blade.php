@extends('layouts.app')
@section('title','Edit Employee')


@section('content')
<div class="container">
     <div class="row justify-content-center">
        <div class="col-md-6">
<h4>Edit Employee</h4>

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
<form method="POST" action="{{ route('admin.employees.update',$employee) }}">
@csrf
@method('PUT')


@include('admin.employees.form', ['employee' => $employee])
</form>
</div>
</div> </div>
@endsection