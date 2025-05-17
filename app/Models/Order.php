<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_number',
        'full_name',
        'phone',
        'email',
        'address',
        'notes',
        'status',
        'total_amount'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /**
     * Assign each order a unique order number.
     *
     * @var array<int, string>
     */
    protected static function booted(): void
    {
        static::creating(function(Order $order){
            //20250001 - 20250002
            $order->order_number = Order::getNextOrderNumber();
        });
    }

    /**
     * Generate a unique order number.
     *
     * @return string
     */
    public static function getNextOrderNumber(): string
    {
        // SELECT MAX(number) FROM orders
        $year = Carbon::now()->year;
        $order_number = Order::whereYear('created_at' , $year)->max('order_number');

        // if there is number in this year add 1 to this number
        if ($order_number) {
            return $order_number + 1;
        }

        // if not return 0001
        return $year . '0001';
    }


    /**
     * Get the order's products.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot([
                'product_name', 'total_price', 'quantity', 'unit_price'
            ]);
    }
}
