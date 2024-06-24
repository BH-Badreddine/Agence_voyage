<?php 
$pageTitle = "Offres Omra";
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
    //Récupérer le nombre d'offres omra
    $requete = "SELECT count(*) as nbOmra FROM omra ";
    $sql = $connexion->prepare($requete);
     $sql->execute();
     $result = $sql->fetch();
    
    //Récupérer les info des offres omra
    $requete1 = "SELECT * FROM omra ORDER BY date_debut_omra ASC";
    $sql1 = $connexion->prepare($requete1);
    $sql1->execute();
     if($sql1->rowCount() > 0) {
       $result1 = $sql1->fetchAll();  
       ?>
       <div class="container-fluid">
            <div class="row">
               <div class="container-fluid kaaba">
                 <img src="IMAGES/kaaba.jpg" height="250px" width="100%" alt="">
               </div>
            </div>
       </div>
         <div class="row d-flex flex-nowrap alignement">
           <div class="annonce1">
             
           </div>
           <div class="container" style="width:1000px;">
            <div class="container" >
              <h1 class="hotelNat text-center mb-5 mt-3">- Nos offres omra <span>(<?php echo $result['nbOmra']; ?> résultats trouvés) -</span></h1>
              <div class="row d-flex justify-content-center flex-wrap">
                 <?php foreach($result1 as $omra) { 
                       $idOmra = $omra['id_omra'];
                     ?>
                   <div class="col-5">
                     <div class="card mb-3  text-center" style="width: 22rem;">
                        <img src="IMAGES/omra/<?php echo $omra['image1'];?>" height="200px" width="400px" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title" style="color: orange; font-weight:bold;"><?php echo $omra['intitule'];?></h5>
                          <p class="card-text">Du <span style="font-weight:bold;"><?php echo date('d M Y', strtotime($omra['date_debut_omra']));?></span> au <span style="font-weight:bold;"><?php echo date('d M Y', strtotime($omra['date_fin_omra']));?></span> </p>
                          <p class="card-text">A partir de <span style="color:red; font-weight:bold;"><?php echo $omra['tarif_une_personne']; ?> DZD</span></p>
                          <a href="consulterOmra.php?id=<?php echo $idOmra; ?>" class="btn btn-primary">En savoir plus</a>
                        </div>
                     </div> 
                   </div> 
               <?php    }
                ?>
              </div> 
            </div>
           </div>
           <div class="annonce2">
              
           </div>    

         </div>
       
       
     <?php  }
     else {
        aucunResultat('offre omra');
     }


     include $templates."footer.php";
 ?>





