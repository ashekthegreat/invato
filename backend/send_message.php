<?php
// Get the PHP helper library from twilio.com/docs/php/install
require_once 'Twilio/autoload.php'; // Loads the library
use Twilio\Rest\Client;

function sendMessage($to, $message)
{
    $response = array();
    if (!is_array($to)){
        return $response;
    }

    // Your Account Sid and Auth Token from twilio.com/user/account
    $sid = "AC36d7856deb125b0e55e82f14e526d58b";
    $token = "870b1853c8a4f86fa14e9f424f3a0395";
    $from = "+15005550006";
    $client = new Client($sid, $token);

    $countOfNumbers = count($to);
    for($i=0; $i<$countOfNumbers; $i++){
        $sms = $client->messages->create(
            $to[$i],
            array(
                "from" => $from,
                "body" => $message
            )
        );

        array_push($response, $sms);
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


$response = sendMessage($numbers, $request->message);

echo json_encode(array("tag" => "Some tag", "numbers" => $numbers, "message" => $request->message, "response" => $response));