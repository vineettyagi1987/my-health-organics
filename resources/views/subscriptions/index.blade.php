@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>My Subscriptions</h2>

    @if($subscriptions->count())

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th width="120"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $sub)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ optional($sub->product)->name ?? 'Subscription Plan' }}
                    </td>

                    <td>
                        <span class="badge
                            @if($sub->status == 'active') bg-success
                            @elseif($sub->status == 'cancelled') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>

                    <td>{{ optional($sub->start_date)->format('d M Y') }}</td>
                    <td>{{ optional($sub->end_date)->format('d M Y') ?? '-' }}</td>

                    <td>
                        @if($sub->status === 'active')
                        <form method="POST" action="{{ route('subscriptions.cancel', $sub->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Cancel this subscription?')">
                                Cancel
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @else
        {{-- Empty state --}}
        <div class="text-center py-5">
            <h4>No active subscriptions</h4>
            <p class="text-muted">You don’t have any subscription plans yet.</p>

            <a href="{{ route('products.list') }}" class="btn btn-success">
                Browse Plans
            </a>
        </div>
    @endif
</div>
@endsection
