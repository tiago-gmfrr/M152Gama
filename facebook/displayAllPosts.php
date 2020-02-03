<?php

require_once("dbConnection.php");
$allPosts = getAllPosts();
$allMedias = getAllMedia();

foreach ($allPosts as $post) {

    foreach ($post as $key => $value) {
        echo "$key : $value";
        if ($key == "idPost") {
            $idPost = $value;
        }

        foreach ($allMedias as $media) {
            foreach ($media as $key2 => $value2) {
                if ($key == "nomMedia") {
                    $nomMedia = $value;
                }

                if ($key2 == "idPost" && $value2==$idPost) {

                    //echo "<img src='assets/img/150x150.gif'>";
                }
            }
        }

        echo "<br>";
    }
    echo "<hr>";
}