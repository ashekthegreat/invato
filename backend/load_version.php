<?php

require_once 'medoo.min.php';

$database = new medoo();

$id = $_GET['id'];

// lets get the project
$version = $database->get("versions", "*", [
    "id" => $id
]);

echo json_encode($version);