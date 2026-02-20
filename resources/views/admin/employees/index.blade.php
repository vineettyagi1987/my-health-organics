@extends('layouts.app')
@section('title','Employees')


@section('content')
<div class="container">



<div class="d-flex justify-content-between mb-3">
<h4>Employees</h4>
<a href="{{ route('admin.employees.create') }}" class="btn btn-success">Add Employee</a>
</div>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="row mb-3">
    <div class="col-md-6">
        <form method="GET" action="{{ route('admin.employees.index') }}">
            <div class="d-flex gap-2">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Search by name, email, phone, emp ID..."
                    value="{{ request('search') }}"
                >

                <button type="submit" class="btn btn-primary">
                    Search
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>


<table class="table table-bordered">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Department</th>
<th>Company Role/Title</th>
<th>Employee ID</th>
<th>Status</th>
<th width="150">Action</th>
</tr>
</thead>
<tbody>
@forelse($employees as $employee)
<tr>
    <td>{{ $employee->name }}</td>
    <td>{{ $employee->email }}</td>
    <td>{{ $employee->phone }}</td>
    <td>{{ $employee->department }}</td>
    <td>{{ $employee->company_title }}</td>
    <td>{{ $employee->emp_id }}</td>
    <td>
        <span class="badge bg-{{ $employee->status ? 'success' : 'danger' }}">
            {{ $employee->status ? 'Active' : 'Inactive' }}
        </span>
    </td>
    <td>
        <a href="{{ route('admin.employees.edit',$employee) }}" class="btn btn-sm btn-primary">Edit</a>

        <form action="{{ route('admin.employees.destroy',$employee) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button onclick="return confirm('Delete employee?')" class="btn btn-sm btn-danger">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted">No employees found.</td>
</tr>
@endforelse
</tbody>

</table>


{{ $employees->links() }}
</div>
@endsection