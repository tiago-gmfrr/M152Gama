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

///Obtenir tous les utilisateurs
function getAllUsers()
{
        $db = connectDb();
        $sql = "SELECT idUser, Nom, Prenom, idVoiture "
                . "FROM Users "
                . "ORDER BY Nom ASC";
        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
}
///Obtenir tous les users avec leur voiture
/*function getAllUsersWithVoitures()
{
        $db = connectDb();
        $sql = "SELECT Users.idUser, Nom, Prenom, marque, modele "
                . "FROM Users, Voitures "
                . "WHERE Users.idUser = Voitures.IdUser";
        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
}*/

function getAllVoitures()
{
        $db = connectDb();
        $sql = "SELECT idVoiture, marque, modele "
                . "FROM Voitures "
                . "ORDER BY marque ASC";
        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
}

///Obtenir l'ID d'un user à l'aide de son nom et prenom
///$Nom : nom de l'utilisateur
///$Prenom : prenom de l'utilisateur
function getUserIdByName($Nom, $Prenom)
{
        $db = connectDb();
        $sql = "SELECT idUser "
                . "FROM Users "
                . "WHERE Nom = :Nom AND Prenom = :Prenom";
        $request = $db->prepare($sql);
        $request->execute(array(
                "Nom" => $Nom,
                "Prenom" => $Prenom,
        ));
        return $request->fetch(PDO::FETCH_ASSOC);
}

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

function getVoitureByID($idVoiture)
{
        $db = connectDb();
        $sql = "SELECT marque, modele "
                . "FROM Voitures "
                . "WHERE idVoiture = :idVoiture";
        $request = $db->prepare($sql);
        $request->execute(array(
                "idVoiture" => $idVoiture,
        ));
        return $request->fetch(PDO::FETCH_ASSOC);
}
/*
function getVoitureIdByUserID($idUser)
{
        $db = connectDb();
        $sql = "SELECT marque, modele "
                . "FROM Voitures "
                . "WHERE idUser = :idUser";
        $request = $db->prepare($sql);
        $request->execute(array(
                "idUser" => $idUser,
        ));
        return $request->fetch(PDO::FETCH_ASSOC);
}*/

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

///Ajoute un utilisateur
///$Nom : nom du nouveau utilisateur
///$Prenom : prenom du nouveau utilisateur
function AddUser($Nom, $Prenom)
{
        $db = connectDb();
        $sql = "INSERT INTO Users (Nom, Prenom) "
                . "Values (:Nom, :Prenom)";
        $request = $db->prepare($sql);
        if ($request->execute(array(
                'Nom' => $Nom,
                'Prenom' => $Prenom,
        ))) {
                return $db->lastInsertID();
        } else {
                return NULL;
        }
}

///Ajoute une voiture
///$idUser : id de l'utilisateur correspondant (fk)
///$marque : marque de la voiture
///$modele : modele de la voiture
function AddVoiture($marque, $modele)
{
        $db = connectDb();
        $sql = "INSERT INTO Voitures (marque, modele) "
                . "Values (:marque, :modele)";
        $request = $db->prepare($sql);
        if ($request->execute(array(
                'marque' => $marque,
                'modele' => $modele,
        ))) {
                return $db->lastInsertID();
        } else {
                return NULL;
        }
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
