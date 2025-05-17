<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $orders = Order::paginate();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order with customer details.
     */
    public function show(Order $order)
    {
        $order = Order::with('products')->findOrFail($order->id);
        return view('admin.orders.show', compact('order'));
    }

}
