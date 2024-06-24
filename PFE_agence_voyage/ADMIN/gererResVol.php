<?php  ob_start();
$pageTitle = "Résrver vol";
include "init.php"; ?>
  <link rel="stylesheet" href="CSS/styleB.css">
</head>
<body>
 <?php  session_start(); 

if(isset($_SESSION['clientId'])) {
  if(isset($_GET['action'])) {
    $action = $_GET['action'];
    if($action === "supprimer") {
      //Vérifier si la réservation à supprimer est une réservation propre au client
     $idRes = $_GET['id']; 
     $idcli = $_SESSION['clientId'];
     $query= "SELECT id_Res_vol FROM reservation_vol WHERE id_cli='$idcli'";
     $SQL = $connexion->prepare($query);
     $SQL->execute();
     if($SQL->rowCount() > 0 ) {
       $result = $SQL->fetchAll();//$result contient tous les id de réservations vol du client
       $found = false;
       foreach($result as $row) {
         if($row['id_Res_vol'] == $idRes) {//la réservation dont le client veut supprimer fait partie de ses réservations
           $found= true;
         }
       }
       if($found) {
        $requete = "DELETE FROM reservation_vol WHERE id_Res_vol='$idRes' ";
        $sql = $connexion->prepare($requete);
        $sql->execute();
        header("Location: ../mesReservations.php");
       }
       else {
         header("Location: ../accueil.php");
       }
      }else {
        header("Location: ../accueil.php");
      }
    }
  }
 }

 if(isset($_SESSION['admin'])) { 
  
  if(isset($_GET['action'])) {
    $action = $_GET['action'];

    if($action === "supprimer" && isset($_GET['id'])) {
        $idRes = $_GET['id']; 
        $requete = "DELETE FROM reservation_vol WHERE id_Res_vol='$idRes' ";
        $sql = $connexion->prepare($requete);
        $sql->execute();
        header("Location: accueilAdmin.php?page=liste_res_vol");
    }


    if($action === "supprimer expiré") {
      $difference = strtotime(date("d-m-Y H:i:s")) - 172800;//date courante en timestamp - 48heures convertis en secondes [le délais à ne pas dépasser est 48h]
      $requete = "DELETE FROM reservation_vol WHERE date_enreg_res < $difference and statut = 'en attente'";
      $sql = $connexion->prepare($requete);
      $sql->execute(); ?>
          <script>
            alert(<?php echo $sql->rowCount();?>+" réservations vol supprimées");
          </script> 

     <?php
        header("refresh:1,url=accueilAdmin.php?page=liste_res_vol");
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($action === "ajouter") {
          //Le client n'existe pas, donc on doit l'ajouter dans la table client puis ajouter la réservation vol
          include $templates . "navbarAdmin.php"; ?>
  <div class="error container text-center mt-2">

  </div>
  
  <div class="container volForm">
      <h1 class="title text-center">Formulaire Ajouter résevation vol</h1>

      <form autocomplete="off" method="post" action="gererResVol.php?action=ajouter">
        <fieldset> <legend class="text-center mt-2 mb-1">Coordonées client</legend>
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
          <label for="email" class="form-label">Email</label>
          <i class="fa-solid fa-envelope insideInputEmail"></i>
          <input required name="email" type="email" class="form-control" id="email" placeholder="Entrer adresse email" value="<?php echo @$_POST['email'];?>" >
        </div>
       </fieldset>
    <hr>
       <fieldset> <legend class="text-center mt-2 mb-1">Info réservation vol</legend>
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
          <select name="classe" id="classe" class="form-select" value="Business">
               <option value="Economic">Economic</option>
               <option value="Business">Business</option>
               <option value="1st class">1st class</option>
          </select>
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="nbPass" class="form-label">Nombre passagers</label>
          <input required name="nbPass" type="number" min="1" max="5" class="form-control pad" placeholder="Entrer nombre passagers" id="nbPass"value="<?php echo @$_POST['nbPass']; ?>">
        </div>
        <div class="mb-2">
          <label for="stat" class="form-label">Statut</label>
          <select name="statut" id="stat" class="form-select">
               <option value="en attente" selected >en attente</option>
               <option value="confirme">confirme</option>
          </select>
        </div>
       </fieldset>

        <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
          <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
        </div>

      </form>
    </div>
       <?php include $templates . "footer.php";
        if(isset($_POST['valider'])) {  
          $civ = $_POST['civ'];
          $nom = trim($_POST['nom']);
          $prenom = trim($_POST['prenom']);
          $email = $_POST['email'];
          $villeD = transform(stripAccents($_POST['villeD']));
          $dest = transform(stripAccents($_POST['dest']));
          $dateD = $_POST['dateD'];
          $dateR = $_POST['dateR'];
          $classe = $_POST['classe'];
          $nbPass = $_POST['nbPass'];
          $statut = $_POST['statut'];
          $date_enreg_rés = strtotime(date("d-m-Y H:i:s"));
       
          //validation de date --------> si(date retour <= date depart) alors c'est une erreur
          if(strtotime($dateD) >= strtotime($dateR)  ) {  ?>
             <script>
                $("div.error").html("<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Veuillez entrer une date de retour valide</p>");
             </script>
            <?php  }
            else {  //Ajouter les données du client
                $requete1 = "INSERT INTO client(civilite,nom_cli,prenom_cli,email_cli) VALUES (:civ,:nom,:prenom,:email)";
                $sql1 = $connexion->prepare($requete1);
                $sql1->bindParam(":civ",$civ);
                $sql1->bindParam(":nom",$nom);
                $sql1->bindParam(":prenom",$prenom);
                $sql1->bindParam(":email",$email);
                $sql1->execute();
             //Récupérer id du client ajouté
               $requete2 = "SELECT id_cli FROM client WHERE email_cli='$email'";
               $sql2 = $connexion->prepare($requete2);
               $sql2->execute();
               if($sql2->rowCount() > 0) {
                 $result2 = $sql2->fetch();
                 $idcli = $result2['id_cli'];
               }
             //Ajouter les données de réservation vol
             $requete3 = "INSERT INTO reservation_vol(ville_depart,destination,date_depart,date_retour,classe,nbr_passagers,statut,date_enreg_res,id_cli) VALUES (:villeD,:dest,:dateD,:dateR,:classe,:nbPass,'$statut','$date_enreg_rés','$idcli')";
             $sql3 = $connexion->prepare($requete3);
                $sql3->bindParam(":villeD",$villeD);
                $sql3->bindParam(":dest",$dest);
                $sql3->bindParam(":dateD",$dateD);
                $sql3->bindParam(":dateR",$dateR);
                $sql3->bindParam(":classe",$classe);
                $sql3->bindParam(":nbPass",$nbPass);
                $sql3->execute(); ?>
                <script>
                    alert(<?php echo $sql3->rowCount();?>+" réservation vol ajoutée");
                </script>
         <?php  header("refresh:1,url=accueilAdmin.php?page=liste_res_vol");
            }
          }
        } 
        
          
       
///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

if($action === "modifier" && isset($_GET['id'])) {
          include $templates . "navbarAdmin.php"; 
          $idRes = $_GET['id']; 
          $requete1 = "SELECT * FROM reservation_vol WHERE id_Res_vol='$idRes'";
          $sql1 = $connexion->prepare($requete1);
          $sql1->execute();
          if($sql1->rowCount() > 0) {
            $result1 = $sql1->fetch();
          ?>
          <div class="error container text-center mt-2">

          </div>
  <div class="container volForm">
      <h1 class="title text-center">Formulaire Modifier résevation vol</h1>

      <form autocomplete="off" method="post" action="gererResVol.php?action=modifier&&id=<?php echo $idRes; ?>">
        
        <div class="mb-2" style="position:relative;">
          <label for="villeD" class="form-label">Ville de départ</label>
          <input required name="villeD" type="text" class="form-control pad" id="villeD" placeholder="Entrer ville départ" value="<?php echo $result1['ville_depart']; ?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="dest" class="form-label">Destination</label>
          <input required name="dest" type="text" class="form-control pad" id="dest" placeholder="Entrer destination" value="<?php echo $result1['destination']; ?>" >
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="dateD" class="form-label">Date de départ</label>
          <input required name="dateD" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date départ" id="dateD" value="<?php echo $result1['date_depart']; ?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="dateR" class="form-label">Date de retour</label>
          <input required name="dateR" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date retour" id="dateR" value="<?php echo $result1['date_retour'] ; ?>" >
        </div> 
        <div class="mb-2">
          <label for="classe" class="form-label">Classe</label>
          <select name="classe" id="classe" class="form-select">
               <option value="Economic" selected>Economic</option>
               <option value="Business">Business</option>
               <option value="1st class">1st class</option>
          </select>
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="nbPass" class="form-label">Nombre passagers</label>
          <input required name="nbPass" type="number" min="1" max="5" class="form-control pad" placeholder="Entrer nombre passagers" id="nbPass"value="<?php echo $result1['nbr_passagers']; ?>">
        </div>
        <div class="mb-2">
          <label for="stat" class="form-label">Statut</label>
          <select name="statut" id="stat" class="form-select">
               <option value="en attente" selected>en attente</option>
               <option value="confirme">confirme</option>
          </select>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
          <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
        </div>

      </form>
    </div>
        <?php  include $templates."footer.php";
          if(isset($_POST['valider'])) {
            $villeD = transform(stripAccents($_POST['villeD']));
            $dest = transform(stripAccents($_POST['dest']));
            $dateD = $_POST['dateD'];
            $dateR = $_POST['dateR'];
            $classe = $_POST['classe'];
            $nbPass = $_POST['nbPass'];
            $statut = $_POST['statut'];    
          //validation de date --------> si(date retour <= date depart) alors c'est une erreur
          if(strtotime($dateD) >= strtotime($dateR)  ) {  ?>
             <script>
             $("div.error").html("<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Veuillez entrer une date de retour valide</p>");
           </script>
            <?php  }
            else {
               //Mise à jour des données de réservation vol
               $requete2 = "UPDATE reservation_vol
                            SET ville_depart='$villeD',destination='$dest',date_depart='$dateD',date_retour='$dateR',classe='$classe',nbr_passagers='$nbPass',statut='$statut' 
                            WHERE id_Res_vol=$idRes";
              $sql2 = $connexion->prepare($requete2);
              $sql2->execute();
         ?>
          <script>
            alert(<?php echo $sql2->rowCount();?>+" réservation vol modifiée");
          </script>
     <?php  header("refresh:1,url=accueilAdmin.php?page=liste_res_vol");
     }
     }
    }
} 
 /////////////////////////////////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////////////////////

      }     
    } else {
      rediriger();
    }
   ?>


<?php include $templates . "footer.php"; 
ob_end_flush();
?>
