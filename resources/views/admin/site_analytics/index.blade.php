@extends('layouts.app')
@section('title','Site Analytics Dashboard')

@section('content')
<div class="container">

    <h4 class="mb-4">Site Analytics Dashboard</h4>
   
    <div class="row g-4">

        <!-- Website Traffic -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6>Website Traffic</h6>
                     <p>Visitors and Page Views over the last 7 days.</p>
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales Performance -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6>Total Sales Trend</h6>
                    <p>Monthly sales revenue (₹).</p>
                    <canvas id="monthlySalesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Customer Engagement -->
       <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6>Customer Engagement</h6>
                    <p class="text-muted">Weekly conversion and bounce rates (%)</p>
                    <canvas id="engagementChart"></canvas>
                </div>
            </div>
        </div>

        <!-- MLM Network Growth -->
         <div class="col-md-6">
         <div class="card">
        <div class="card-body">
            <h6>MLM Network Growth</h6>
            <p class="text-muted">
                Monthly new distributors and total network size.
            </p>

            <canvas id="mlmChart" height="90"></canvas>
        </div>
    </div></div>

    <div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <h6>Top Selling Products</h6>
            <p class="text-muted">Units sold for top 5 products this month.</p>

            <canvas id="topProductsChart" height="90"></canvas>
        </div>
    </div>
</div>


    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($trafficLabels);

// Traffic
new Chart(document.getElementById('trafficChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Visitors',
                data: @json($visitorData),
                tension: 0.4
            },
            {
                label: 'Page Views',
                data: @json($pageViewData),
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

// Sales
new Chart(document.getElementById('monthlySalesChart'), {
    type: 'line',
    data: {
        labels: @json($monthlyLabels),
        datasets: [{
            label: 'Revenue ₹',
            data: @json($monthlySalesData),
            tension: 0.4,
            fill: false
        }]
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

// Registrations
new Chart(document.getElementById('engagementChart'), {
    type: 'line',
    data: {
        labels: @json($engagementLabels),
        datasets: [
            {
                label: 'Conversion Rate %',
                data: @json($conversionRates),
                tension: 0.4
            },
            {
                label: 'Bounce Rate %',
                data: @json($bounceRates),
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
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => value + '%'
                }
            }
        }
    }
});

// Network Growth
new Chart(document.getElementById('mlmChart'), {
    type: 'line',
    data: {
        labels: @json($mlmLabels),
        datasets: [
            {
                label: 'New Distributors',
                data: @json($monthlyNewDistributors),
                tension: 0.4
            },
            {
                label: 'Total Network Size',
                data: @json($cumulativeTotal),
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
new Chart(document.getElementById('topProductsChart'), {
    type: 'bar',
    data: {
        labels: @json($topProductLabels),
        datasets: [{
            label: 'Units Sold',
            data: @json($topProductUnits),
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',   // horizontal bars (better for names)
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { beginAtZero: true }
        }
    }
});
</script>
@endsection

