<?php 
   
//Récupérer le nombre d'hotels dans la ville sélectionnée
      $requete = "SELECT count(*) as nbhotel FROM hotel WHERE ville = '$ville' ";
      $sql = $connexion->prepare($requete);
      $sql->execute();
      $result = $sql->fetch();
      //Récupérer tous les hotels de la ville sélectionnée
      $requete1 = "SELECT * FROM hotel WHERE ville='$ville'";
      $sql1 = $connexion->prepare($requete1);
      $sql1->execute();
      if($sql1->rowCount() > 0) {
         $result1 = $sql1->fetchAll(); ?>
         <h1 class="hotelNat text-center mb-4 mt-3">- Hotels à <?php echo $ville;?> <span>(<?php echo $result['nbhotel']; ?> résultats trouvés) -</span></h1>
     <?php 
          foreach($result1 as $hotel) {
            $idHot = $hotel['id_hotel'];
            ?>
             <div class="card mb-3">
             
                 <?php  if($hotel['nbr_etoiles'] != 0) {
                        echo "<h3 class='card-header'>". $hotel['nom_hotel']."&nbsp;&nbsp;&nbsp;" ;
                        echo "<span>"; 
                     for($i=1 ; $i<=$hotel['nbr_etoiles'] ; $i++) {
                         echo "<i class='fa-solid fa-star'></i>";
                     }
                     echo "</span>";
                     echo "</h3>";
                 } else {
                     echo "<h3 class='card-header'>". $hotel['nom_hotel'] ."</h3>";
                 }
                 
                 ?>
                 <div class="card-body container">
                     <div class="row">
                         <div class="col-4">
                             <img src="IMAGES/hotels/<?php echo $hotel['image1'];?>" alt="hotel" height="250px" width="290px">
                         </div>
                         <div class="col-8">
                             <h4 class="card-title">Ville : <?php echo $hotel['ville'];  ?></h4>
                             <h4 class="card-title">Tarif : <?php echo $hotel['tarif_unitaire']." DA/nuitée";  ?></h4>
                             <p class="card-text"><?php echo substr($hotel['description'],0,230)."...";
                                                      ?></p>
                             <a href="consulterHotel.php?id=<?php echo $idHot; ?>&&action=listeHPV" class="btn btn-primary ">Details</a>
                         </div>
                     </div>
                    
             </div>
</div>

       <?php  }
          } else {
            aucunResultat("offre hôtel");
          }
?>







