<?php
require_once 'medoo.min.php';

$database = new medoo();

if(isset($_FILES['file'])){
    $errors= array();
    $file_name = $_FILES['file']['name'];
    $file_size =$_FILES['file']['size'];
    $file_tmp =$_FILES['file']['tmp_name'];
    $file_type=$_FILES['file']['type'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $extensions = array("jpeg","jpg","png");
    if(in_array($file_ext,$extensions )=== false){
        $errors[]="image extension not allowed, please choose a JPEG or PNG file.";
    }
    if($file_size > 2097152){
        $errors[]='File size cannot exceed 2 MB';
    }
    $target_file_name = time() . "." . $file_ext;
    $project_id = 0;
    if(empty($errors)==true){
        if(isset($_POST["project_id"]) and $_POST["project_id"] != '0'){
            $project_id = $_POST["project_id"];
            $target_file_name = $project_id . "." . $file_ext;
        }
        move_uploaded_file($file_tmp,"../assets/images/projects/" . $target_file_name);

        // save logo in project
        if($project_id > 0){
            $database->update("projects", [
                "logo" => $target_file_name
            ], [
                "id" => $project_id
            ]);
        }

        echo $target_file_name;
    }else{
        print_r($errors);
    }
}
else{
    $errors= array();
    $errors[]="No image found";
    print_r($errors);
}