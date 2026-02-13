@extends('layouts.app')
@section('title','Recent Registrations')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>Recent Registrations</h4>
       
    </div>
     <p> Latest users who joined the platform.</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined On</th>
               
            </tr>
        </thead>

        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <span class="badge bg-info text-dark">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-{{ $user->status ? 'success' : 'danger' }}">
                        {{ $user->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>

              
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">
                    No recent registrations found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

   
        {{ $users->links() }}
   

</div>
@endsection
