@extends('layouts.app')

@section('content')

<div class="container">

<h3>Coming Soon Items</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<a href="{{ route('admin.comingsoon.create') }}" class="btn btn-primary mb-3">
Add New
</a>

<table class="table table-bordered">

<thead>
<tr>
<th>Title</th>
<th>Type</th>
<th>Launch Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($items as $item)

<tr>

<td>{{ $item->title }}</td>

<td>{{ ucfirst($item->type) }}</td>

<td>{{ $item->launch_date }}</td>

<td>{{ $item->status }}</td>

<td>

<a href="{{ route('admin.comingsoon.edit',$item->id) }}" class="btn btn-sm btn-warning">
Edit
</a>

<form action="{{ route('admin.comingsoon.destroy',$item->id) }}"
method="POST"
style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger">Delete</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection