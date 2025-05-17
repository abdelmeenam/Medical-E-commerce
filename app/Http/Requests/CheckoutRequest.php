<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Cart;
use App\Models\Product;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|email|max:255',
            'email' => 'required|string|max:500',
            'address' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                // Get cart items

                // Check stock for each item
                foreach ($cartItems as $item) {
                    $product = Product::find($item->product_id);

                    if (!$product) {
                        $validator->errors()->add(
                            'cart', "Product not found: {$item->product_id}"
                        );
                        return;
                    }

                    if ($product->stock < $item->quantity) {
                        $validator->errors()->add(
                            'cart', "Insufficient stock for {$product->name}. Available: {$product->stock}, Requested: {$item->quantity}"
                        );
                        return;
                    }
                }
            }
        ];
    }
}
