<div class="bg-light border-end p-3" style="width:300px;">
    <h5 class="text-success fw-bold mb-4">Website Panel</h5>

    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

        <li class="nav-item">
            <a class="nav-link {{ Route::is('employee.dashboard') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('employee.dashboard') }}">
               <i class="bi bi-house me-2"></i> Dashboard
            </a>
        </li>

    </ul>
</div>
