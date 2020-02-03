<?php
require_once("dbConnection.php");

$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

// Target directory, where file will be saved
$target_dir = "./assets/img/";    
// Count # of uploaded files in array
$files = array_filter($_FILES['fileToUpload']['name']);
$total = count($_FILES['fileToUpload']['name']);
// Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {

  $_FILES['fileToUpload']['name'][$i] = time() . "_". $_FILES['fileToUpload']['name'][$i];
  //Get the temp file path
  $tmpFilePath = $_FILES['fileToUpload']['tmp_name'][$i];
  

  //Make sure we have a file path
  if ($tmpFilePath != ""){
    //Setup our new file path
    $newFilePath = $target_dir . $_FILES['fileToUpload']['name'][$i];

    //Upload the file into the temp dir
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {

        echo "The file " . basename($_FILES['fileToUpload']["name"][$i]) . " has been uploaded. </br>";

        $currentDate = date('Y-m-d H:i:s');
        $idPost = AddPost($comment, $currentDate, $currentDate);
        $fileType = $_FILES['fileToUpload']["type"][$i];
        $fileName = $_FILES['fileToUpload']["name"][$i];

        AddMedia($fileType, $fileName, $currentDate, $currentDate, $idPost);

        header("location: facebook.php");

    }else{
        echo "rip";
    }
  }
}







/*for ($i = 0; $i < $total; $i++) {

    
    $fichers['name'][$i] = time() . "_" . $fichers['name'][$i];
    $target_file = $target_dir . basename($fichers["name"][$i]);
    $uploadOk = 1;
    //$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $imageFileType = $_FILES["name"]['type'][$i];
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($fichers["tmp_name"][$i]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($fichers["tmp_name"][$i], $target_file)) {
            echo "The file " . basename($fichers["name"][$i]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}*/
