<?php 
$pageTitle = "Offres Remise";
include "init.php"; ?>
 <link rel="stylesheet" href="CSS/styleBB.css">
</head>
<body>
 <?php session_start();
       if(isset($_SESSION['clientId'])) {
        include $templates . "navbarClient.php";
      } else {
        include $templates . "navbarVisiteur.php";
      }
    //Récupérer le nombre d'offres remise
    $requete = "SELECT count(*) as nbRemise FROM remise "; 
    $sql = $connexion->prepare($requete);
     $sql->execute();
     $result = $sql->fetch();
    
    //Récupérer les info des offres remise
    $requete1 = "SELECT * FROM remise ORDER BY date_debut_remise ASC";
    $sql1 = $connexion->prepare($requete1);
    $sql1->execute();
     if($sql1->rowCount() > 0) {
       $result1 = $sql1->fetchAll();  
       ?>
       <div class="container-fluid">
         <div class="row ">
               <div class="container-fluid kaaba">
                 <img src="IMAGES/remiseplage.jpg" height="330px" width="100%" alt="">
               </div>
         </div>
         <div class="row d-flex flex-nowrap" style="margin-top: 80px;">
           <div class="annonceR1">
             
           </div>
           <div class="container" style="width:1000px;">
            <div class="container" >
              <h1 class="hotelNat text-center mb-5 mt-3">- Nos offres Remise <span>(<?php echo $result['nbRemise']; ?> résultats trouvés) -</span></h1>
              <div class="row d-flex justify-content-around flex-wrap">
                 <?php foreach($result1 as $remise) { 
                       $idRemise = $remise['id_remise'];
                     ?>
                   <div class="col-5">
                     <div class="card mb-3  text-center" style="width: 24rem; min-height:600px; max-height:auto; position:relative;">
                        <img src="IMAGES/remises/<?php echo $remise['image1'];?>" height="200px" width="400px" class="card-img-top" alt="...">
                        <div class="card-body"> 
                          <h5 class="card-title" style="color: orange; font-weight:bold;">
                            <?php echo $remise['nom_remise'];?>
                            <?php  if($remise['nbr_etoiles'] != 0) {
                                      ?> 
                                      <br>
                                      <?php
                                      echo "<span>"; 
                                      for($i=1 ; $i<=$remise['nbr_etoiles'] ; $i++) {
                                        echo "<i class='fa-solid fa-star'></i>";
                                      }
                                      echo "</span>";
                                    } ?>
                        
                          </h5>
                          <p class="card-text"> <i class="fa-solid fa-location-dot"></i><?php echo $remise['ville'].", ".$remise['pays']; ?></p>
                          <p class="card-text">Du <span style="font-weight:bold;"><?php echo date('d M Y', strtotime($remise['date_debut_remise']));?></span> au <span style="font-weight:bold;"><?php echo date('d M Y', strtotime($remise['date_fin_remise']));?></span> </p>
                          <p class="card-text">A partir de <span style="color:red; font-weight:bold;"><?php echo $remise['tarif_apres_red']; ?>DZD </span>( <s><?php echo $remise['tarif_avant_red']; ?>DZD</s>)</p>
                          <p class="card-text">Vous économiserez <span style="color:red; font-weight:bold;"><?php echo $remise['pourcentage_red'];?>% </span> sur votre séjour</p>
                          <a href="consulterRemise.php?id=<?php echo $idRemise; ?>" class="btn btn-primary" style="position:absolute;bottom:35px;right:30%;">En savoir plus</a>
                        </div>
                     </div> 
                   </div> 
               <?php    }
            ?>
         </div>
         
        </div>

           </div>
           <div class="annonceR2">
              
           </div>    

         </div>
       </div>
       
     <?php  }
     else {
        aucunResultat('offre remise');
     }


     include $templates."footer.php";
 ?>





