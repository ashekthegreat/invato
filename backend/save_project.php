<?php

require_once 'medoo.min.php';

$database = new medoo();

/*
* Collect all Details from Angular HTTP Request.
*/
$postData = file_get_contents("php://input");
$request = json_decode($postData);

$project_id = $request->id;

if ($request->id && $request->id > 0) {

    // its an existing project
    $database->update("projects", [
        "name" => $request->name,
        "description" => $request->description,
        "logo" => $request->logo,
        "contact" => $request->contact
    ], [
        "id" => $request->id
    ]);

} else {

    $project_id = $database->insert("projects", [
        "name" => $request->name,
        "description" => $request->description,
        "logo" => $request->logo,
        "contact" => $request->contact
    ]);

}


echo json_encode(array("id" => $project_id));