<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add_to_cart(Request $request)
    {
        $product_id = $request->product_id;
        $cart = Cart::where('user_id', auth()->id())->first();
        $cart_id = $cart->id;
        $cart_item = CartItem::where('cart_id', $cart_id)->where('product_id', $product_id)->first();
        if (!$cart_item) {
            $cart_item = new CartItem();
            $cart_item->cart_id = $cart_id;
            $cart_item->product_id = $product_id;
            $cart_item->quantity = 1;
        } else {
            if($cart->total_price() + $cart_item->product->unitPrice > 100000){
                return redirect()->back()->with('status', 'danger')->with('message', 'Sepetteki ürünlerin toplam fiyatı 100.000 TL’yi geçemez');
            }
            if($cart_item->quantity + 1 > $cart_item->product->unitsInStock){
                return redirect()->back()->with('status', 'danger')->with('message', 'Daha fazla stok yok');
            }
            $cart_item->quantity += 1;
        }
        $cart_item->save();
        return redirect()->back()->with('status', 'success')->with('message', 'Ürün sepete eklendi.');
    }

    public function increase_cart_item_quantity(Request $request)
    {
        $cart_item_id = $request->cart_item_id;
        $cart_item = CartItem::find($cart_item_id);
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart->total_price() + $cart_item->product->unitPrice > 100000) {
            return redirect()->route('cart.index')->with('status', 'danger')->with('message', 'Sepetteki ürünlerin toplam fiyatı 100.000 TL’yi geçemez');
        }
        if ($cart_item->product->unitsInStock < $cart_item->quantity + 1) {
            return redirect()->route('cart.index')->with('status', 'danger')->with('message', 'Daha fazla stok yok');
        }
        CartItem::find($cart_item_id)->increment('quantity');
        return redirect()->route('cart.index');
    }

    public function decrease_cart_item_quantity(Request $request)
    {
        $cart_item_id = $request->cart_item_id;
        $cart_item = CartItem::find($cart_item_id);
        if ($cart_item->quantity > 1) {
            $cart_item->decrement('quantity');
        } else {
            $cart_item->delete();
        }
        return redirect()->back();
    }

    public function checkout()
    {
        return view('checkout.index');
    }

    public function callback()
    {
        require_once(base_path('iyzipay-php-master/samples/config.php'));


        # create request class
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);

        $request->setConversationId('12345678');
        $request->setToken($_POST['token']);


        # make request
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

        if($checkoutForm->getPaymentStatus() == 'SUCCESS') {
            $order = Order::create($checkoutForm->getPaidPrice(), session('address')['selected_address'], auth()->id());

            foreach ($order->user->cart->cartItems()->get() as $cartItem){
                $this->create_order_item($cartItem, $order->id);
                $cartItem->product->decrease_stock($cartItem->quantity);
            }

            $order->user->cart->empty();
            session()->forget('address');
            session()->put('order_id', $order->id);
            return redirect()->route('order.success');
        } else {
            return redirect()->route('checkout.index')->with('status', 'danger')->with('message', 'Ödeme başarısız');
        }
    }

    public function  select_address(Request $request)
    {
        session()->put('address', $request->all());
    }

    private function create_order_item($cart_item, $order_id)
    {
        $order_item = new OrderItem();
        $order_item->order_id = $order_id;
        $order_item->product_id = $cart_item->product_id;
        $order_item->quantity = $cart_item->quantity;
        $order_item->user_id = auth()->id();
        $order_item->price = $cart_item->product->unitPrice;
        $order_item->save();
    }

    public function clear_cart()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        $cart->cartItems()->delete();
        return redirect()->back();
    }
}
