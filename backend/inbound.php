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

//////////////////////////////////


header('Content-Type: text/xml');
?>

<Response></Response>