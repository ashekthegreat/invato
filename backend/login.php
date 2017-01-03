<?php
require_once 'medoo.min.php';
require_once 'auth_helper.php';

$database = new medoo();

$postData = file_get_contents("php://input");
$request = json_decode($postData);

$email = $request->email;
$password = $request->password;

$user = $database->get("users", [
    "id",
    "name",
    "email",
    "type",
    "project_ids(projectIds)"
], [
    "AND" => [
        "email" => $email,
        "password" => md5( $password)
    ]
]);

if ($user) {
    $auth = get_auth($user);
    echo json_encode(array("success" => true, "auth" => $auth));
} else {
    echo json_encode(array("success" => false, "message" => "Invalid Credentials"));
}
