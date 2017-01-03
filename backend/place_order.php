<?php
/*var_dump( json_decode( $_POST['details']));
exit(0);*/
require "advEmail.php";
$sendTo = 'sales@studynex.com';
//$sendCC = 'mail.ashek@gmail.com';
$sendBCC = 'mail.ashek@gmail.com';
$subject = "StudyNex Order placed";
$body = '<h3>StudyNex Order Placed</h3>';
$advEmail = new advEmail();
$advEmail->setMailType('html');

if (isset($_POST)) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = isset($_POST['email'])? $_POST['email'] : "info@studynex.com";
    $phone = $_POST['phone'];

    /*$body = $body . "<p><b>Name:</b> " . $name . "<br/><br/>";
    $body = $body . "<b>Address:</b> " . $address . "<br/><br/>";
    $body = $body . "<b>Email:</b> " . $email . "<br/><br/>";
    $body = $body . "<b>Phone:</b> " . $phone . "<br/></p>";*/
    $body = $_POST['emailBody'];

    $advEmail->from($email, $name);
    $advEmail->to($sendTo);
    $advEmail->bcc($sendBCC);

    $advEmail->subject($subject);
    $advEmail->message($body);

    if (!$advEmail->send()) {
        $errors = $advEmail->getDebugger();
        print_r($errors);
    } else{
        echo "Success";
    }
} else {
    echo "Something was missing";
}