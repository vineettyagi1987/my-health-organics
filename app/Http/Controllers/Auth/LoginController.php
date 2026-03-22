<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * बदलें default email field → login
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Validate login request
     */
    protected function validateLogin(Request $request)
    {
        $login = $request->input('login');

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            // Email validation
            $request->validate([
                'login' => 'required|email',
                'password' => 'required|string',
            ]);
        } else {
            // Phone validation (only digits allowed)
            $request->validate([
                'login' => ['required', 'regex:/^[0-9+\s]+$/'],
                'password' => 'required|string',
            ], [
                'login.regex' => 'Please enter a valid mobile number (numbers only)',
            ]);
        }
    }

    /**
     * Email / Phone detect + normalize
     */
    protected function credentials(Request $request)
    {
        $login = $request->input('login');

        // अगर email है
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return [
                'email' => $login,
                'password' => $request->input('password'),
            ];
        }

        // 📱 Phone normalize
        $login = preg_replace('/\D/', '', $login); // remove non-digits
       // $login = substr($login, -10); // last 10 digits (India)

        return [
            'phone' => $login,
            'password' => $request->input('password'),
        ];
    }

    /**
     * Login ke baad cart merge + role redirect
     */
    protected function authenticated($request, $user)
    {
        $guestSessionId = session()->get('guest_session_id');

        if ($guestSessionId) {
            $guestCart = Cart::where('session_id', $guestSessionId)->first();

            if ($guestCart) {
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
            }
        }

        // 🎯 Role-based redirect
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'employee') {
            return redirect()->route('employee.dashboard');
        }

        if ($user->role === 'distributor') {
            return redirect()->route('distributor.dashboard');
        }

        if ($user->role === 'customer') {
            return redirect('/');
        }

        return redirect('/');
    }
}