<?php
require_once 'medoo.min.php';

$database = new medoo();

$postData = file_get_contents("php://input");
$request = json_decode($postData);

$last_version_id = 0;

if($request->version->id == 0){
    // create new version
    $last_version_id = $database->insert("versions", [
        "project_id" => $request->version->project_id,
        "name" => $request->version->name,
        "note" => $request->version->note,
        "organization" => json_encode($request->version->organization)
    ]);
} else{
    $database->update("versions", [
        "name" => $request->version->name,
        "note" => $request->version->note,
        "created_at" => date("Y-m-d H:i:s"),
        "organization" => json_encode($request->version->organization)
    ], [
        "id" => $request->version->id
    ]);
}

echo $last_version_id;