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
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FrontEventController;
use App\Http\Controllers\DashboardController as UserDashboardController;


use App\Http\Controllers\ProductController as FrontendProductController;

// Route::get('/', [HomeController::class, 'index'])->name('home');
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Auth::routes();
Route::get('/login', function () {
    session(['guest_session_id' => session()->getId()]);
    return app(\App\Http\Controllers\Auth\LoginController::class)->showLoginForm();
})->name('login');
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
        /** Orders */
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');

        /** Subscriptions */
        Route::get('/subscriptions', [AdminSubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/{id}', [AdminSubscriptionController::class, 'show'])->name('subscriptions.show');
        Route::post('/subscriptions/{id}/cancel', [AdminSubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
        Route::get('/career', [CareerController::class, 'index'])->name('career.index');
         Route::post('/career', [CareerController::class, 'store'])->name('career.store');
         Route::resource('events', EventController::class);
         Route::resource('faculties', FacultyController::class);
         Route::resource('event_categories',EventCategoryController::class);

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

        // Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
        //     ->name('dashboard');

        // Route::post('/order', [OrderController::class, 'store'])
        //     ->name('order.store');
       
    });

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/products-projects', [PageController::class, 'products'])->name('products');
Route::get('/events', [PageController::class, 'events'])->name('events');

Route::get('/yoga-ayurved', [PageController::class, 'yoga'])->name('yoga');
Route::get('/member-benefits', [PageController::class, 'benefits'])->name('benefits');
Route::get('/media-gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/career', [PageController::class, 'career'])->name('career');
Route::post('/career/contact', [PageController::class, 'store'])->name('career.contact');

//


Route::get('/products', [FrontendProductController::class, 'index'])->name('products.list');
Route::get('/product/{slug}', [FrontendProductController::class, 'show']);

Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/update', [CartController::class, 'update']);
Route::post('/cart/remove', [CartController::class, 'remove']);

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/refund', [OrderController::class, 'refund'])->name('orders.refund');

    //  Route::get('/subscriptions', [SubscriptionController::class, 'index'])
    //     ->name('subscriptions.index');

   
    // User Registration subscriptions

     Route::get('/membership-offer', [SubscriptionController::class, 'offer'])
        ->name('membership.offer');

    Route::post('/membership-subscribe', [SubscriptionController::class, 'subscribe'])
        ->name('membership.subscribe');

    Route::post('/membership-skip', [SubscriptionController::class, 'skip'])
        ->name('membership.skip');

    //  profile subscriptions

    Route::get('/my-subscription', [SubscriptionController::class, 'profile'])
        ->name('subscription.profile');

    Route::post('/my-subscription/create', [SubscriptionController::class, 'create'])
        ->name('subscription.create');

    Route::post('/my-subscription/cancel/{id}', [SubscriptionController::class, 'cancel'])
        ->name('subscription.cancel');


     Route::get('/profile', [UserDashboardController::class, 'profile'])
            ->name('profile');

        Route::post('/profile/update', [UserDashboardController::class, 'updateProfile'])
            ->name('profile.update');
        
});

Route::post('/razorpay/payment', [RazorpayController::class, 'payment']);
Route::post('/razorpay/webhook', [RazorpayController::class, 'webhook']);

//Route::post('/subscribe', [SubscriptionController::class, 'store']);
// Route::get('/guidance-counselling', [PageController::class, 'guidance'])->name('guidance');

Route::get('/eventsList',[FrontEventController::class,'index'])->name('events.index');
Route::post('/events/book/{id}',[FrontEventController::class,'book'])->middleware('auth');
Route::get('/payment-success',[FrontEventController::class,'paymentSuccess'])->name('payment.success');
Route::get('/my-bookings',[FrontEventController::class,'myBookings'])
    ->middleware('auth')
    ->name('my.bookings');





