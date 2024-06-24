 

<?php ob_start();
$pageTitle = "Reservation vol";
   include "init.php";
?>
  <link rel="stylesheet" href="CSS/styleBB.css">
</head>
  <?php  session_start();
  if(isset($_SESSION['clientId'])) { 
     $idcli = $_SESSION['clientId'];
     ?>
   <body class="vol">
   <?php include $templates."navbarClient.php";  ?>

    <div class="container-fluid AirLogo text-center">
       <img src="IMAGES/AirAlgérielogo.png" alt="air algérie" height="100%" width="60%">
    </div>
    <div class="error container text-center mt-2">

    </div>
    <div class="alert alert-info text-center mx-auto " style="width:50%; ">
        <p class="display-6">Vous devez réserver en utilisant vos propres coordonées !</p>
      </div>
    <div class="container volForm">
      <h1 class="title text-center">Formulaire résevation billet d'avion</h1>

      <form autocomplete="off" method="post" action="reserverVol.php">
        <div class="mb-2">
          <label for="civilité" class="form-label">Civilité</label>
          <select name="civ" id="civilité" class="form-select">
               <option value="Mr" selected >Mr</option>
               <option value="Mme">Mme</option>
               <option value="Mlle">Mlle</option>
          </select>
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="nom" class="form-label text-center">Nom</label>
          <input required name="nom" type="text" class="form-control pad" id="nom" placeholder="Entrer nom" value="<?php echo @$_POST['nom'];?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="prenom" class="form-label">Prenom</label>
          <input required name="prenom" type="text" class="form-control pad" id="prenom" placeholder="Entrer prenom" value="<?php echo @$_POST['prenom'];?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="tel" class="form-label">Téléphone</label>
          <i class="fa-solid fa-phone insideInputTel"></i>
          <input name="tel" type="tél" class="form-control" placeholder="Entrer num tél" id="tel" value="<?php echo @$_POST['tel'];?>" >
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="email" class="form-label">Email</label>
          <i class="fa-solid fa-envelope insideInputEmail"></i>
          <input required name="email" type="email" class="form-control" id="email" placeholder="Entrer adresse email" value="<?php echo @$_POST['email'];?>" >
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="villeD" class="form-label">Ville de départ</label>
          <input required name="villeD" type="text" class="form-control pad" id="villeD" placeholder="Entrer ville départ" value="<?php echo @$_POST['villeD'];?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="dest" class="form-label">Destination</label>
          <input required name="dest" type="text" class="form-control pad" id="dest" placeholder="Entrer destination" value="<?php echo @$_POST['dest'];?>" >
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="dateD" class="form-label">Date de départ</label>
          <input required name="dateD" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date départ" id="dateD" value="<?php echo @$_POST['dateD'];?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="dateR" class="form-label">Date de retour</label>
          <input required name="dateR" type="date" min="<?php echo @$_POST['dateD']; ?>" class="form-control pad" placeholder="Entrer date retour" id="dateR" value="<?php echo @$_POST['dateR']; ?>" >
        </div> 
        <div class="mb-2">
          <label for="classe" class="form-label">Classe</label>
          <select name="classe" id="classe" class="form-select">
               <option value="Economic" selected >Economic</option>
               <option value="Business">Business</option>
               <option value="1st class">1st class</option>
          </select>
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="nbPass" class="form-label">Nombre passagers</label>
          <input required name="nbPass" type="number" min="1" max="5" class="form-control pad" placeholder="Entrer nombre passagers" id="nbPass"value="<?php echo @$_POST['nbPass']; ?>">
        </div>
        <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
          <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Valider</button>
        </div>

      </form>
    </div>
<?php  include $templates."footer.php";
  if(isset($_POST['valider'])) {  
   $civ = $_POST['civ'];
   $nom = stripAccents(trim($_POST['nom']));
   $prenom = stripAccents(trim(($_POST['prenom'])));
   $tel = $_POST['tel'];
   $email = $_POST['email'];
   $villeD = transform(stripAccents($_POST['villeD']));
   $dest = transform(stripAccents($_POST['dest']));
   $dateD = $_POST['dateD'];
   $dateR = $_POST['dateR'];
   $classe = $_POST['classe'];
   $nbPass = $_POST['nbPass'];
   $date_enreg_rés = strtotime(date("d-m-Y H:i:s"));

   //validation de date --------> si(date retour <= date depart) alors c'est une erreur
   if(strtotime($dateD) >= strtotime($dateR)  ) {  ?>
      <script>
      $("div.error").html("<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Veuillez entrer une date de retour valide</p>");
    </script>
     <?php  }
  else { 
    //ajouter les données dans la table réservation vol
     $requete="INSERT INTO reservation_vol(ville_depart,destination,date_depart,date_retour,classe,nbr_passagers,statut,date_enreg_res,id_cli) VALUES (:villeD,:dest,:dateD,:dateR,:classe,:nbPass,'en attente','$date_enreg_rés','$idcli')";
     $sql = $connexion->prepare($requete);
     $sql->bindParam(":villeD",$villeD);
     $sql->bindParam(":dest",$dest);
     $sql->bindParam(":dateD",$dateD);
     $sql->bindParam(":dateR",$dateR);
     $sql->bindParam(":classe",$classe);
     $sql->bindParam(":nbPass",$nbPass);
     $sql->execute();
     
     header("Location: poursuivreRes.php?civilité=$civ&&nom=$nom&&prenom=$prenom");

     
  }

}

 }
  else {
   rediriger();
  }
  ob_end_flush();
  ?> 