<?php 
if (isset($_GET['operation']) && $_GET['operation']=='success') { ?>
 <h1 class="alert alert-success text-center">success</h1>
<?php } ?>

<form class="search mt-4 d-flex col-8 mx-auto" autocomplete="off" method="post" action="?page=liste_res_offre">
     <input  id="myInput" class="me-2 form-control" name="client" type="text" placeholder="Rechercher ce que vous voulez...">
     <button class="btn btn-primary" name="search" type="submit"><i class="ms-1 fa-solid fa-magnifying-glass"></i></button>
  </form>
  
    <h1 class="text-center title mt-3 mb-3">Liste des réservations offre</h1>        
    <?php  
    $requete = "SELECT r.id_Res_offre,r.date_debut_res,r.date_fin_res,r.statut,r.date_enreg_res,r.id_hotel,r.id_remise,r.id_omra,c.nom_cli,c.prenom_cli FROM client as c,reservation_offre as r WHERE r.id_cli=c.id_cli";
    $sql = $connexion->prepare($requete);
    $sql->execute();
 ?>
 <div class="container">
 <div class="row">
        <div class="col-7 text-center d-flex mx-auto">
           <a href="gererResOffre.php?action=supprimer expiré"  class="btn btn-danger confirm btn-lg mb-2 ms-5" ><i class='fa-solid fa-circle-xmark'></i>Supprimer reservations expirées</a>
           <a href="gererResOffre.php?action=ajouter" class="btn btn-success mb-2 ms-2" ><i class="fa-solid fa-plus"></i>Ajouter réservation</a>
        </div>
    </div>
    <?php if($sql->rowCount() > 0) {
      $result = $sql->fetchAll(); ?>
    <div class="row">
         <div class="table-responsive" >
         <table id="myTable" class="table table-bordered table-hover text-center display" style="width: 100%; border: solid 1px black; box-shadow: 5px 5px 20px gray; background-color:white;">
                 <tr style="background-color: gray; color:white; Font-size:20px; cursor:pointer; "> 
                   <th>Id</th>
                   <th>Type offre</th>
                   <th>Nom offre</th>
                   <th>Nom et prénom</th>
                   <th>Début réservation</th>
                   <th>Fin réservation</th>
                   <th>Statut</th>
                   <th>D.enreg reservation</th>
                   <th colspan="2">Controle</th>
                 </tr>
                 <?php 
                 $num = 1;
                 $format = "d/m/Y";
                 foreach($result as $reserv) {
                  $nomComplet = $reserv['nom_cli']." ".$reserv['prenom_cli'];
                    if($reserv['id_remise']){
                      $nomoffre = getRemise($reserv['id_remise'])['nom_remise'];
                      $typeoffre='remise';
                    }elseif($reserv['id_hotel']){
                      $nomoffre = getHotel($reserv['id_hotel'])['nom_hotel'];
                      $typeoffre='hotel';
                    }else{
                      $nomoffre = getOmra($reserv['id_omra'])['intitule'];
                      $typeoffre='omra';
                    }
                       echo "<tr class='data'>";
                       echo "<td>".$num."</td>";
                       echo "<td>".$typeoffre."</td>";
                       echo "<td>".$nomoffre."  </td>";
                       echo "<td>".$nomComplet."</td>";
                       echo "<td>".date($format,strtotime($reserv['date_debut_res']))."</td>";
                       echo "<td>".date($format,strtotime($reserv['date_fin_res']))."</td>";
                       echo "<td>".$reserv['statut']."</td>";
                        
                        $dateEnreg = date($format, $reserv['date_enreg_res']);
                       echo "<td>".$dateEnreg."</td>";

                           $idRes = $reserv['id_Res_offre'];
                           echo "<td><a class='btn btn-primary' href='gererResoffre.php?action=modifier&&type=$typeoffre&&id=$idRes'><i class='fa-solid fa-pen'></i>Modifier</a></td>";
                           echo "<td><a class='btn btn-danger confirm' href='gererResoffre.php?action=supprimer&&id=$idRes'><i class='fa-solid fa-circle-xmark'></i>Supprimer</a></td>";
                       
                     echo "</tr>";
                     $num ++ ;
                     } 
                      ?>
                </table>
         </div>
      </div>
  </div>               
 <?php  
    } 
    
    else {
      aucunResultat("réservation offre");
    }

 
  ?>