@extends('layouts.app')


@section('content')
<div class="container">
<h1>Admin Dashboard</h1>
<p>Welcome, {{ auth()->user()->name }}</p>
</div>
<div class="row g-4">
    <div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Website Reach Overview</h5>
            <p class="text-muted">
                Unique visitors over the last 7 days compared to the previous week.
            </p>

            <canvas id="reachChart" height="100"></canvas>
        </div>
    </div>
    </div>
     <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Sales Overview</h5>
                <p class="text-muted">
                    Total sales revenue (₹) this week compared to the previous week.
                </p>

                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Registration Growth</h5>
                <p class="text-muted">
                    New user registrations this week compared to the previous week.
                </p>

                <canvas id="registrationChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('reachChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [
            {
                label: 'Last 7 Days',
                data: @json($lastWeekData),
                tension: 0.4
            },
            {
                label: 'Previous 7 Days',
                data: @json($prevWeekData),
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
<script>
const salesCtx = document.getElementById('salesChart');

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: @json($salesLabels),
        datasets: [
            {
                label: 'This Week (₹)',
                data: @json($thisWeekSalesData),
                tension: 0.4,
                fill: false
            },
            {
                label: 'Previous Week (₹)',
                data: @json($lastWeekSalesData),
                tension: 0.4,
                fill: false
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
const regCtx = document.getElementById('registrationChart');

new Chart(regCtx, {
    type: 'line',
    data: {
        labels: @json($registrationLabels),
        datasets: [
            {
                label: 'This Week',
                data: @json($thisWeekData),
                tension: 0.4,
                fill: false
            },
            {
                label: 'Previous Week',
                data: @json($lastWeekData),
                tension: 0.4,
                fill: false
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        }
    }
});
</script>


@endsection