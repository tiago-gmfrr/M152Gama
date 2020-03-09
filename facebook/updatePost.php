<?php
require_once("dbConnection.php");

$idMedia = filter_input(INPUT_GET, "idMedia", FILTER_SANITIZE_STRING);
$submit =  filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);
$commentEntered = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);

$idPost; //Set on the previous page, aka facebook.php
if ($submit == "Update") {
    UpdatePostCommentaireById($idPost, $commentEntered);
    
    header("Location: facebook.php");
}
$post = getPostById($idPost);
$allMedias = GetAllMedia();
$nbMedias = count($allMedias);
$nbMediaInPost = 0;
$commentaire = $post["commentaire"];


?>

<form action="facebook.php?idPost=<?= $idPost ?>" method='POST'>
    <input type="text" name="comment" value="<?= $commentaire ?>" />
    
<?php


echo "<hr/>";
if ($commentaire != "") {

    $nbMediaInPost += 1;
}
for ($i = 0; $i < $nbMedias; $i++) {

    if ($allMedias[$i]["idPost"] == $idPost) {
        if ($idMedia == $allMedias[$i]["idMedia"]) {

            if ($type[0] == "image") {
                $src = "assets/img/";
            } else if ($type[0] == "video") {
                $src = "assets/video/";
            } else if ($type[0] == "audio") {
                $src = "assets/audio/";
            }

            DeleteMedia($allMedias[$i]["idMedia"]);
            unlink($src . $allMedias[$i]["nomMedia"]);
            header("Location: facebook.php?idPost=$idPost");
        }

        $nbMediaInPost += 1;
        $typeMedia = $allMedias[$i]["typeMedia"];
        $type = explode('/', $typeMedia);

        if ($type[0] == "image") {
            echo '<img src="assets/img/' . $allMedias[$i]["nomMedia"] . '" width="500">';
        } else if ($type[0] == "video") {
            echo '<video src="assets/video/' . $allMedias[$i]["nomMedia"] . '" controls loop autoplay width="500"></video>';
        } else if ($type[0] == "audio") {
            echo '<audio src="assets/audio/' . $allMedias[$i]["nomMedia"] . '" controls width="500"></audio>';
        }




        echo '<a href="facebook.php?idPost=' . $idPost .  '&idMedia=' . $allMedias[$i]["idMedia"] . '" class="btn btn-primary"> Delete </a>';
        echo "<br/>";
    }
}
?>
<input type="submit" name="submit" value="Update" class="btn btn-primary" />
</form>
<?php
//echo $nbMediaInPost;
if ($nbMediaInPost == 0) {
    header("Location: deletePost.php?idPost=$idPost");
}

//DeletePost($idPost);
