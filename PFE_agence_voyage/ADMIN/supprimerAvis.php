<?php
session_start();
include "init.php";
if(isset($_SESSION['admin'])) { 

        if(isset($_GET['id_avis'])) {
            $idavis = $_GET['id_avis'];
            $requete = "DELETE FROM avis WHERE id_avis='$idavis' ";
            $sql = $connexion->prepare($requete);
            $sql->execute();
            header("Location: accueilAdmin.php?page=liste_avis");
        }
    
}
