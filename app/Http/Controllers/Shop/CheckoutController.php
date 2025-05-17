<?php
namespace App\Http\Controllers\Shop;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Validator;
use App\Rules\OrderValidation;


class CheckoutController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $cart = $this->cart;
        $cartCount = $this->cart->countItem();

        if ($cartCount == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        return view('shop.checkout', compact('cart', 'cartCount'));
    }

    public function store(Request $request)
    {
        $cartItems = $this->cart->get();

        $request->merge(['checkout' => true]);

        $validation = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'notes' => 'nullable|string',
            'checkout' => [new OrderValidation($cartItems)],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create the order
            $order = new Order();
            $order->full_name = $request->full_name;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->notes = $request->notes;
            $order->total_amount = $this->cart->total();
            $order->status = Order::STATUS_PENDING;
            $order->save();

            // Create order items and reduce product stock
            foreach ($cartItems as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product->id;
                $orderItem->product_name = $item->product->name;
                $orderItem->quantity = $item->quantity;
                $orderItem->unit_price = $item->product->price;
                $orderItem->total_price = $item->product->price * $item->quantity;
                $orderItem->save();

                // Reduce product stock
                $product = $item->product;
                $product->stock -= $item->quantity;
                $product->save();
            }

            // Clear the cart
            $this->cart->empty();

            DB::commit();

            // Return JSON response with success and redirect URL
            return response()->json([
                'success' => true,
                'message' => 'Your order has been placed successfully!',
                'redirect' => route('checkout.success', ['order' => $order->id])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error
            \Log::error('Checkout failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong. Please try again.',
            ], 500);
        }

    }

    public function success($orderId)
    {
        $order = Order::with('products')->findOrFail($orderId);
        $cartCount = $this->cart->countItem();
        return view('shop.checkout.success', compact('order', 'cartCount'));
    }
}
