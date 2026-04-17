@extends('layouts.app')

@section('content')

<div class="container">

<h3>My Referral Tree</h3>

{{-- Earnings --}}
@if(!empty($commissionSummary))
<h4>Total Earnings ₹ {{ $commissionSummary['total'] }}</h4>

<table class="table table-bordered">

<tr>
<th>Level</th>
<th>Total Users</th>
<th>Eligible Users</th>
<th>Commission</th>
<th>Bonus</th>
</tr>

@foreach($commissionSummary['levels'] as $level=>$data)

<tr>

<td>{{ $level }}</td>
<td>{{ $data['users'] }}</td>
<td>{{ $data['eligible'] }}</td>
<td>{{ $data['commission'] }}</td>
<td>{{ $data['bonus'] ?? 0 }}</td>

</tr>

@endforeach

</table>
@endif

<div class="tree-wrapper">
    <div class="tree">
        <ul>
            <li>
                <span class="root">{{ auth()->user()->name }}</span>

                @if(!empty($tree))
                    @include('user.referral.tree-node', ['nodes' => $tree])
                @endif

            </li>
        </ul>
    </div>
</div>
<style>

/* Wrapper for scroll */
.tree-wrapper {
    width: 100%;
    height: 70vh; /* control height */
    overflow: auto;
    border: 1px solid #eee;
    background: #fafafa;
}

/* Tree container */
.tree {
    display: inline-block;
    min-width: 100%;
    text-align: center;
    padding: 20px;
}

/* UL styling */
.tree ul {
    display: flex;
    justify-content: center;
    position: relative;
    padding-top: 20px;
    min-width: max-content; /* IMPORTANT for horizontal scroll */
}

/* LI styling */
.tree li {
    list-style: none;
    text-align: center;
    position: relative;
    padding: 20px 15px;
    flex-shrink: 0; /* prevent shrinking */
}

/* Vertical line */
.tree li::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    border-left: 1px solid #ccc;
    height: 20px;
}

/* Horizontal connector */
.tree ul::before {
    content: '';
    position: absolute;
    top: 0;
    left: 5%;
    right: 5%;
    border-top: 1px solid #ccc;
}

/* Node box */
.tree li span {
    display: inline-block;
    padding: 10px 15px;
    border-radius: 8px;
    background: #0d6efd;
    color: #fff;
    font-weight: 500;
    min-width: 120px;
    white-space: nowrap;
}

/* Root */
.tree .root {
    background: #198754;
}

/* Smooth scroll */
.tree-wrapper {
    scroll-behavior: smooth;
}

/* Optional scrollbar styling */
.tree-wrapper::-webkit-scrollbar {
    height: 8px;
    width: 8px;
}
.tree-wrapper::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

</style>
@endsection