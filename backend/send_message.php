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
        "sid" => "",
        "token" => "",
        "from" => ""
    )
);
$activeTwilioMode = "sandbox";

function sendMessage($config, $numbers, $message)
{
    $response = array();
    if (!is_array($numbers)) {
        return $response;
    }

    $client = new Client($config["sid"], $config["token"]);
    $countOfNumbers = count($numbers);
    for ($i = 0; $i < $countOfNumbers; $i++) {
        $sms = $client->messages->create(
            $numbers[$i],
            array(
                "from" => $config["from"],
                "body" => $message
            )
        );

        array_push($response, $sms->sid);
    }
    return $response;
}

function splitNewLine($text)
{
    $code = preg_replace('/\n$/', '', preg_replace('/^\n/', '', preg_replace('/[\r\n]+/', "\n", $text)));
    return explode("\n", $code);
}

function splitComma($text)
{
    return explode(",", $text);
}

//echo json_encode(array("id" => $sms->sid));

$postData = file_get_contents("php://input");
$request = json_decode($postData);
$numbers = splitNewLine($request->numbers);
$numbers = array_unique($numbers);

$response = sendMessage($twilioConfig[$activeTwilioMode], $numbers, $request->message);

echo json_encode(array(
    "success" => true,
    "message" => "Message sent successfully to " . count($numbers) . " numbers",
    "response" => $response
));