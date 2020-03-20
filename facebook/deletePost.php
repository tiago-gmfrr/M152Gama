<?php
/*
Author : Gama Tiago
Class : I-FA.P3A
Version : V1.0
Desc : Script removes all instances of a post from the databse and local files 
*/

require_once "dbConnection.php";

//idPost sent from the delete button
$idPost = filter_input(INPUT_GET, "idPost", FILTER_SANITIZE_STRING);
$allMedias = getAllMedia();
$nbMedias = count($allMedias);


//First remove all associated medias 
for ($i=0; $i < $nbMedias; $i++) { 
    
    if ($allMedias[$i]["idPost"] == $idPost) {
        
        DeleteMedia($allMedias[$i]["idMedia"]);

        $typeMedia = $allMedias[$i]["typeMedia"];
        $type = explode('/', $typeMedia);
        
        if ($type[0] == "image") {
            $src = "assets/img/";
        }else if ($type[0] == "video") {
            $src = "assets/video/";
        }else if ($type[0] == "audio") {
            $src = "assets/audio/";
        }
        //Unlink the media from the local files
        unlink($src . $allMedias[$i]["nomMedia"]);        
    }
}

//And finally delete the post from the database
DeletePost($idPost);

//Refresh the main page
header("location: facebook.php");
