<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\CartObserver;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['cookie_id', 'product_id', 'quantity', 'options'];


    /**
     * Get cart items based on the cookie_id.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected static function booted(): void
    {
        // Observe the Cart model to set the cookie_id and UUID
        static::observe(CartObserver::class);

        // Add a global scope to filter cart by cookie_id
        static::addGlobalScope('cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', '=', Cart::getCookieId());
        });
    }

    /**
     * Get the cookie ID for the cart.
     *
     * @return string
     */
    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');

        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
