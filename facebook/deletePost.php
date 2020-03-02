<?php

require_once "dbConnection.php";

$idPost = filter_input(INPUT_GET, "idPost", FILTER_SANITIZE_STRING);
$allMedias = getAllMedia();
$nbMedias = count($allMedias);



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
        unlink($src . $allMedias[$i]["nomMedia"]);        
    }
}

DeletePost($idPost);

header("location: facebook.php");
