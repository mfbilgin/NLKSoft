<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success()
    {
        return view('order.success');
    }

    public function user_order_list()
    {
        $user_id = auth()->id();
        $orders = Order::where('user_id', $user_id)->orderBy('created_at','desc')->get();
        return view('order.user_order_list', compact('orders'));
    }

    public function order_detail($id)
    {
        $order = Order::find($id);
        if($order->user_id != auth()->id()){
            abort(404);
        }
        return view('order.detail', compact('order'));
    }

}
