<?php   
$pageTitle = "Poursuivre Reservation";
include "init.php"; ?>  
    <link rel="stylesheet" href="CSS/styleBB.css">
  </head>
  <body>
 <?php session_start();
  if(isset($_SESSION['clientId'])) {
    include $templates."navbarClient.php"; 
    $idCli = $_SESSION['clientId'];
    $civ = $_GET['civilité'];
    $nom = $_GET['nom'];
    $prenom = $_GET['prenom'];
    ?>
    <h1 class="title text-center">Finaliser votre réservation</h1>
    <div class="container pourResCon">
        <div class="row">
            <div class="col-md-8 pourRes">
                <p>Bonjour <?php echo $civ." ".$nom." ".$prenom.", "; ?> votre demande de réservation a été enregistrée. Veuillez contacter l'agence sur <span style="font-weight:bold;">0559 627 691 </span>dans un délai de <span style="font-weight:bold;">48h </span>pour confirmer votre réservation.<br><span style="color:red; Font-weight:bold;"> (Si vous dépassez le délai de 48h, votre demande de réservation sera rejetée)<span></p>
                <p>Pour annuler vos réservations, rendez vous à <a class="btn btn-success btn-lg" href="mesReservations.php?id=<?php echo $idCli; ?>" style="margin-left:10px;">Mes reservations</a></p> 
            </div>
            <div class="col-md-4" >
                 <div class="alert alert-info pourRes">
                  <p><i class="fa-solid fa-circle-question"></i> Besoin d'aide <br>
                  cliquer <a href="accueil.php#etapesRes">ici</a> pour comprendre les étapes de réservations </p>
                 </div>
            </div>
        </div>
    </div>



  <?php 
  
}  
  else {
    rediriger();
  }

?>