<?php

namespace App\Rules;

use Closure;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;

class CartValidation implements ValidationRule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $product_id;
    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::where('id', $this->product_id)->first();
        if ($product->stock < $value) {
            $fail('you can add only ' . $product->stock . ' items of this product');
        }
    }
}
