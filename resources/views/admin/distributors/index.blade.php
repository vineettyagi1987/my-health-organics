@extends('layouts.app')
@section('title','Distributors')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>Distributors</h4>
        <a href="{{ route('admin.distributors.create') }}" class="btn btn-success">Add Distributor</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Region / Area</th>
            <th>Commission %</th>
            <th>Status</th>
            <th width="150">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($distributors as $d)
        <tr>
            <td>{{ $d->name }}</td>
            <td>{{ $d->email }}</td>
            <td>{{ $d->phone }}</td>
            <td>{{ $d->region_area }}</td>
<td>{{ $d->commission_rate }}%</td>

            <td>
                <span class="badge bg-{{ $d->status ? 'success':'danger' }}">
                    {{ $d->status ? 'Active':'Inactive' }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.distributors.edit',$d) }}" class="btn btn-sm btn-primary">Edit</a>

                <form method="POST" action="{{ route('admin.distributors.destroy',$d) }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete distributor?')" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted">No distributors found.</td>
        </tr>
        @endforelse
    </tbody>
</table>


    {{ $distributors->links() }}
</div>
@endsection
