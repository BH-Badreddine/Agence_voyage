<?php 
   include "init.php";
   session_start();
   if(isset($_SESSION['clientId'])) {
      if(isset($_POST['publier'])) {
         if(isset($_GET['idH'])) {
            $idH = $_GET['idH'];
            $idCli = $_SESSION['clientId'];
            $evaluation = $_POST['eval'];
            $note = $_POST['note'];
            $comment = stripAccents(trim($_POST['comment']));
            $datePub = date("Y-m-d");
            $requete = "INSERT INTO avis(evaluation,note,commentaire,date_publication,id_cli,id_hotel) VALUES('$evaluation','$note',:comment,'$datePub','$idCli','$idH')";
            $sql = $connexion->prepare($requete);
            $sql->bindParam(":comment",$comment);
            $sql->execute();
            header("Location: consulterHotel.php?id=$idH&&action=listeHPV");
         }
      }
   }
   else {
      rediriger();
   }
?>