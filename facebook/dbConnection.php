<?php
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
////////////////////////////////////////////////////////////////////////
function getUserByID($idUser)
{
        $db = connectDb();
        $sql = "SELECT Nom, Prenom "
                . "FROM Users "
                . "WHERE idUser = :idUser";
        $request = $db->prepare($sql);
        $request->execute(array(
                "idUser" => $idUser,
        ));
        return $request->fetch(PDO::FETCH_ASSOC);
}


///Edite un utilisateur
///$idUser : id de l'utilisateur
///$Nom : nom de l'utilisateur
///$Prenom : prenom de l'utilisateur
function UpdateUser($idUser, $Nom, $Prenom)
{
        $db = connectDb();
        $sql = "UPDATE Users SET "
                . "Nom=:Nom, "
                . "Prenom=:Prenom "
                . "WHERE idUser=:idUser";
        $request = $db->prepare($sql);
        $request->execute(array(
                'idUser' => $idUser,
                'Nom' => $Nom,
                'Prenom' => $Prenom,
        ));
}

///Edite une voiture
///$idUser : id de l'utilisateur
///$marque : marque de la voiture
///$modele : modele de la voiture
function UpdateVoiture($idVoiture, $marque, $modele)
{
        $db = connectDb();
        $sql = "UPDATE Voitures SET "
                . "marque=:marque, "
                . "modele=:modele "
                . "WHERE idVoiture=:idVoiture";
        $request = $db->prepare($sql);
        $request->execute(array(
                'idVoiture' => $idVoiture,
                'marque' => $marque,
                'modele' => $modele,
        ));
}

///Efface un utilisateur
///$idUser : id de l'utilisateur à effacer
function DeleteUser($idUser)
{
        $db = connectDb();
        $sql = "DELETE FROM Users WHERE idUser = :idUser";
        $request = $db->prepare($sql);
        return ($request->execute(array('idUser' => $idUser)));
}

///Efface une voiture par rapport au utilisateur correspodant
///$idUser : id de l'utilisateur correspodant
function DeleteVoiture($idVoiture)
{
        $db = connectDb();
        $sql = "DELETE FROM Voitures WHERE idVoiture = :idVoiture";
        $request = $db->prepare($sql);
        return ($request->execute(array('idVoiture' => $idVoiture)));
}

///Efface un utilisateur et efface la voiture correspodante
///$idUser : id de l'utilisateur à effacer
/*function DeleteUserAndVoiture($idUser){        
        DeleteVoiture($idUser);
        DeleteUser($idUser);
}*/
