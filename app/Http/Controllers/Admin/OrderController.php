<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /** List all orders */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // optional filters
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->user) {
            $query->where('user_id', $request->user);
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /** Show single order */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'refunds'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }
}
