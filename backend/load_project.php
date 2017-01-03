<?php
/**
 * Created by PhpStorm.
 * User: AZEC
 * Date: 7/26/2015
 * Time: 3:35 AM
 */

require_once 'medoo.min.php';

$database = new medoo();

$id = $_GET['id'];

// Todo: check for auth token

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


$project['versions'] = $database->select("versions", "*", [
    "project_id" => $id
]);


echo json_encode($project);