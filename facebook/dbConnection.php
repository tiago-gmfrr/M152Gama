<?php

/*
Author : Gama Tiago
Class : I-FA.P3A
Version : V1.0
Desc : Script containing all database queries and connections, transactions are used when necessary
*/


///Connection à la base de données
function connectDB()
{
        $dbServer = "127.0.0.1";
        $dbName = "M152";
        $dbUser = "root";
        $dbPwd = "Super";

        static $bdd = null;

        if ($bdd === null) {
                $bdd = new PDO("mysql:host=$dbServer;dbname=$dbName;charset=utf8", $dbUser, $dbPwd);
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $bdd;
}

///Obtient tous les fichiers media
function getAllMedia()
{
        $db = connectDb();
        $sql = "SELECT idMedia, typeMedia, nomMedia, creationDate, modificationDate, idPost "
                . "FROM Media "
                . "ORDER BY idPost ASC";
        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
}

///Obtient tous les Posts
function getAllPosts()
{
        $db = connectDb();
        $sql = "SELECT idPost, commentaire, creationDate, modificationDate "
                . "FROM Post "
                . "ORDER BY creationDate DESC";
        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
}

///Obtenir l'ID d'un Post à l'aide du commentaire correspondant et la date de création
///$commentaire : Commentaire correspondant
///$creationDate : Date de creation
function getPostIdByCommentAndDate($commentaire, $creationDate)
{
        $db = connectDb();
        $sql = "SELECT idPost "
                . "FROM Post "
                . "WHERE commentaire = :commentaire AND creationDate = :creationDate";
        $request = $db->prepare($sql);
        $request->execute(array(
                "commentaire" => $commentaire,
                "creationDate" => $creationDate,
        ));
        return $request->fetch(PDO::FETCH_ASSOC);
}

///Obtenir un Post  a travers son id
///$idPost : id correspondant
function GetPostById($idPost)
{
        $db = connectDb();
        $sql = "SELECT * "
                . "FROM Post "
                . "WHERE idPost = :idPost";
        $request = $db->prepare($sql);
        $request->execute(array(
                "idPost" => $idPost,
        ));
        return $request->fetch(PDO::FETCH_ASSOC);
}

///Changer le commentaire d'un post precis
///$idPost : id correspondant
///$commentaire : nouveau commentaire
function UpdatePostCommentaireById($idPost, $commentaire)
{
        $db = connectDb();
        $sql = "UPDATE Post "
                . "SET commentaire = :commentaire "
                . "WHERE idPost = :idPost";
        $request = $db->prepare($sql);
        $request->execute(array(
                "idPost" => $idPost,
                "commentaire" => $commentaire,
        ));
}

///Ajoute un post
///$Nom : nom du nouveau utilisateur
///$Prenom : prenom du nouveau utilisateur
function AddPost($commentaire, $creationDate, $modificationDate)
{

        try {
                $id = -1;
                $db = connectDb();
                $db->beginTransaction();
                $sql = "INSERT INTO Post (commentaire, creationDate, modificationDate) "
                        . "Values (:commentaire, :creationDate, :modificationDate)";
                $request = $db->prepare($sql);
                $request->execute(array(
                        'commentaire' => $commentaire,
                        'creationDate' => $creationDate,
                        'modificationDate' => $modificationDate,
                ));
                $id = $db->lastInsertID();
                $db->commit();
                return $id;
        } catch (Exception $e) {
                //An exception has occured, which means that one of our database queries
                //failed.
                //Print out the error message.
                echo $e->getMessage();
                //Rollback the transaction.
                $db->rollBack();
        }
}

///Ajoute un fichier Media
///$typeMedia : type de fichier, exemple : png / jpg 
///$nomMedia : nom du fichier media
///$creationDate : date de  création
///$modificationDate : date de derniere modification
///$idPost : id du Post correspondant (fk)
function AddMedia($typeMedia, $nomMedia, $creationDate, $modificationDate, $idPost)
{
        try {
                $id = -1;
                $db = connectDb();
                $db->beginTransaction();

                $sql = "INSERT INTO Media (typeMedia, nomMedia, creationDate, modificationDate, idPost) "
                        . "Values (:typeMedia, :nomMedia, :creationDate, :modificationDate, :idPost)";
                $request = $db->prepare($sql);
                $request->execute(array(
                        'typeMedia' => $typeMedia,
                        'nomMedia' => $nomMedia,
                        'creationDate' => $creationDate,
                        'modificationDate' => $modificationDate,
                        'idPost' => $idPost,
                ));
                $id = $db->lastInsertID();
                $db->commit();
                return $id;
        } catch (Exception $e) {
                //An exception has occured, which means that one of our database queries
                //failed.
                //Print out the error message.
                echo $e->getMessage();
                //Rollback the transaction.
                $db->rollBack();
        }
}

///Efface une Media
///$idMedia : id de la media à effacer
function DeleteMedia($idMedia)
{
        try {
                $db = connectDb();
                $db->beginTransaction();

                $sql = "DELETE FROM Media WHERE idMedia = :idMedia";
                $request = $db->prepare($sql);
                $request->execute(array('idMedia' => $idMedia));
                $db->commit();


        } catch (Exception $e) {
                //An exception has occured, which means that one of our database queries
                //failed.
                //Print out the error message.
                echo $e->getMessage();
                //Rollback the transaction.
                $db->rollBack();
        }
}
///Efface un Post
///$idMedia : id du post à effacer
function DeletePost($idPost)
{
        try {
                $db = connectDb();
                $db->beginTransaction();

                $sql = "DELETE FROM Post WHERE idPost = :idPost";
                $request = $db->prepare($sql);
                $request->execute(array('idPost' => $idPost));
                $db->commit();


        } catch (Exception $e) {
                //An exception has occured, which means that one of our database queries
                //failed.
                //Print out the error message.
                echo $e->getMessage();
                //Rollback the transaction.
                $db->rollBack();
        }
}


