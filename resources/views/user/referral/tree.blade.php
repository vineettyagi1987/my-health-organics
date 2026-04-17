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
<div id="tree-container" style="width:100%; height:600px;"></div>

</div>
<link rel="stylesheet" href="https://balkan.app/css/orgchart.css">
<script src="https://balkan.app/js/orgchart.js"></script>
<script>

let chart = new OrgChart(document.getElementById("tree-container"), {
    
    template: "ula", // nice UI

    enableSearch: true,
    subtreeSeparation: 40,
    mouseScrool: OrgChart.action.zoom, // zoom with scroll

    nodeBinding: {
        field_0: "name",
        field_1: "my_referral_code"
    },

    nodes: @json($chartData),

    collapse: {
        level: 2 // auto collapse after level 2
    },

    toolbar: {
        zoom: true,
        fit: true,
        expandAll: true
    },
      scaleInitial: 0.8,
    tags: {
    "me": {
        template: "ula"
    }
}

});

</script>

<style>
/* Increase horizontal spacing */
#tree-container .orgchart {
    margin: 0 auto;
}

/* Node box */
#tree-container .node {
    width: 160px !important;   /* increase width */
   padding: 8px !important;
    border-radius: 8px;
      text-align: center !important;   /* center all text */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

/* Text */
#tree-container .node .field_0 {
    font-size: 12px !important;
    font-weight: 600;
     /* text-align: center !important; */
    width: 100%;
}

#tree-container .node .field_1 {
    font-size: 11px !important;
    color: #666;
      /* text-align: center !important; */
    width: 100%;
}
#tree-container {
    width: 100%;
    height: 80vh;   /* dynamic height */
    border: 1px solid #ddd;
    overflow: hidden;
}
#tree-container .node > div {
    text-align: center !important;
}
/* Force center text inside SVG */
#tree-container svg text {
    text-anchor: middle !important;   /* horizontal center */
    dominant-baseline: middle !important; /* vertical center */
}

/* Fix for both fields */
#tree-container .field_0,
#tree-container .field_1 {
    text-anchor: middle !important;
}
</style>
@endsection