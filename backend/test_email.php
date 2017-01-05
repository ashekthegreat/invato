<?php
require "advEmail.php";

function send_email($sendTo, $subject, $body)
{
    $from = "info@rumorphotomedia.com";
    $fromName = "Info";
    $sendBCC = "mail.ashek@gmail.com";
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

//echo send_email("mail.ashek@gmail.com", "Testing", "Testing body message");

/**
 * This section actually sends the email.
 */

/* Your email address */
$to = "mail.ashek@gmail.com";
$subject = "Message from someone";
$message = "You have received a message from someone";
$headers = "From: info@rumorphotomedia.com"; // Who should it come from?

echo mail($to, $subject, $message, $headers);