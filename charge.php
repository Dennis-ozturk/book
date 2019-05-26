<?php
require_once('db/db.php');
require_once('classes/user.inc.php');
require_once('vendor/stripe/stripe-php/init.php');

$customer = new User;

\Stripe\Stripe::setApiKey('sk_test_LvxmAu7Kh0QJrtpcUXq40CCF'); //YOUR_STRIPE_SECRET_KEY
// Get the token from the JS script
$token = $_POST['stripeToken'];
// This is a $20.00 charge in US Dollar.
//Charging a Customer
// Create a Customer
$name_first = "Batosai";
$name_last = "Ednalan";
$email = "dennis20@gmail.com";
$address = "New Cabalan Olongapo City";
$state = "Zambales";
$zip = "22005";
$country = "Philippines";
$phone = "09306408219";
$user_info = array("firstname" => $name_first, "lastname" => $name_last, "email" => $email, "address" => $address, "state" => $state, "zip" => $zip, "country" => $country, "phone" => $phone);

$customer = \Stripe\Customer::create(array(
    "email" => $email,
    "source" => $token,
    'metadata' => $user_info,
));

$customer_id = 'cus_F6Ai4gLolcMAb3';

if (isset($customer_id)) {
    try {
        $customer = \Stripe\Customer::retrieve($customer_id);
    } catch (\Stripe\Error\Card $e) {
        $body = $e->getJsonBody();
        $err = $body['error'];

        print('Status is:' . $e->getHttpStatus() . "\n");
        print('Type is:' . $err['type'] . "\n");
        print('Code is:' . $err['code'] . "\n");

        print('Param is:' . $err['param'] . "\n");
        print('Message is:' . $err['message'] . "\n");
    } catch (\Stripe\Error\RateLimit $e) { } catch (\Stripe\Error\InvalidRequest $e) { } catch (\Stripe\Error\Authentication $e) { } catch (\Stripe\Error\ApiConnection $e) { } catch (\Stripe\Error\Base $e) { } catch (Exception $e) { }
} else {
    try {
        $customer = \Stripe\Customer::create(array(
            'email' => $email,
            'source' => $token,
            'metadata' => $user_info,
        ));
    } catch (\Stripe\Error\Card $e) {
        $body = $e->getJsonBody();
        $err = $body['error'];

        print('Status is:' . $e->getHttpStatus() . "\n");
        print('Type is:' . $err['type'] . "\n");
        print('Code is:' . $err['code'] . "\n");

        print('Param is:' . $err['param'] . "\n");
        print('Message is:' . $err['message'] . "\n");
    } catch (\Stripe\Error\RateLimit $e) { } catch (\Stripe\Error\InvalidRequest $e) { } catch (\Stripe\Error\Authentication $e) { } catch (\Stripe\Error\ApiConnection $e) { } catch (\Stripe\Error\Base $e) { } catch (Exception $e) { }
}

if (isset($customer)) {
    // customer info
    // print_r($customer);
    $charge_customer = true;

    try {
        $charge = \Stripe\Charge::create(array(
            'amount' => 2000,
            'description' => 'Purchase off Caite watch',
            'currency' => 'sek',
            'customer' => "2",
            'customer' => $customer->id,
            'metadata' => $user_info
        ));
    } catch (\Stripe\Error\Card $e) {
        $body = $e->getJsonBody();
        $err = $body['error'];

        print('Status is:' . $e->getHttpStatus() . "\n");
        print('Type is:' . $err['type'] . "\n");
        print('Code is:' . $err['code'] . "\n");

        print('Param is:' . $err['param'] . "\n");
        print('Message is:' . $err['message'] . "\n");

        $charge_customer = false;
    } catch (\Stripe\Error\RateLimit $e) { } catch (\Stripe\Error\InvalidRequest $e) { } catch (\Stripe\Error\Authentication $e) { } catch (\Stripe\Error\ApiConnection $e) { } catch (\Stripe\Error\Base $e) { } catch (Exception $e) { }

    if ($charge_customer) {
        //Amount charged info
        //print_r($charge);
    }
}
