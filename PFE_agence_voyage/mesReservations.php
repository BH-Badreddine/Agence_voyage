<?php 
$pageTitle = "Mes reservations";
include "init.php"; ?> 
 
  <link rel="stylesheet" href="CSS/styleBB.css">
</head>
<body>
  <?php session_start();      
  if(isset($_SESSION['clientId'])) {
    include $templates."navbarClient.php"; 
     $idCli = $_SESSION['clientId'];
    ?>
    
    <h1 class="text-center title">Mes reservations offre</h1>
    <p class="text-center parHeader">- Ici, vous pouvez consulter la liste de vos réservations offre non expirées et/ou confirmées -</p>
     
   <?php 
     $requete1= "SELECT h.nom_hotel,ro.id_Res_offre,ro.date_debut_res,ro.date_fin_res,ro.type_chambre,ro.pension,ro.statut,ro.date_enreg_res FROM reservation_offre as ro,hotel as h WHERE ro.id_cli= '$idCli' and ro.id_hotel=h.id_hotel";

     $requete2= "SELECT r.nom_remise,ro.id_Res_offre,ro.date_debut_res,ro.date_fin_res,ro.type_chambre,ro.pension,ro.statut,ro.date_enreg_res FROM reservation_offre as ro,remise as r WHERE ro.id_cli= '$idCli' and ro.id_remise=r.id_remise";

     $requete3= "SELECT o.intitule,ro.id_Res_offre,ro.date_debut_res,ro.date_fin_res,ro.type_chambre,ro.pension,ro.statut,ro.date_enreg_res FROM reservation_offre as ro,omra as o WHERE ro.id_cli= '$idCli' and ro.id_omra=o.id_omra";

     $sql1=$connexion->prepare($requete1);
     $sql1->execute();

     $sql2=$connexion->prepare($requete2);
     $sql2->execute();

     $sql3=$connexion->prepare($requete3);
     $sql3->execute();

     if($sql1->rowCount() > 0 || $sql2->rowCount() > 0 || $sql3->rowCount() > 0) {
        $result1 = $sql1->fetchAll(); 
        $result2 = $sql2->fetchAll(); 
        $result3 = $sql3->fetchAll(); 
         date_default_timezone_set('Africa/Algiers');
         
         ?>
          <div class="table-responsive">
              <table class="table table-bordered table-hover text-center display" style="width: 100%; border: solid 1px black; box-shadow: 5px 5px 20px gray; background-color:white;">
                 <tr style="background-color: gray; color:white; Font-size:20px; cursor:pointer; "> 
                   <th>Nom offre</th>
                   <th>D.début réservation</th>
                   <th>D.fin réservation</th>
                   <th>Type chambre</th>
                   <th>Pension</th>
                   <th>Statut</th>
                   <th>D.enreg réservation</th>
                   <th>Controle</th>
                 </tr>
                 <?php  $format = "d-m-Y";
                    foreach($result1 as $reserv) {
                     echo "<tr class='data'>";
                       echo "<td>".$reserv['nom_hotel']."</td>";
                       echo "<td>".date($format,strtotime($reserv['date_debut_res']))."</td>";
                       echo "<td>".date($format,strtotime($reserv['date_fin_res']))."</td>";
                       echo "<td>".$reserv['type_chambre']."</td>";
                       echo "<td>".$reserv['pension']."</td>";
                       echo "<td>".$reserv['statut']."</td>";
                        
                        $dateEnreg = date($format, $reserv['date_enreg_res']);
                        echo "<td>".$dateEnreg."</td>";
                       if($reserv['statut']==="en attente") {
                           $idRes = $reserv['id_Res_offre'];
                           echo "<td><a class='btn btn-danger confirm' href='ADMIN/gererResOffre.php?action=supprimer&&id=$idRes'><i class='fa-solid fa-circle-xmark'></i>Annuler</a></td>";
                       }
                     echo "</tr>";
                     } 
                     foreach($result2 as $reserv) {
                        echo "<tr class='data'>";
                          echo "<td>".$reserv['nom_remise']."</td>";
                          echo "<td>".date($format,strtotime($reserv['date_debut_res']))."</td>";
                          echo "<td>".date($format,strtotime($reserv['date_fin_res']))."</td>";
                          echo "<td>".$reserv['type_chambre']."</td>";
                          echo "<td>".$reserv['pension']."</td>";
                          echo "<td>".$reserv['statut']."</td>";
                          
                          $dateEnreg = date($format, $reserv['date_enreg_res']);
                          echo "<td>".$dateEnreg."</td>";
                          if($reserv['statut']==="en attente") {
                              $idRes = $reserv['id_Res_offre'];
                              echo "<td><a class='btn btn-danger confirm' href='ADMIN/gererResOffre.php?action=supprimer&&id=$idRes'><i class='fa-solid fa-circle-xmark'></i>Annuler</a></td>";
                          }
                        echo "</tr>";
                        }  
                        foreach($result3 as $reserv) {
                            echo "<tr class='data'>";
                              echo "<td>".$reserv['intitule']."</td>";
                              echo "<td>".date($format,strtotime($reserv['date_debut_res']))."</td>";
                              echo "<td>".date($format,strtotime($reserv['date_fin_res']))."</td>";
                              echo "<td>".$reserv['type_chambre']."</td>";
                              echo "<td>".$reserv['pension']."</td>";
                              echo "<td>".$reserv['statut']."</td>";
      
                              $dateEnreg = date($format, $reserv['date_enreg_res']);
                              echo "<td>".$dateEnreg."</td>";
                              if($reserv['statut']==="en attente") {
                                  $idRes = $reserv['id_Res_offre'];
                                  echo "<td><a class='btn btn-danger confirm' href='ADMIN/gererResOffre.php?action=supprimer&&id=$idRes'><i class='fa-solid fa-circle-xmark'></i>Annuler</a></td>";
                              }
                            echo "</tr>";
                            } 
                     ?> 
              </table>
          </div>
         
     <?php  }
     else {
        aucunResultat("réservation offre");
     }

  ?>
    <h1 class="text-center title">Mes reservations vol</h1>
    <p class="text-center parHeader">- Ici, vous pouvez consulter la liste de vos réservations vol non expirées et/ou confirmées -</p>
   <?php  
     $requete4 = "SELECT id_Res_vol,ville_depart, destination,date_depart,date_retour,classe,statut,date_enreg_res FROM reservation_vol WHERE id_cli='$idCli'";
     $sql4 = $connexion->prepare($requete4);
     $sql4->execute();
     if( $sql4->rowCount() > 0) {
         $result4 = $sql4->fetchAll();
         date_default_timezone_set('Africa/Algiers'); ?>
         <div class="table-responsive">
              <table class="table table-bordered table-hover text-center display" style="width: 100%; border: solid 1px black; box-shadow: 5px 5px 20px gray; background-color:white;">
                 <tr style="background-color: gray; color:white; Font-size:20px; cursor:pointer; "> 
                   <th>Ville départ</th>
                   <th>Destination</th>
                   <th>Date départ</th>
                   <th>Date retour</th>
                   <th>Classe</th>
                   <th>Statut</th>
                   <th>D.enreg réservation</th>
                   <th>Controle</th>
                 </tr>
                 <?php  $format = "d-m-Y";
                    foreach($result4 as $reserv) {
                     echo "<tr class='data'>";
                       echo "<td>".$reserv['ville_depart']."</td>";
                       echo "<td>".$reserv['destination']."</td>";
                       echo "<td>".date($format,strtotime($reserv['date_depart']))."</td>";
                       echo "<td>".date($format,strtotime($reserv['date_retour']))."</td>";
                       echo "<td>".$reserv['classe']."</td>";
                       echo "<td>".$reserv['statut']."</td>";
                        
                        $dateEnreg = date($format, $reserv['date_enreg_res']);
                        echo "<td>".$dateEnreg."</td>";
                       if($reserv['statut']==="en attente") {
                           $idRes = $reserv['id_Res_vol'];
                           echo "<td><a class='btn btn-danger confirm' href='ADMIN/gererResVol.php?action=supprimer&&id=$idRes'><i class='fa-solid fa-circle-xmark'></i>Annuler</a></td>";
                       }
                     echo "</tr>";
                     }  ?>
               </table>
        </div>         
    <?php }
    else {
      aucunResultat("réservation vol");
    }
    
   }
  else { 
     rediriger();
  }
?>
<?php include $templates."footer.php"; ?>