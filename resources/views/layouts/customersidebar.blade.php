<div class="bg-light border-end p-3" style="width:300px;">
    <h5 class="text-success fw-bold mb-4">Website Panel</h5>

    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

        <li class="nav-item">
            <a class="nav-link {{ Route::is('home') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('home') }}">
               <i class="bi bi-house me-2"></i> Home & About Us
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('products.list') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('products.list') }}">
               <i class="bi bi-box-seam me-2"></i> Products / Projects
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('events') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('events') }}">
               <i class="bi bi-globe me-2"></i> Renewable Energy & Plastic Free Events
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('guidance') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('guidance') }}">
               <i class="bi bi-lightbulb me-2"></i> Guidance & Counselling
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('yoga') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('yoga') }}">
               <i class="bi bi-heart-pulse me-2"></i> Yoga & Ayurved
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('benefits') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('benefits') }}">
               <i class="bi bi-gift me-2"></i> Member Benefits
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('gallery') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('gallery') }}">
               <i class="bi bi-images me-2"></i> Media Gallery
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('career') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('career') }}">
               <i class="bi bi-briefcase me-2"></i> Career
            </a>
        </li>
        

         <li class="nav-item">
            <a class="nav-link {{ Route::is('contact') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('contact') }}">
               <i class="bi bi-envelope me-2"></i> Contact Us
            </a>
        </li>
    </ul>
</div>
