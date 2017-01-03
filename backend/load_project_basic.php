<?php
require_once 'medoo.min.php';

$database = new medoo();

$id = $_GET['id'];

// lets get the project
$project = $database->get("projects", [
    "id",
    "name",
    "description",
    "contact",
    "logo",
    "created_at"
], [
    "id" => $id
]);


echo json_encode($project);