@auth
    @if(auth()->user()->role === 'admin')
        @include('layouts.adminheader')
        <div class="d-flex">

        {{-- Sidebar --}}
        @auth
            @include('layouts.sidebar')
        @endauth
       
    @elseif(auth()->user()->role === 'customer')
        @include('layouts.header')
    @else
        @include('layouts.header') {{-- default --}}
    @endif
@else
    @include('layouts.header') {{-- guest header --}}
@endauth

<main style="padding:20px;width:100%">
    @yield('content')
</main>
 </div>
@include('layouts.footer')
