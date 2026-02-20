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

    // Status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // User filter
    if ($request->filled('user')) {
        $query->where('user_id', $request->user);
    }

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%")
              ->orWhereHas('user', function ($u) use ($search) {
                  $u->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
              });
        });
    }

    $orders = $query->paginate(20)->withQueryString();

    return view('admin.orders.index', compact('orders'));
}


    /** Show single order */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'refunds'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }
}
