@auth

    @if(auth()->user()->role === 'admin')
        @include('layouts.adminheader')
        
        <div class="d-flex">
        {{-- Sidebar --}}
        @auth
            @include('layouts.adminsidebar')
        @endauth
       
    @elseif(auth()->user()->role === 'customer')
        @include('layouts.customerheader')
         <div class="d-flex">

        {{-- Sidebar --}}
        @auth
            @include('layouts.customersidebar')
        @endauth
     @elseif(auth()->user()->role === 'distributor')
        @include('layouts.distributorheader')
        <div class="d-flex">
         {{-- Sidebar --}}
        @auth
            @include('layouts.distributorsidebar')
        @endauth
     @elseif(auth()->user()->role === 'employee')
        @include('layouts.employeeheader')
        <div class="d-flex">
         {{-- Sidebar --}}
        @auth
            @include('layouts.employeesidebar')
        @endauth
    @else
        @include('layouts.header') {{-- default --}}
         {{-- Sidebar --}}
        @auth
            @include('layouts.sidebar')
        @endauth
    @endif
@else
    @include('layouts.header') {{-- guest header --}}
     <div class="d-flex">
     @include('layouts.sidebar')
     
@endauth

<main style="padding:20px;width:100%">
    @yield('content')
</main>
 </div>
@include('layouts.footer')
