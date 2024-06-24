
<?php  ob_start();
   $pageTitle = "Réserver offre";
   include "init.php";  ?>
     <link rel="stylesheet" href="CSS/styleBB.css">
 </head>
 <?php   
 ?>
 <body>  
  <?php  session_start();
    if(isset($_SESSION['clientId'])) {
         $idCli = $_SESSION['clientId'];
         include $templates."navbarClient.php";
         if(isset($_GET['type'])) {
          $type = $_GET['type'];
          if($type === "omra") {
              echo "<body class='omra'>";//faire un background image pour le cas reserver omra
          }
          else {
             echo "<body class='hotelRemise'>";
          }
         }
         if(isset($_GET['type']) && isset($_GET['id'])) {
            
          if($type === "hotel") { 
              $idH = $_GET['id'];
              ?>
             <div class="error container text-center mt-2">

             </div>
             <div class="alert alert-info text-center mx-auto " style="width:50%; background-color: rgba(127, 255, 212, 0.575); color: black;">
                   <p class="display-6" style="font-weight: 500;">Vous devez réserver en utilisant vos propres coordonées !</p>
             </div>
             <div class="container reserverForm">
               <h1 class="title text-center">Formulaire résevation dans un hôtel</h1>

               <form autocomplete="off" method="post" action="reserverOffre.php?type=hotel&&id=<?php echo $idH; ?>">
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
                   <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                   <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$_POST['nbP'];?>">
                 </div>
                 <div class="mb-2">
                   <label for="typeC" class="form-label">Type de chambre</label>
                   <select name="typeC" id="typeC" class="form-select">
                        <option value="Simple" selected >Simple</option>
                        <option value="Double">Double</option>
                        <option value="Triple">Triple</option>
                        <option value="Quadruple">Quadruple</option>
                   </select>
                 </div>
                 <div class="mb-2">
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
              $email = $_POST['email'];
              $nbPers = $_POST['nbP'];
              $typeC = $_POST['typeC'];
              $pension = $_POST['pension'];
              $dateDR = $_POST['dateDR'];
              $dateFR = $_POST['dateFR'];
              $date_enreg_rés = strtotime(date("d-m-Y H:i:s"));

              //validation de date --------> si(date retour <= date depart) alors c'est une erreur
              if(strtotime($dateDR) >= strtotime($dateFR)  ) {   ?>
                <script>
                  $("div.error").html("<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Veuillez entrer une date fin réservation valide</p>");
               </script>  
               <?php  }
               else {
                  $requete = "INSERT INTO reservation_offre(nbr_personnes,type_chambre,pension,date_debut_res,date_fin_res,statut,date_enreg_res,id_cli,id_hotel) VALUES('$nbPers','$typeC','$pension','$dateDR','$dateFR','en attente','$date_enreg_rés','$idCli','$idH')";
                  $sql = $connexion->prepare($requete);
                  $sql->execute();
                header("Location: poursuivreRes.php?civilité=$civ&&nom=$nom&&prenom=$prenom");
             }
               }
          }
          /////////////////////////////////////////////////
          //////////////////////////////////////
          if($type === "remise") {
              $idRemise = $_GET['id'];
              $requete4 = "SELECT date_debut_remise, date_fin_remise FROM remise WHERE id_remise='$idRemise'"; 
              $sql4 =  $connexion->prepare($requete4);
              $sql4->execute();
              $result4 = $sql4->fetch();
              ?>
              <div class="alert alert-info text-center mx-auto " style="width:50%; background-color: rgba(127, 255, 212, 0.575); color: black;">
                <p class="display-6" style="font-weight: 500;">Vous devez réserver en utilisant vos propres coordonées !</p>
              </div>
              <div class="container reserverForm" style="background-color: rgba(236, 230, 230,0.65);">
                <h1 class="title text-center">Formulaire résevation offre remise</h1>

                <form autocomplete="off" method="post" action="reserverOffre.php?type=remise&&id=<?php echo $idRemise; ?>">
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
                   <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                   <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$_POST['nbP'];?>">
                 </div>
                 <div class="mb-2">
                   <label for="typeC" class="form-label">Type de chambre</label>
                   <select name="typeC" id="typeC" class="form-select">
                     <option value="Simple" selected >Simple</option>
                     <option value="Double">Double</option>
                     <option value="Triple">Triple</option>
                     <option value="Quadruple">Quadruple</option>
                   </select>
                 </div>
                 <div class="mb-2">
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
                   <input disabled  name="dateDR" type="date" class="form-control pad" id="dateDR" value="<?php echo $result4['date_debut_remise'] ;?>">
                 </div>
                 <div class="mb-2" style="position:relative;">
                   <label for="dateFR" class="form-label">Date fin réservation</label>
                   <input disabled  name="dateFR" type="date" class="form-control pad" id="dateFR" value="<?php echo $result4['date_fin_remise']; ?>" >
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
                      $email = $_POST['email'];
                      $nbPers = $_POST['nbP'];
                      $typeC = $_POST['typeC'];
                      $pension = $_POST['pension'];
                      $dateDR = $result4['date_debut_remise'];
                      $dateFR = $result4['date_fin_remise'];
                      $date_enreg_res = strtotime(date("d-m-Y H:i:s"));
                      $requete3 = "INSERT INTO reservation_offre(nbr_personnes,type_chambre,pension,date_debut_res,date_fin_res,statut,date_enreg_res,id_cli,id_remise) VALUES('$nbPers','$typeC','$pension','$dateDR','$dateFR','en attente','$date_enreg_res','$idCli','$idRemise')";
                      $sql3 = $connexion->prepare($requete3);
                      $sql3->execute();
                      header("Location: poursuivreRes.php?civilité=$civ&&nom=$nom&&prenom=$prenom");
                    }  
             }
          ////////////////////////////////////////////////////////////////
          ////////////////////////////////////////////////////////////
          if($type === "omra") {  
              $idOmra = $_GET['id'];
              $requete4 = "SELECT date_debut_omra, date_fin_omra FROM omra WHERE id_omra='$idOmra'";
              $sql4 =  $connexion->prepare($requete4);
              $sql4->execute();
              $result4 = $sql4->fetch();
              ?>
              <div class="alert alert-info text-center mx-auto " style="width:50%; background-color: rgba(127, 255, 212, 0.575); color: black;">
                <p class="display-6" style="font-weight: 500;">Vous devez réserver en utilisant vos propres coordonées !</p>
              </div>
              <div class="container reserverForm" style="background-color: rgba(199, 232, 247, 0.603)">
                <h1 class="title text-center">Formulaire résevation offre omra</h1>

                <form autocomplete="off" method="post" action="reserverOffre.php?type=omra&&id=<?php echo $idOmra; ?>" >
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
                   <label for="nbP" class="form-label text-center">Nombre de personnes</label>
                   <input required name="nbP" type="number" min="1" max="6" class="form-control pad" id="nbP" placeholder="Entrer nombre personnes" value="<?php echo @$_POST['nbP'];?>">
                 </div>
                 <div class="mb-2">
                   <label for="typeC" class="form-label">Type de chambre</label>
                   <select name="typeC" id="typeC" class="form-select">
                     <option value="Simple" selected >Simple</option>
                     <option value="Double">Double</option>
                     <option value="Triple">Triple</option>
                     <option value="Quadruple">Quadruple</option>
                   </select>
                 </div>
                 <div class="mb-2">
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
                   <input disabled  name="dateDR" type="date" class="form-control pad" id="dateDR" value="<?php echo $result4['date_debut_omra'] ;?>">
                 </div>
                 <div class="mb-2" style="position:relative;">
                   <label for="dateFR" class="form-label">Date fin réservation</label>
                   <input disabled  name="dateFR" type="date" class="form-control pad" id="dateFR" value="<?php echo $result4['date_fin_omra']; ?>" >
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
                      $email = $_POST['email'];
                      $nbPers = $_POST['nbP'];
                      $typeC = $_POST['typeC'];
                      $pension = $_POST['pension'];
                      $dateDR = $result4['date_debut_omra'];
                      $dateFR = $result4['date_fin_omra'];
                      $date_enreg_rés = strtotime(date("d-m-Y H:i:s"));
                      $requete3 = "INSERT INTO reservation_offre(nbr_personnes,type_chambre,pension,date_debut_res,date_fin_res,statut,date_enreg_res,id_cli,id_omra) VALUES('$nbPers','$typeC','$pension','$dateDR','$dateFR','en attente','$date_enreg_rés','$idCli','$idOmra')";
                      $sql3 = $connexion->prepare($requete3);
                      $sql3->execute();
                      header("Location: poursuivreRes.php?civilité=$civ&&nom=$nom&&prenom=$prenom");
                    }
             ?>

           <?php  }

         }
    }
    else {
       rediriger();
    }
    ob_end_flush();
?>