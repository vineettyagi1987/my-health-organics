@extends('layouts.app')
@section('title','Career Management')
@section('content')
<div class="container py-4">

    <h3 class="mb-4">Manage Career Page</h3>
    @if($errors->any()) 
<div class="alert alert-danger"> 
    <ul class="mb-0"> @foreach($errors->all() as $error) 
        <li>{{ $error }}</li>
         @endforeach
         </ul>
         </div>
 @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.career.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Career Objectives</label>
            <textarea name="objectives" rows="5" class="form-control">{{ $career->objectives ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Sapath Patra</label>
            <textarea name="sapath_patra" rows="5" class="form-control">{{ $career->sapath_patra ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $career->address ?? '' }}">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="{{ $career->city ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control" value="{{ $career->state ?? '' }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $career->phone ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $career->email ?? '' }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Save Changes
        </button>

    </form>
</div>
@endsection