<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    public function index()
    {
        $cart = getCart()->load('items.product');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = getCart();

        CartItem::updateOrCreate(
            ['cart_id'=>$cart->id,'product_id'=>$product->id],
            [
                'quantity'=>DB::raw('quantity + 1'),
                'price'=>$product->price
            ]
        );

        return back()->with('success','Added to cart');
    }

    public function update(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);
        $item->update(['quantity'=>$request->quantity]);

        return back();
    }

    public function remove(Request $request)
    {
        CartItem::findOrFail($request->item_id)->delete();
        return back();
    }
}

