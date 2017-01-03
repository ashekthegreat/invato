<?php

require_once 'medoo.min.php';

$database = new medoo();

$projects = $database->select("projects", [
    "id",
    "name",
    "description",
    "contact",
    "logo",
    "created_at"
], [
    "ORDER" => "created_at DESC"
]);

echo json_encode($projects);