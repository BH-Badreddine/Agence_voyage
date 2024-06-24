<?php   session_start();
      include "INCLUDES/Templates/connexionBDD.php";
      $ok = false;
      
      if(isset($_GET['nom'])) {
         $nomH = $_GET['nom'];
         $pageTitle = $nomH;
         $ok = true;
         $requete = "SELECT * FROM hotel WHERE nom_hotel='$nomH'";
         $sql = $connexion->prepare($requete);
         $sql->execute();
         if($sql->rowCount() > 0) {
             $result = $sql->fetch();
             $idH = $result['id_hotel'];
         }
      }

      if(isset($_GET['id'])) {
        $ok = true;
        $idH = $_GET['id'];
        $requete = "SELECT * FROM hotel WHERE id_hotel='$idH'";
        $sql = $connexion->prepare($requete);
        $sql->execute();
         if($sql->rowCount() > 0) {
             $result = $sql->fetch();
             $pageTitle = $result['nom_hotel'];
         }

     }
         include "INCLUDES/Functions/functions.php";
     if($ok) {  
         include "INCLUDES/Templates/header.php";
         ?>
        <link rel="stylesheet" href="CSS/styleBB.css">
     </head>
     <body style='position:relative;'>
        <?php 
        if(isset($_SESSION['clientId'])) {
          include "INCLUDES/Templates/navbarClient.php";
        } else {
          include "INCLUDES/Templates/navbarVisiteur.php";
        } 
        if(isset($_GET['action'])) {
          if($_GET['action'] === 'listeHPV') {
            if($result['pays'] === "Algerie") {
              echo "<a style='position:sticky; top:85px; z-index: 2;' class='btn btn-success' href='listeHotels.php?type=national'>Aller à Liste hôtels nationaux</a>";
            } else {
              echo "<a style='position:sticky; top:85px; z-index: 2;' class='btn btn-success' href='listeHotels.php?type=international'>Aller à Liste hôtels internationaux</a>";
            } 
          }
        } 
        
        ?>
         <div class="container">
              <?php  if($result['nbr_etoiles'] != 0) {
                    echo "<h1 class='display-5 title mt-1 ms-2'>". $result['nom_hotel']."&nbsp;&nbsp;&nbsp;" ;
                    echo "<span>"; 
                    for($i=1 ; $i<=$result['nbr_etoiles'] ; $i++) {
                        echo "<i class='fa-solid fa-star mb-3'></i>";
                    }
                        echo "</span>";
                        echo "</h1>";
                  } else {
                     echo "<h1 class='display-4 title mt-1 ms-2'>". $result['nom_hotel'] ."</h1>";
                     }
              ?>
              <p class="ms-2 display-8 adresse"> <i class="fa-solid fa-location-dot"></i><?php echo $result['adresse']; ?></p>
            
            <div id="carouselExampleIndicators" class="mx-auto carousel slide carousel-fade" data-bs-ride="true">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="2000">
                    <img src="IMAGES/hotels/<?php echo $result['image1'];?>" class="d-block  w-100" height="400px" alt="...">
                  </div>
                  <div class="carousel-item" data-bs-interval="2000">
                    <img src="IMAGES/hotels/<?php echo $result['image2'];?>" class="d-block w-100" height="400px" alt="...">
                 </div>
                 <div class="carousel-item" data-bs-interval="2000">
                   <img src="IMAGES/hotels/<?php echo $result['image3'];?>" class="d-block w-100" height="400px" alt="...">
                 </div>
                </div>
                 <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                   <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                   <span class="visually-hidden">Previous</span>
                 </button>
                 <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                   <span class="carousel-control-next-icon" aria-hidden="true"></span>
                   <span class="visually-hidden">Next</span>
                 </button>
            </div>

            <div class="d-grid gap-2 col-4 mx-auto mt-3 mb-2">
                <a style="font-size:28px;" href="reserverOffre.php?type=hotel&&id=<?php echo $result['id_hotel']; ?>" class="btn btn-warning">Reserver</a>
            </div>

            <div class="row mt-3 content">
                <div class="description col-7">
                    <h2 class="mt-2">Description</h2>
                    <hr class="float-start mt-1 mb-1 w-100">
                    <p class="mt-4" style="text-align:justify;"><?php echo stripAccents(trim($result['description']));  ?></p>
                </div>
                <div class="col-5 ">
                    <div class="divTarif text-center ">
                        <h2 style="font-family: 'Source Serif Pro', serif; font-weight: bold;">Tarif d'une chambre </h2>
                        <hr class="float-start mt-1 mb-3 w-100">
                        <p>à partir de <span class='tarif '><?php echo $result['tarif_unitaire']; ?> DZD</span></p>
                        <h3><i class="fa-solid fa-phone"></i>Mobile:+213 559 627 691</h3>
                    </div>   
                    <div class="pointF mt-3">
                        <h2 class="ms-2" style="font-family: 'Source Serif Pro', serif; font-weight: bold;">Points forts</h2>
                        <hr class="float-start mt-1 mb-3 w-100">
                        <?php echo pointsf($result['points_forts'], '<i class="fa-solid fa-circle-arrow-right"></i>'); ?>
                    </div>
                     
                </div>
            </div> 
            <p id="AffTarif"></p>
            <h1 class="title text-center">Calculer votre tarif total</h1>
            <div class="d-flex justify-content-center">
                <i class="fa-solid fa-circle blue"></i>
                <i class="fa-solid fa-circle yellow"></i>
                <i class="fa-solid fa-circle gray"></i>
            </div>
            <div class="container mt-3 calTarif">
              <form method="POST" action="consulterHotel.php?action=listeHPV&&id=<?php echo $idH;?>#AffTarif">
                 <label for="nbPers" class="form-label">Entrer nombre de personnes</label>
                 <input id="nbPers" name="personne" type="number" class="form-control " value="<?php echo @$_POST['personne']; ?>" required>
                 <label for="nbNui" class="form-label">Entrer nombre de nuitées</label>
                 <input id="nbNui" name="nuitée" type="number" class="form-control " value="<?php echo @$_POST['nuitée']; ?>"  required>
                 <input name="cal" type="submit" value="Calculer" class="btn btn-primary ms-3" >
                 
                 <hr class="w-70 text-center ">
                 <label class="form-label offset-3">Le séjour vous coûtera à partir de</label> <input class="tarif form-control " type="number" disabled> <label class="form-label" style="margin-left:-20px;">DZD</label>
              </form>
              
            </div>
            
            <h1 class="title text-center mt-2">Avis des clients</h1>
            <div class="d-flex justify-content-center">
                <i class="fa-solid fa-circle blue"></i>
                <i class="fa-solid fa-circle yellow"></i>
                <i class="fa-solid fa-circle gray"></i>
            </div>
            <div class="container avis mt-3"> 
               <form method="post" action="publierAvis.php?idH=<?php echo $idH;?>">
                    <label for="eval" class="form-label">Evaluation</label>
                    <select name="eval" id="eval" class="form-select" required>
                         <option value="Excellente" selected >Excellente</option>
                         <option value="Bonne">Bonne</option>
                         <option value="Moyenne">Moyenne</option>
                         <option value="Mauvaise">Mauvaise</option>
                    </select>
                    <label for="note" class="form-label ms-5">Note</label>
                    <input id="note" name="note" type="number" min="0" max="10" class="form-control" required><span class="ms-3">/10</span>
                    <textarea name="comment" cols="80" rows="10" class="mt-3 commentaire" placeholder="Entrer votre commentaire..." required></textarea>
                    <?php  
                    if(isset($_SESSION['clientId'])) {
                      echo '<input class="btn btn-primary mb-4 ms-2 col-2" name="publier" type="submit" value="Publier">';
                    }  
                    else {
                      echo '<input class="btn btn-primary mb-4 ms-2 col-2 disabled" name="publier" type="submit" value="Publier">';
                    }
                    ?>
               </form>
            </div>       
        </div>
        <hr class="w-90">
        <div class="container listeAvis"> 
             <?php  $requete2 = "SELECT cl.civilite,co.login,a.evaluation,a.note,a.commentaire,a.date_publication FROM compte as co, avis as a,client as cl WHERE co.id_cli = a.id_cli and a.id_cli = cl.id_cli and a.id_hotel ='$idH' ORDER BY a.date_publication DESC";
                 $sql2 = $connexion->prepare($requete2);
                 $sql2->execute();
                 if($sql2->rowCount() > 0) {
                   $result2 = $sql2->fetchAll();
                   foreach($result2 as $avis) {  ?>
                       <div class="AVIS">
                          <div class="row">
                            <div class="col-3"> 
                              <?php if($avis['civilite']=="Mr") {
                                 echo '<p><img src="IMAGES/male_logo.png" height="40px" width="45px" class="rounded-circle me-2 mt-2" style="background-color:rgb(231, 231, 111); ">'.$avis["login"].'</p>';
                                } else {
                                  echo '<p><img src="IMAGES/female_logo.png" height="40px" width="45px" class="rounded-circle me-2 mt-2" style="background-color:rgb(231, 231, 111); ">'.$avis["login"].'</p>';
                                }
                                ?>
                            </div>
                            <div class="col-3 margin">
                              <p><?php echo $avis['evaluation']; ?></p>
                            </div>
                            <div class="col-3 margin">
                              <p><?php echo $avis['note']; ?><span>/10</span></p>
                            </div>
                            <div class="col-3 margin">
                              <p><?php echo $avis['date_publication']; ?></p>
                            </div>
                          </div>
                          <p class="ms-3" style="font-size:18px; margin-top:-10px;"><?php echo tronquer($avis['commentaire'],195); ?></p>
                       </div>
                   <?php  }
                 }else {
                  echo '<div class="alert alert-info aucunResultat">';
                    echo '<p style="font-size: 20px;" class="text-center">Aucun avis publié !</p>';
                  echo '</div>';
                 }
             ?>
        </div>


        <?php include "INCLUDES/Templates/footer.php"; ?>
        <?php   if(isset($_POST['cal'])) {
          $nbPers = $_POST['personne'];
          $nbNuit = $_POST['nuitée'];
          $tarifTotal = $result['tarif_unitaire'] * $nbNuit * $nbPers ; 
           ?>
           <script>
            let tarif = <?php echo (string)$tarifTotal; ?>;
            $("input.tarif").attr('value', tarif);
          </script> 
          
       <?php  
           
      }


   
        
      
      
      }  
        
        





?>


