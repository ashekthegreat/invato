<?php

require_once 'medoo.min.php';

$database = new medoo();

$postData = file_get_contents("php://input");
$request = json_decode($postData);
$id = $request->id;

$versions = $database->delete("versions", [
    "AND" => [
        "id" => $id
    ]
]);

echo json_encode(array("id" => $id));