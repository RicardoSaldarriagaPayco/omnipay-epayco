<?php
require 'vendor/autoload.php';
use Omnipay\Omnipay;

$gateway = Omnipay::create('Epayco');

//$gateway = Omnipay::create('PayPal_Express');
$gateway->setUsername('ric.salda.94_api1.gmail.com');
$gateway->setPassword('FQFAV7GUVEN89YQQ');
$gateway->setSignature('AQXugmPcI5E1bK.j8n3yIxEPLGV6A4YS9-xgC8Cve7pIfug0nrPxUFTE');
$gateway->setTestMode('sandbox');

$formData = [
    'number' => '4242424242424242',
    'expiryMonth' => '6',
    'expiryYear' => '2025',
    'cvv' => '123'
];

$response = $gateway->purchase(
    [
        'amount' => '10.00',
        'currency' => 'USD',
        //'card' => $formData,
        'cancelUrl' => 'www.sampĺe.cancel',
        'returnUrl' => 'www.sampĺe.return',
        'notifyUrl' => 'www.sample.norify',
        'transactionId' => '12341234',
        'description' => 'pago de prueba'
    ]
)->send();

// Process response
if ($response->isSuccessful()) {

    // Payment was successful
    var_dump($response->getData());
    echo '<br>';
    var_dump($response->getCardReference());
    echo '<br>';
    var_dump($response->getTransactionReference());
    echo '<br>';
    var_dump($response->getMessage());
    echo '<br>';

    // print_r($response);

} elseif ($response->isRedirect()) {

    $url = $response->getRedirectUrl();
// for a form redirect, you can also call the following method:
    $data = $response->getRedirectData();
    // Redirect to offsite payment gateway
    echo $response->redirect();

} else {

    // Payment failed
    echo $response->getMessage();
}

