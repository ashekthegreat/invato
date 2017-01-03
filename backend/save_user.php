<?php
require_once 'medoo.min.php';
require "advEmail.php";
require_once 'auth_helper.php';

function send_email($sendTo, $subject, $body)
{
    $logged_in_user = get_logged_in_user();
    //return $logged_in_user;
    $from = $logged_in_user->email;
    $fromName = $logged_in_user->name;
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

function send_new_user_email($name, $email, $password, $type, $login_url)
{
    $subject = "Stack tool invitation";
    $body = '<h1>Welcome to Stack Tool</h1>';
    if ($type == "admin") {
        $body .= '<p>You have been invited to work as an <b>Admin</b></p>';
    } else {
        $body .= '<p>You have been invited to work on a project</p>';
    }
    $body .= '<p>Please use the below credentials to login:</p>';
    $body .= '<p>URL: <a href="' . $login_url . '">' . $login_url . '</a></p>';
    $body .= '<p>Email: ' . $email . '<br>Password: ' . $password . '</p>';
    return send_email($email, $subject, $body);
}

function send_password_change_email($name, $email, $password, $type, $login_url)
{
    $subject = "Stack tool password changed";
    $body = '<h1>Password was changed!</h1>';
    $body .= '<p>Your password has been changed.</p>';
    $body .= '<p>Please use the below credentials to login:</p>';
    $body .= '<p>URL: <a href="' . $login_url . '">' . $login_url . '</a></p>';
    $body .= '<p>Email: ' . $email . '<br>Password: ' . $password . '</p>';
    return send_email($email, $subject, $body);
}

$database = new medoo();

$postData = file_get_contents("php://input");
$request = json_decode($postData);

$user_id = $request->id;
$login_url = $request->name;
$user = array(
    "name" => $request->name,
    "email" => $request->email,
    "type" => $request->type,
    "project_ids" => json_encode($request->projectIds),
    "note" => $request->note
);

if ($request->id && $request->id > 0) {

    if ($request->password != "") {
        $user["password"] = md5($request->password);
        $email_status = send_password_change_email($user["name"], $user["email"], $request->password, $user["type"], $login_url);
    }

    // its an existing user
    $database->update("users", $user, [
        "id" => $request->id
    ]);

} else {
    $user["password"] = md5($request->password);
    $user_id = $database->insert("users", $user);
    $email_status = send_new_user_email($user["name"], $user["email"], $request->password, $user["type"], $login_url);
}

echo json_encode(array("id" => $user_id, "email_status" => print_r($email_status)));