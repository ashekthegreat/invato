<?php

require_once 'medoo.min.php';

$database = new medoo();

$users = $database->select("users", [
    "id",
    "name",
    "email",
    "type",
    "project_ids(projectIds)",
    "note"
], [
    "ORDER" => "name ASC"
]);

foreach ($users as &$user) {
    $user['projectIds'] = json_decode($user['projectIds']);
}

echo json_encode($users);