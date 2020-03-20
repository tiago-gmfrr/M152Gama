<?php

/*

Initial structure of the script taken from stackoverflow ( didnt't save url )
Modified by : Gama Tiago
Class : I-FA.P3A
Version : V1.0
Desc : Script displays all posts and the associated medias  
*/

require_once("dbConnection.php");

$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

// -1 is an arbitrary number used to represent somthing unset, used aswell in dcConnection.php
$idPost = -1;
// Target directory, where file will be saved
$target_dir = "./assets/img/";
// Count # of uploaded files in array
$files = array_filter($_FILES['fileToUpload']['name']);
$total = count(array_filter($_FILES['fileToUpload']['name']));

if ($total == 0) {
    header("location: post.php");
    exit;
}
// Loop through each file
for ($i = 0; $i < $total; $i++) {

    $_FILES['fileToUpload']['name'][$i] = time() . "_" . $_FILES['fileToUpload']['name'][$i];
    //Get the temp file path
    $tmpFilePath = $_FILES['fileToUpload']['tmp_name'][$i];
    $fileType = $_FILES['fileToUpload']["type"][$i];
    $fileName = $_FILES['fileToUpload']["name"][$i];

    //Make sure we have a file path
    if ($tmpFilePath != "") {
        //Setup our new file path
        $type = explode('/', $fileType);

        if ($type[0] == "image") {
            $target_dir = "./assets/img/";
        }else if ($type[0] == "video") {
            $target_dir = "./assets/video/";
        }else if ($type[0] == "audio") {
            $target_dir = "./assets/audio/";
        }

        $newFilePath = $target_dir . $_FILES['fileToUpload']['name'][$i];

        //Upload the file into the temp dir
        
        if ($type[0] == "image" || $type[0] == "audio"||$type[0] == "video") {

            if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                echo "The file " . basename($_FILES['fileToUpload']["name"][$i]) . " has been uploaded. </br>";

                $currentDate = date('Y-m-d H:i:s');
                //if a Posts has already been created
                if ($idPost == -1) {
                    $idPost = AddPost($comment, $currentDate, $currentDate);
                }



                AddMedia($fileType, $fileName, $currentDate, $currentDate, $idPost);

                header("location: facebook.php");
            } else {
                echo "There was an error uploading your file";
            }
        } else {
            echo "The media is notone of the accepted types, please only use images, videos  or audios";
        }
    }
}