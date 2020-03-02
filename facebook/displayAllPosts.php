<?php

require_once("dbConnection.php");
$allPosts = getAllPosts();
$allMedias = getAllMedia();
$nbPosts = count($allPosts);
$nbMedias = count($allMedias);

for ($i=0; $i < $nbPosts; $i++) { 
    # code...

    echo $allPosts[$i]["commentaire"];
    echo "<br>";
    for ($j=0; $j < $nbMedias; $j++) { 
        if ($allPosts[$i]["idPost"] == $allMedias[$j]["idPost"]) {

            $typeMedia = $allMedias[$j]["typeMedia"];
            $type = explode('/', $typeMedia);

            if ($type[0] == "image") {
                echo '<img src="assets/img/'. $allMedias[$j]["nomMedia"] . '" width="500">';
            }else if ($type[0] == "video") {
                /*echo '<video controls loop autoplay width="500">'.
                    '<source src="assets/video/'. $allMedias[$j]["nomMedia"] .'" type="video/mp4>' .
                    '</video>';*/

                echo '<video src="assets/video/'. $allMedias[$j]["nomMedia"] . '" controls loop autoplay width="500"></video>';
            }else if ($type[0] == "audio") {
                echo '<audio src="assets/audio/'. $allMedias[$j]["nomMedia"] . '" controls width="500"></audio>';
            }
            
            echo "<br>";
            
        }
    }
    echo '<a href="deletePost.php?idPost=' . $allPosts[$i]["idPost"].  '" class="btn btn-primary"> Delete </a>';
    echo '<a href="facebook.php?idPost=' . $allPosts[$i]["idPost"].  '" class="btn btn-primary"> Update </a>';
    echo "<br>";
    echo "<hr>";
}