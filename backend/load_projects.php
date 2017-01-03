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

foreach ($projects as &$project) {
    $project['versions'] = $database->select("versions", [
        "id",
        "project_ids(projectIds)",
        "name",
        "note",
        "created_at"
    ], [
        "project_id" => $project["id"]
    ]);
}
//print_r($projects);

echo json_encode($projects);