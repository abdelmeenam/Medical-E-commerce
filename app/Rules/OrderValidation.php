<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderValidation implements ValidationRule
{
    protected $cartItems;

    public function __construct($cartItems)
    {
        $this->cartItems = $cartItems;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->cartItems as $cartItem)
        {
            if (($cartItem->product->stock ) < $cartItem->quantity) {
                $fail('The product ' . $cartItem->product->name . ' is out of stock.');
            }
        }
        return;
    }
}
