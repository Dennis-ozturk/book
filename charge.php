<?php
session_start();
require_once('db/db.php');
require_once('classes/user.inc.php');
require_once('classes/api.inc.php');
require_once('classes/customer.inc.php');
require_once('classes/transactions.inc.php');
require_once('vendor/stripe/stripe-php/init.php');
$customer = new User;
$api = new Api;

\Stripe\Stripe::setApiKey('sk_test_LvxmAu7Kh0QJrtpcUXq40CCF');
// Get the token from the JS script
$token = $_POST['stripeToken'];

$name_first = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
$name_last = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
$email = $_SESSION['user'];
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);
$country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$user_info = array("firstname" => $name_first, "lastname" => $name_last, "email" => $email, "address" => $address, "state" => $state, "zip" => $zip, "country" => $country, "phone" => $phone);

//Create customer
$customer = \Stripe\Customer::create(array(
    "email" => $email,
    "source" => $token,
));

//Charge customer
$charge = \Stripe\Charge::create(array(
    'amount' => 2000,
    'currency' => 'sek',
    'description' => 'Purchase off Caite watch',
    'customer' => $customer->id,
));

// New customer object
$customer = new Customer;

//New transaction object
$transaction = new Transaction;

$customerData = [
    'id' => $charge->customer,
    'firstname' => $user_info['firstname'],
    'lastname' => $user_info['lastname'],
    'email' => $user_info['email'],
    'address' => $user_info['address'],
    'state' => $user_info['state'],
    'zip' => $user_info['zip'],
    'country' => $user_info['country'],
    'phone' => $user_info['phone'],
];

$transactionData = [
    'id' => $charge->id,
    'customer_id' => $charge->customer,
    'product' => $charge->description,
    'amount' => $charge->amount,
    'currency' => $charge->currency,
    'status' => $charge->status,
];

//Check if customer exists
$checkCustomer = $customer->checkCustomerExists($customerData);

$checkTransfer = $transaction->addTransaction($transactionData);

if($checkCustomer == false){
    $transaction->addTransaction($transactionData);

}elseif(!$checkCustomer == false){
    $transactionData2 = [
        'id' => $charge->id,
        'customer_id' => $checkCustomer,
        'product' => $charge->description,
        'amount' => $charge->amount,
        'currency' => $charge->currency,
        'status' => $charge->status,
    ];
    $transaction->addTransaction($transactionData2);
}else {
}



//Send to success page
//header('Location: success.php?tid=' . $charge->id . '&product=' . $charge->description);