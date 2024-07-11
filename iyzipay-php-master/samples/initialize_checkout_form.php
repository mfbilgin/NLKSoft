<?php use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Currency;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;

require_once('config.php');

$user_id = auth()->id();
$user = User::find($user_id);
$exploded_name = explode(' ', $user->name);
$user_last_name = array_pop($exploded_name);
$user_first_name = trim(implode(' ', $exploded_name));
$cart = Cart::where('user_id', $user_id)->first();
$cart_items = CartItem::where('cart_id', $cart->id)->get();
$cart_total = $cart->total_price();

if (!session('address')) {
session()->put('status', 'danger');
session()->put('message', 'Adres seçimi yapmayı unuttun.');
return redirect()->back();
}

$address = \App\Models\Address::find(session('address'))->first();

$request = new CreateCheckoutFormInitializeRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId($user_id . '-' . $address->id);
$request->setPrice($cart_total);
$request->setPaidPrice($cart_total);
$request->setCurrency(Currency::TL);
$request->setBasketId($cart->id);
$request->setPaymentGroup(PaymentGroup::PRODUCT);
$request->setCallbackUrl(route('checkout.callback'));
$request->setEnabledInstallments(array(2, 3, 6, 9, 12));

$buyer = new Buyer();
$buyer->setId($user_id);
$buyer->setName($user_first_name);
$buyer->setSurname($user_last_name);
$buyer->setIp(request()->ip());
$buyer->setEmail($user->email);
$buyer->setIdentityNumber($address->identity_number);
$buyer->setRegistrationAddress($address->address);
$buyer->setCity($address->city);
$buyer->setZipCode($address->zip_code);
$buyer->setCountry("Türkiye");
$request->setBuyer($buyer);

$shippingAddress = new Address();
$shippingAddress->setContactName($address->contact_name);
$shippingAddress->setCity($address->city);
$shippingAddress->setCountry("Türkiye");
$shippingAddress->setAddress($address->address);
$shippingAddress->setZipCode($address->zip_code);
$request->setShippingAddress($shippingAddress);

$billingAddress = new Address();
$billingAddress->setContactName($address->contact_name);
$billingAddress->setCity($address->city);
$billingAddress->setCountry("Türkiye");
$billingAddress->setAddress($address->address);
$billingAddress->setZipCode($address->zip_code);
$request->setBillingAddress($billingAddress);

$basketItems = array();

foreach ($cart_items as $key => $cart_item) {
$basketItem = new BasketItem();
$basketItem->setId($cart_item->id);
$basketItem->setName($cart_item->product->name);
$basketItem->setCategory1($cart_item->product->category->name);
$basketItem->setCategory2($cart_item->product->category->name);
$basketItem->setItemType(BasketItemType::PHYSICAL);
$basketItem->setPrice((string)($cart_item->product->unitPrice * $cart_item->quantity));
$basketItems[$key] = $basketItem;
}

$request->setBasketItems($basketItems);

$checkoutFormInitialize = CheckoutFormInitialize::create($request, Config::options());

print_r($checkoutFormInitialize->getCheckoutFormContent());
print_r($checkoutFormInitialize->getErrorMessage());
?>
<html lang="tr">
<body>
<div id="iyzipay-checkout-form" class="responsive"></div>
</body>
</html>
