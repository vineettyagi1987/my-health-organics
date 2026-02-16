<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class MergeCartAfterLogin
{
    public function handle(Login $event): void
    {
        $sessionId = session()->getId();

        $guestCart = Cart::where('session_id', $sessionId)->first();

        if (!$guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate([
            'user_id' => $event->user->id,
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
    }
}
