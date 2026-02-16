<div class="bg-light border-end p-3" style="width:300px;">
    <h5 class="text-success fw-bold mb-4">Admin Panel</h5>

    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.dashboard') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.dashboard') }}">
               <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.employees.index') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.employees.index') }}">
               <i class="bi bi-people me-2"></i> Employee Management
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.distributors.index') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.distributors.index') }}">
               <i class="bi bi-people me-2"></i> Distributor Management
            </a>
        </li>
          <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.categories.index') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.categories.index') }}">
               <i class="bi bi-diagram-3 me-2"></i> Product Categories
            </a>
        </li>
          <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.products.index') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.products.index') }}">
               <i class="bi bi-diagram-3 me-2"></i> Product Management
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.network') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.network') }}">
               <i class="bi bi-share me-2"></i> Network Activity
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.site.analytics') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.site.analytics') }}">
               <i class="bi bi-graph-up me-2"></i> Site Analytics
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.settings') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.settings') }}">
               <i class="bi bi-gear me-2"></i> System Settings
            </a>
        </li>
         {{-- Member Benefits --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.benefits*') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.benefits.index') }}">
               <i class="bi bi-gift me-2"></i> Member Benefits
            </a>
        </li>

        {{-- Terms & Conditions --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.terms*') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.terms.index') }}">
               <i class="bi bi-file-text me-2"></i> Terms & Conditions
            </a>
        </li>

        {{-- Media Gallery --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.gallery*') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.gallery.index') }}">
               <i class="bi bi-images me-2"></i> Media Gallery
            </a>
        </li>

        {{-- FAQ --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.faq*') ? 'active fw-bold text-success' : '' }}"
               href="{{ route('admin.faq.index') }}">
               <i class="bi bi-question-circle me-2"></i> FAQ
            </a>
        </li>


    </ul>
</div>
