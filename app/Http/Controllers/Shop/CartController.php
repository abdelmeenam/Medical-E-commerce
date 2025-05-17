<?php

namespace App\Http\Controllers\Shop;

use App\Models\Product;
use App\Rules\CartValidation;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Rules\StockValidation;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('shop.cart', ['cart' => $this->cart, 'cartCount' => $this->cart->countItem()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $validations = Validator::make($request->all(), [
            'product_id' => 'required|int|exists:products,id',
            'quantity'   => ['required','int','max:1' , new StockValidation($request->product_id)]
        ]);

        if ($validations->fails()) {
            return response()->json([
                'error' => $validations->errors()->first(),
            ], 422);
        }

        try {

            $product = Product::findOrFail($request->product_id);
            $this->cart->add($product, $request->quantity);

            return response()->json([
                'success' => "Item added to cart",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => "Failed to add product to cart: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validations = Validator::make($request->all(), [
            'quantity' => ['required', 'int', 'min:1', new CartValidation($id)],
        ]);

        if ($validations->fails()) {
            return response()->json([
                'error' => $validations->errors()->first(),
            ], 422);
        }

        $this->cart->update($id, $request->post('quantity'));

        return response()->json([
            'message' => "Item updated",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): array
    {
        $this->cart->delete($id);
        return [
            'message' => "Item deleted",
        ];
    }
}
