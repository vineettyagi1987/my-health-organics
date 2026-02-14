<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BenefitController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DistributorController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\PageController;
// Route::get('/', [HomeController::class, 'index'])->name('home');
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
       
             Route::get('/network', [AdminDashboardController::class, 'network'])
            ->name('network');
            Route::get('site-analytics', [AdminDashboardController::class, 'siteAnalytics'])
                ->name('site.analytics');
               Route::get('/settings', [AdminDashboardController::class, 'settings'])
            ->name('settings');
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('benefits', BenefitController::class);
        Route::resource('terms', TermController::class);
        Route::resource('gallery', GalleryController::class);
        Route::resource('faq', FaqController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('distributors', DistributorController::class);

    });

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::prefix('customer')
    ->middleware(['auth', 'role:customer'])
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/order', [OrderController::class, 'store'])
            ->name('order.store');
    });

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/products-projects', [PageController::class, 'products'])->name('products');
Route::get('/events', [PageController::class, 'events'])->name('events');
Route::get('/guidance-counselling', [PageController::class, 'guidance'])->name('guidance');
Route::get('/yoga-ayurved', [PageController::class, 'yoga'])->name('yoga');
Route::get('/member-benefits', [PageController::class, 'benefits'])->name('benefits');
Route::get('/media-gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/career', [PageController::class, 'career'])->name('career');

    
