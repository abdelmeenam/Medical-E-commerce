<?php

namespace App\Http\Controllers\Shop;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepository;

class ProductController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }


    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);
        $products = $query->orderBy('name')->paginate(12);
        $cartCount = $this->cart->countItem();

        return view('shop.home', compact('products', 'cartCount'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('shop.products.show', compact('product', 'relatedProducts'));
    }
}
