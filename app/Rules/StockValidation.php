<?php

namespace App\Rules;

use Closure;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;

class StockValidation implements ValidationRule
{
    protected $productId;

    /**
     * Create a new rule instance.
     *
     * @param int $productId
     * @return void
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::where( [['id' ,'=',$this->productId],['stock' , '>=' , $value]])->first();
        if($product){
            $item = Cart::where('product_id', '=', $product->id)->first();
            if($item && ($item->quantity + $value) > $product->stock){
                $fail('The quantity exceeds the available stock.');
                return;
            }
            return;
        }
        $fail('The quantity exceeds the available stock.');
    }
}
