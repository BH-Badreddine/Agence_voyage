<?php 
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
     $query= "SELECT id_Res_offre FROM reservation_offre WHERE id_cli='$idcli'";
     $SQL = $connexion->prepare($query);
     $SQL->execute();
     if($SQL->rowCount() > 0 ) {
       $result = $SQL->fetchAll();//$result contient tous les id de réservations vol du client
       $found = false;
       foreach($result as $ID) {
         if($ID['id_Res_offre'] == $idRes) {
           $found= true;
         }
       }
       if($found) {
        $requete = "DELETE FROM reservation_offre WHERE id_Res_offre='$idRes' ";
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
  include $templates . "navbarAdmin.php"; 
  if(isset($_GET['action'])) {
    $action = $_GET['action'];
    if($action === "supprimer") {
        $idRes = $_GET['id']; 
        $requete = "DELETE FROM reservation_offre WHERE id_Res_offre='$idRes' ";
        $sql = $connexion->prepare($requete);
        $sql->execute();
        header("Location: accueilAdmin.php?page=liste_res_offre");
       }
     ////////////////////////////////////////////////////
     if($action === "supprimer expiré") {
      $difference = strtotime(date("d-m-Y H:i:s")) - 172800;//date courante en timestamp - 48heures convertis en secondes [le délais à ne pas dépasser est 48h]
      $requete = "DELETE FROM reservation_offre WHERE date_enreg_res < $difference and statut= 'en attente'" ;
      $sql = $connexion->prepare($requete);
      $sql->execute(); ?>
          <script>
            alert(<?php echo $sql->rowCount();?>+" réservations offre supprimées");
          </script> 

     <?php
        header("refresh:1,url=accueilAdmin.php?page=liste_res_offre");
    }

     ////////////////////////////////////////////////////
     if($action === "ajouter") {   ?>

        <div class="container volForm">
          <h1 class="title text-center">Formulaire Ajouter résevation offre</h1>
          <hr>
  
          <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Veuillez choisir le type de reservation:</label>
                    <select class="form-control my-2" name="type_res" required>
                        <option value="">-------</option>
                        <option value="hotel">Réservation hotel</option>
                        <option value="remise">Réservation remise</option>
                        <option value="omra">Réservation omra</option>
                    </select>
                    <button class="btn btn-primary">Selectionner</button>
                </div>
            </form>
          </div>
          <?php
            if (isset($_POST['type_res'])) {
              $type_res = filter_var($_POST['type_res'],FILTER_SANITIZE_STRING); 
              $hotels = getAll('hotel');
              ?>
              <hr>
              <?php 
              if ($type_res=='hotel') { ?>
                <h1 class="titleresoffre text-center">Formulaire Ajouter résevation hotel</h1>
  
                <form method="post" action="codegererresoffre.php"> 
                 <input type="hidden" name="operation" value="a">
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
                    <div class="mb-2" style="position:relative;">
                      <label for="email" class="form-label">Téléphone</label>
                      <i class="fa-solid fa-phone insideInputEmail"></i>
                      <input name="telephone" type="number" class="form-control" id="telephone" placeholder="Entrer téléphone" value="<?php echo @$_POST['telephone'];?>" >
                    </div>
                  </fieldset>
                  <hr>
                  <fieldset> <legend class="text-center mt-2 mb-1">Info réservation hotel</legend>
                    <div class="mb-2" style="position:relative;">
                      <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                      <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$_POST['nbP'];?>">
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="typeC" class="form-label">Liste des hotels</label>
                      <select name="id_hotel" id="id_hotel" class="form-select">
                        <?php 
                          foreach ($hotels as $hotel) {
                            ?>
                              <option value="<?= $hotel['id_hotel'] ?>"><?= $hotel['nom_hotel'] ?></option>
                            <?php 
                          }
                        ?>
                      </select>
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="typeC" class="form-label">Type de chambre</label>
                      <select name="typeC" id="typeC" class="form-select">
                        <option value="Simple" selected >Simple</option>
                        <option value="Double">Double</option>
                        <option value="Triple">Triple</option>
                        <option value="Quadruple">Quadruple</option>
                      </select>
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="pension" class="form-label">Pension</label>
                      <select name="pension" id="pension" class="form-select">
                        <option value="Complete" selected >Complete</option>
                        <option value="Demi pension">Demi pension</option>
                        <option value="Petit dejeuner">Petit dejeuner</option>
                        <option value="Tout inclus">Tout inclus</option>
                      </select>
                    </div>
                    <div class="mb-2" style="position:relative;">
                    <label for="dateDR" class="form-label">Date début réservation</label>
                      <input required name="dateDR" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date debut reservation" id="dateDR" value="<?php echo @$_POST['dateDR'];?>">
                    </div> 
                    <div class="mb-2" style="position:relative;">
                      <label for="dateFR" class="form-label">Date fin réservation</label>
                      <input required name="dateFR" type="date" min="<?php echo @$_POST['dateDR']; ?>" class="form-control pad" placeholder="Entrer date fin reservation" id="dateFR" value="<?php echo @$_POST['dateFR']; ?>" >
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
                    <button name="validerhotel" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                  </div>
                </form>
              </div>
                <?php
                 include $templates . "footer.php";
    
                
              
              
             }elseif ($type_res=='remise') { 
              $remises=getAll('remise');
              ?>
                <h1 class="titleresoffre text-center">Formulaire Ajouter résevation remise</h1>
  
                <form  method="post" action="codegererresoffre.php"> 
                  <input type="hidden" name="operation" value="a">
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
                    <div class="mb-2" style="position:relative;">
                      <label for="email" class="form-label">Téléphone</label>
                      <i class="fa-solid fa-phone insideInputEmail"></i>
                      <input name="telephone" type="number" class="form-control" id="telephone" placeholder="Entrer téléphone" value="<?php echo @$_POST['telephone'];?>" >
                    </div>
                  </fieldset>
                  <hr>
                  <fieldset> <legend class="text-center mt-2 mb-1">Info réservation remise</legend>
                    <div class="mb-2" style="position:relative;">
                      <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                      <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$_POST['nbP'];?>">
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="typeC" class="form-label">Liste des remises</label>
                      <select name="id_remise" id="id_remise" class="form-select">
                        <?php 
                          foreach ($remises as $remise) {
                            ?>
                              <option value="<?= $remise['id_remise'] ?>"><?= $remise['nom_remise'] ?></option>
                            <?php 
                          }
                        ?>
                      </select>
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="typeC" class="form-label">Type de chambre</label>
                      <select name="typeC" id="typeC" class="form-select">
                        <option value="Simple" selected >Simple</option>
                        <option value="Double">Double</option>
                        <option value="Triple">Triple</option>
                        <option value="Quadruple">Quadruple</option>
                      </select>
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="pension" class="form-label">Pension</label>
                      <select name="pension" id="pension" class="form-select">
                        <option value="Complete" selected >Complete</option>
                        <option value="Demi pension">Demi pension</option>
                        <option value="Petit dejeuner">Petit dejeuner</option>
                        <option value="Tout inclus">Tout inclus</option>
                      </select>
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
                    <button name="validerremise" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                  </div>
                </form>
              </div>
              <?php
                include $templates . "footer.php";
                
                ?>
              
              
              <?php 
              }else{
                $omras=getAll('omra'); 
                ?>
                <h1 class="titleresoffre text-center">Formulaire Ajouter résevation omra</h1>
                
                <form  method="post" action="codegererresoffre.php">
                  <input type="hidden" name="operation" value="a"> 
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
                    <div class="mb-2" style="position:relative;">
                      <label for="email" class="form-label">Téléphone</label>
                      <i class="fa-solid fa-phone insideInputEmail"></i>
                      <input name="telephone" type="number" class="form-control" id="telephone" placeholder="Entrer téléphone" value="<?php echo @$_POST['telephone'];?>" >
                    </div>
                  </fieldset>
                  <hr>
                  <fieldset> <legend class="text-center mt-2 mb-1">Info réservation omra</legend>
                    <div class="mb-2" style="position:relative;">
                      <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                      <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$_POST['nbP'];?>">
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="typeC" class="form-label">Liste des omras</label>
                      <select name="id_omra" id="id_omra" class="form-select">
                        <?php 
                          foreach ($omras as $omra) {
                            ?>
                              <option value="<?= $omra['id_omra'] ?>"><?= $omra['intitule'] ?></option>
                            <?php 
                          }
                        ?>
                      </select>
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="typeC" class="form-label">Type de chambre</label>
                      <select name="typeC" id="typeC" class="form-select">
                        <option value="Simple" selected >Simple</option>
                        <option value="Double">Double</option>
                        <option value="Triple">Triple</option>
                        <option value="Quadruple">Quadruple</option>
                      </select>
                    </div>
                    <div class="mb-2" style="position:relative;">
                      <label for="pension" class="form-label">Pension</label>
                      <select name="pension" id="pension" class="form-select">
                        <option value="Complete" selected >Complete</option>
                        <option value="Demi pension">Demi pension</option>
                        <option value="Petit dejeuner">Petit dejeuner</option>
                        <option value="Tout inclus">Tout inclus</option>
                      </select>
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
                    <button name="valideromra" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                  </div>
                </form>
              </div>
              <?php
                include $templates . "footer.php";
                 
                ?>
              
              
              <?php } ?>
  
  
  
              <?php }
          
  
    } 
       ////////////////////////////////////////////////////////////
      
    if($action === "modifier") {
      $type=$_GET['type'];
      $idres = $_GET['id'];
      if($type === "hotel") {
  
        $res=getByField('reservation_offre','id_Res_offre',$idres);
      
          ?>
          <div class="container volForm">
            <h1 class="title text-center">Formulaire Modifier résevation hotel</h1>
            <form method="post" action="codegererresoffre.php">
              <input type="hidden" name="operation" value="m">
              <input type="hidden" name="idres" value="<?php echo $idres; ?>">
              <div class="mb-2" style="position:relative;">
                <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$res['nbr_personnes'] ?>">
              </div>
              <div class="mb-2" >
                <label for="typeC" class="form-label">Type de chambre</label>
                <select name="typeC" id="typeC" class="form-select">
                  <option value="Simple" selected >Simple</option>
                  <option value="Double">Double</option>
                  <option value="Triple">Triple</option>
                  <option value="Quadruple">Quadruple</option>
                </select>
              </div>
              <div class="mb-2" style="position:relative;">
                <label for="pension" class="form-label">Pension</label>
                <select name="pension" id="pension" class="form-select">
                  <option value="Complete" selected >Complete</option>
                  <option value="Demi pension">Demi pension</option>
                  <option value="Petit dejeuner">Petit dejeuner</option>
                  <option value="Tout inclus">Tout inclus</option>
                </select>
              </div>
              <div class="mb-2" style="position:relative;">
                <label for="dateDR" class="form-label">Date début réservation</label>
                <input required name="dateDR" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date debut reservation" id="dateDR" value="<?php echo @$res['date_debut_res'] ?>">
              </div> 
              <div class="mb-2" style="position:relative;">
                <label for="dateFR" class="form-label">Date fin réservation</label>
                <input required name="dateFR" type="date" min="<?php echo @$_POST['dateDR']; ?>" class="form-control pad" placeholder="Entrer date fin reservation" id="dateFR" value="<?php echo @$res['date_fin_res'] ?>" >
              </div>
              <div class="mb-2">
                <label for="stat" class="form-label">Statut</label>
                <select name="statut" id="stat" class="form-select">
                  <option value="en attente" selected >en attente</option>
                  <option value="confirme">confirme</option>
                </select>
              </div>
              <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                <button name="validerhotel" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
              </div>
            </form>
          </div>
  
          <?php  include $templates."footer.php";
              
      }
          
      
      elseif($type === "remise") {
  
        $res=getByField('reservation_offre','id_Res_offre',$idres);
          ?>
          <div class="container volForm">
            <h1 class="title text-center">Formulaire Modifier résevation remise</h1>
            <form autocomplete="off" method="post" action="codegererresoffre.php">
              <input type="hidden" name="operation" value="m">
              <input type="hidden" name="idres" value="<?php echo $idres; ?>">
              <div class="mb-2" style="position:relative;">
                <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$res['nbr_personnes'] ?>">
              </div>
              <div class="mb-2" style="position:relative;">
                <label for="typeC" class="form-label">Type de chambre</label>
                <select name="typeC" id="typeC" class="form-select">
                  <option value="Simple" selected >Simple</option>
                  <option value="Double">Double</option>
                  <option value="Triple">Triple</option>
                  <option value="Quadruple">Quadruple</option>
                </select>
              </div>
              <div class="mb-2" style="position:relative;">
                <label for="pension" class="form-label">Pension</label>
                <select name="pension" id="pension" class="form-select">
                  <option value="Complete" selected >Complete</option>
                  <option value="Demi pension">Demi pension</option>
                  <option value="Petit dejeuner">Petit dejeuner</option>
                  <option value="Tout inclus">Tout inclus</option>
                </select>
              </div>
              <div class="mb-2" style="position:relative;">
                <label for="dateDR" class="form-label">Date début réservation</label>
                <input disabled name="dateDR" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date debut reservation" id="dateDR" value="<?php echo @$res['date_debut_res'] ?>">
              </div> 
              <div class="mb-2">
                <label for="dateFR" class="form-label">Date fin réservation</label>
                <input disabled name="dateFR" type="date" min="<?php echo @$_POST['dateDR']; ?>" class="form-control pad" placeholder="Entrer date fin reservation" id="dateFR" value="<?php echo @$res['date_fin_res'] ?>" >
              </div>
              <div class="mb-2">
                <label for="stat" class="form-label">Statut</label>
                <select name="statut" id="stat" class="form-select">
                  <option value="en attente" selected >en attente</option>
                  <option value="confirme">confirmé</option>
                </select>
              </div>
              <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                <button name="validerremise" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
              </div>
            </form>
          </div>
          <?php  include $templates."footer.php";
              
              
      }
      elseif($type === "omra") {
  
        $res=getByField('reservation_offre','id_Res_offre',$idres);
        
          ?>
          <div class="container volForm">
            <h1 class="title text-center">Formulaire Modifier résevation omra</h1>
            <form autocomplete="off" method="post" action="codegererresoffre.php">
              <input type="hidden" name="operation" value="m">
              <input type="hidden" name="idres" value="<?php echo $idres; ?>">
              <div class="mb-2" style="position:relative;">
                <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$res['nbr_personnes'] ?>">
              </div>
              <div class="mb-2" style="position:relative;">
                <label for="typeC" class="form-label">Type de chambre</label>
                <select name="typeC" id="typeC" class="form-select">
                  <option value="Simple" selected >Simple</option>
                  <option value="Double">Double</option>
                  <option value="Triple">Triple</option>
                  <option value="Quadruple">Quadruple</option>
                </select>
              </div>
              <div class="mb-2" style="position:relative;">
                <label for="pension" class="form-label">Pension</label>
                <select name="pension" id="pension" class="form-select">
                  <option value="Complete" selected >Complete</option>
                  <option value="Demi pension">Demi pension</option>
                  <option value="Petit dejeuner">Petit dejeuner</option>
                  <option value="Tout inclus">Tout inclus</option>
                </select>
              </div>
              <div class="mb-2" style="position:relative;">
                <label for="dateDR" class="form-label">Date début réservation</label>
                <input disabled name="dateDR" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date debut reservation" id="dateDR" value="<?php echo @$res['date_debut_res'] ?>">
              </div> 
              <div class="mb-2">
                <label for="dateFR" class="form-label">Date fin réservation</label>
                <input disabled name="dateFR" type="date" min="<?php echo @$_POST['dateDR']; ?>" class="form-control pad" placeholder="Entrer date fin reservation" id="dateFR" value="<?php echo @$res['date_fin_res'] ?>" >
              </div>
              <div class="mb-2">
                <label for="stat" class="form-label">Statut</label>
                <select name="statut" id="stat" class="form-select">
                  <option value="en attente" selected >en attente</option>
                  <option value="confirme">confirmé</option>
                </select>
              </div>
              <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                <button name="valideromra" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
              </div>
            </form>
          </div>
          <?php  include $templates."footer.php";
              
  
      }else{
        rediriger();
      }
    }
  
  
  }
  }
     ?>
  
  
  <?php include $templates . "footer.php"; ?>