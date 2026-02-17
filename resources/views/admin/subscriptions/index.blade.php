@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>All Subscriptions</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                 <th>#</th>
        <th>User</th>
        <th>Email</th>
        <th>Status</th>
        <th>Start</th>
        <th>End</th>
        <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($subscriptions as $sub)
           <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $sub->user->name ?? '-' }}</td>
    <td>{{ $sub->user->email ?? '-' }}</td>
    <td>{{ ucfirst($sub->status) }}</td>
    <td>{{ $sub->start_date ?? '-' }}</td>
    <td>{{ $sub->end_date ?? '-' }}</td>
    <td>
        <a href="{{ route('admin.subscriptions.show', $sub->id) }}"
           class="btn btn-sm btn-primary">View</a>
    </td>
</tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No subscriptions found</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $subscriptions->links() }}
</div>
@endsection
