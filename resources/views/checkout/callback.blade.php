<?php
require_once(base_path('iyzipay-php-master/samples/config.php'));

# create request class
$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId('12345678');
$request->setToken($_POST['token']);

# make request
$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

?>
@extends('layouts.app')
