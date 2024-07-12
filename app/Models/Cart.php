<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function total_price()
    {
        $total_price = 0;
        $cart_items = $this->cartItems;
        foreach ($cart_items as $cartItem) {
            $total_price += $cartItem->product->unitPrice * $cartItem->quantity;
        }
        return $total_price;
    }

    public function product_count()
    {
        $product_count = 0;
        $cart_items = $this->cartItems;
        foreach ($cart_items as $cartItem) {
            $product_count += $cartItem->quantity;
        }
        return $product_count;
    }

    public function empty()
    {
        $this->cartItems()->delete();
    }
}
