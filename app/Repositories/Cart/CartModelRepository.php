<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartModelRepository implements CartRepository
{
    public $items;

     public function __construct()
     {
         //collect all items(array to collection(object))
         $this->items = collect([]);
     }

    public function get(): Collection
    {
        if (!$this->items->count()) {
            $this->items = Cart::with('product')->get();
        }
        return $this->items;
    }

    public function countItem(): int
    {
        return $this->get()->count();
    }

    public function add(Product $product, $quantity = 1): Cart|int
    {
        //case you add the same product at the future
        $item =  Cart::where('product_id', '=', $product->id)->first();

        if (!$item) {
            $cart = Cart::create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
            $this->get()->push($cart);
            return $cart;
        }

        return $item->increment('quantity', $quantity);
    }

    public function update($id, $quantity): void
    {
        Cart::where('product_id', '=', $id)->update(['quantity' => $quantity]);
    }

    public function delete($id): void
    {
        Cart::where('product_id', '=', $id)->delete();
    }

    public function empty(): void
    {
        Cart::query()->delete();
    }

    public function total(): float
    {
         return $this->get()->sum(function ($item) {
             return $item->quantity * $item->product->price;
         });
    }
}
