<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
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
        $cart_id = Cart::where('user_id', auth()->id())->first()->id;
        $cart = CartItem::where('cart_id', $cart_id)->where('product_id', $product_id)->first();
        if (!$cart) {
            $cart = new CartItem();
            $cart->cart_id = $cart_id;
            $cart->product_id = $product_id;
            $cart->quantity = 1;
        } else {
            $cart->quantity += 1;
        }
        $cart->save();
        return redirect()->back()->with('status', 'success')->with('message', 'Ürün sepete eklendi.');
    }

    public function increase_cart_item_quantity(Request $request)
    {

        $cart_item_id = $request->cart_item_id;
        $cart_item = CartItem::find($cart_item_id);
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
                $cartItem->product->decrease_stock($cartItem->quantity);
            }

            $order->user->cart->empty();
            session()->forget('address');
            session()->put('order_id', $order->id);
            return redirect()->route('order.success')->with('status', 'success')->with('message', 'Ödeme başarılı');
        } else {
            return redirect()->route('checkout.index')->with('status', 'danger')->with('message', 'Ödeme başarısız');
        }
    }

    public function address_add(Request $request)
    {
        session()->put('address', $request->all());
    }
}
