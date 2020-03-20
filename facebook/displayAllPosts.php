<?php

/*
Author : Gama Tiago
Class : I-FA.P3A
Version : V1.0
Desc : Script displays all posts and the associated medias  
*/

require_once("dbConnection.php");

//Gathers all medias and posts + counts them
$allPosts = getAllPosts();
$allMedias = getAllMedia();
$nbPosts = count($allPosts);
$nbMedias = count($allMedias);

//Loops through every post
for ($i=0; $i < $nbPosts; $i++) { 
   
    //Displays the comment associated to the post
    echo "<h4>". $allPosts[$i]["commentaire"] . "</h4>";
    echo "<br>";
    //Loops through every media
    for ($j=0; $j < $nbMedias; $j++) { 

        //If the media is associated to the post display it
        if ($allPosts[$i]["idPost"] == $allMedias[$j]["idPost"]) {

            $typeMedia = $allMedias[$j]["typeMedia"];
            $type = explode('/', $typeMedia);

            //Verify the type of media beforehand
            if ($type[0] == "image") {
                echo '<img src="assets/img/'. $allMedias[$j]["nomMedia"] . '" width="500">';
            }else if ($type[0] == "video") {
                echo '<video src="assets/video/'. $allMedias[$j]["nomMedia"] . '" controls loop autoplay width="500"></video>';
            }else if ($type[0] == "audio") {
                echo '<audio src="assets/audio/'. $allMedias[$j]["nomMedia"] . '" controls width="500"></audio>';
            }
            
            echo "<br>";
            
        }
    }
    //At the end of each posts add the Update and Delete buttons
    echo '<a href="deletePost.php?idPost=' . $allPosts[$i]["idPost"].  '" class="btn btn-primary"> Delete </a>';
    echo '<a href="facebook.php?idPost=' . $allPosts[$i]["idPost"].  '" class="btn btn-primary"> Update </a>';
    echo "<br>";
    echo "<hr>";
}