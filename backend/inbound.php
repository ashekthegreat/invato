<?php
require "advEmail.php";
$number = $_POST['From'];
$body = $_POST['Body'];

/////////////////////////////////

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function send_email($sendTo, $subject, $body)
{
    $from = "mail.ashek@gmail.com";
    $fromName = "Ashek";
    $sendBCC = "";
    $advEmail = new advEmail();
    $advEmail->setMailType('html');
    $advEmail->from($from, $fromName);
    $advEmail->to($sendTo);
    $advEmail->bcc($sendBCC);

    $advEmail->subject($subject);
    $advEmail->message($body);

    if (!$advEmail->send()) {
        return $advEmail->getDebugger();
    }
    return true;
}

// Constants
$FIREBASE = "https://invato-53a3d.firebaseio.com/inbox/";
$NODE_PUT = generateRandomString(10) . ".json";

$data = array();
$data[generateRandomString(10)] = 43;

// JSON encoded
$json = json_encode( $_POST );

// Initialize cURL
$curl = curl_init();

// Create
curl_setopt( $curl, CURLOPT_URL, $FIREBASE . $NODE_PUT );
curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PUT" );
curl_setopt( $curl, CURLOPT_POSTFIELDS, $json );

// Get return value
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

// Make request
// Close connection
$response = curl_exec( $curl );
curl_close( $curl );

// send email as a notification
$email = "mail.ashek@gmail.com";
$subject = "New message arrived";
$body = '<h1>New message arrived!</h1>';
$body .= '<p>From: '. $_POST["From"] .'</p>';
$body .= '<p>'. $_POST["Body"] .'</p>';
send_email($email, $subject, $body);
//////////////////////////////////


header('Content-Type: text/xml');
?>

<Response></Response>