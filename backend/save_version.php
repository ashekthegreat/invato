<?php

require_once 'medoo.min.php';

$database = new medoo();

$postData = file_get_contents("php://input");
$request = json_decode($postData);
$id = $request->id;

if($id && $id > 0){
    // its an existing version
    $database->update("versions", [
        "name" => $request->name,
        "note" => $request->note,
        "created_at" => date("Y-m-d H:i:s"),
        "organization" => json_encode($request->organization)
    ], [
        "id" => $request->id
    ]);

}else{
    $id = $database->insert("versions", [
        "project_id" => $request->project_id,
        "name" => $request->name,
        "note" => $request->note,
        "organization" => json_encode($request->organization)
    ]);
}

echo json_encode(array("id" => $id));