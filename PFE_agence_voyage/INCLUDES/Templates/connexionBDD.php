<?php 
  $dsn = "mysql:host=localhost;dbname=agencevoyage";
  $USER = "root";
  $PASS = "";

  try { 
      $connexion = new PDO($dsn,$USER,$PASS);
      $connexion->exec("SET NAMES utf8"); //définir l'encodage des caractères(lettres accentuées...)
      //echo "connexion successful";
  }
  catch(PDOException $e) {
echo "Echec".$e->getMessage();
  }
?>