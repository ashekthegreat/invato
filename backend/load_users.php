<?php
// Get the PHP helper library from twilio.com/docs/php/install
require_once 'Twilio/autoload.php'; // Loads the library
use Twilio\Rest\Client;

$twilioConfig = array(
    "sandbox" => array(
        "sid" => "AC36d7856deb125b0e55e82f14e526d58b",
        "token" => "870b1853c8a4f86fa14e9f424f3a0395",
        "from" => "+15005550006"
    ),
    "dev" => array(
        "sid" => "ACacfc17815142913921ded0d05f6a3cb1",
        "token" => "1ee87e01641571e87f603f0d00a673b0",
        "from" => "+13057126545"

    ),
    "prod" => array(
        "sid" => "AC704c50faa4760223b48e3cc3c600a948",
        "token" => "cb1e2a542ffa4086ef758733ace4a9da",
        "from" => "+16468878667"
    )
);
$activeTwilioMode = "dev";

function loadMessages($config)
{
    $response = array();
    $client = new Client($config["sid"], $config["token"]);
    // Loop over the list of messages and echo a property for each one
    foreach ($client->messages->read() as $message) {
        //echo $message->body . "<br>";
        array_push($response, $message);
    }
    echo json_encode( $response);
}
loadMessages($twilioConfig[$activeTwilioMode]);