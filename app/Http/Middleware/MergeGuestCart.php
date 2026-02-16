<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class MergeGuestCart
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {

            $guestSessionId = session()->get('guest_session_id');

            if ($guestSessionId) {

                $guestCart = Cart::where('session_id', $guestSessionId)->first();

                if ($guestCart) {

                    $userCart = Cart::firstOrCreate([
                        'user_id' => auth()->id(),
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
        }

        return $next($request);
    }
}
