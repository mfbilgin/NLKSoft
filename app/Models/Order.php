<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'address_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public static function create($total_amount,$address_id,$user_id): Order
    {
        $order = new Order();
        $order->user_id = $user_id;
        $order->address_id = $address_id;
        $order->total_amount = $total_amount;
        $order->save();

        return $order;
    }
}
