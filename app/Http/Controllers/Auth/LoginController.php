<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    protected function authenticated($request, $user)
{
    $guestSessionId = session()->get('guest_session_id');

    if (!$guestSessionId) {
        return;
    }

    $guestCart = Cart::where('session_id', $guestSessionId)->first();

    if (!$guestCart) {
        return;
    }

    $userCart = Cart::firstOrCreate([
        'user_id' => $user->id,
    ]);

    DB::transaction(function () use ($guestCart, $userCart) {

        foreach ($guestCart->items as $item) {

            CartItem::updateOrCreate(
                [
                    'cart_id' => $userCart->id,
                    'product_id' => $item->product_id,
                ],
                [
                    'quantity' => DB::raw("quantity + {$item->quantity}"),
                    'price' => $item->price,
                ]
            );
        }

        $guestCart->delete();
    });

    session()->forget('guest_session_id');
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
     if ($user->role === 'employee') {
        return redirect('/');
    }
    if ($user->role === 'distributor') {
         return redirect('/');
    }

    if ($user->role === 'customer') {
        return redirect('/');
    }

    // fallback
    return redirect('/');
}

}
