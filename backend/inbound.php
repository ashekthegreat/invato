<?php
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

// Constants
$FIREBASE = "https://invato-53a3d.firebaseio.com/inbox/";
$NODE_PUT = time() + generateRandomString(5) . ".json";

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

//////////////////////////////////

/**
 * This section actually sends the email.
 */

/* Your email address */
$to = "info@rumorphotomedia.com";
$subject = "Message from {$_REQUEST['From']} at {$_REQUEST['To']}";
$message = "You have received a message from {$_REQUEST['From']}. Body: {$_REQUEST['Body']}";
$headers = "From: info@rumorphotomedia.com"; // Who should it come from?

mail($to, $subject, $message, $headers);

header('Content-Type: text/xml');
?>

<Response></Response>