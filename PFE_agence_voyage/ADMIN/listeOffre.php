<?php
     $type = $_GET['type'];

    if($type === "hotel") { ?>
      <form class="search mt-4 d-flex col-8 mx-auto " autocomplete="off" method="post" action="?page=liste_hotels&&type=hotel">
        <input id="myInput" class="me-2 form-control" name="hotel" type="text" placeholder="Rechercher ce que vous voulez...">
        <button  class="btn btn-primary" name="search" type="submit"><i class="ms-1 fa-solid fa-magnifying-glass"></i></button>
      </form>
    
        <h1 class="text-center title mt-3 mb-3">Liste des offres hotels</h1>        
        <?php  
        $requete = "SELECT id_hotel,nom_hotel,nbr_etoiles,ville,pays FROM hotel";
        $sql = $connexion->prepare($requete);
        $sql->execute();
     ?>
     <div class="container-fluid">
        <div class="row">
            <div class="col-8">
    
            </div>
            <div class="col-4 offset-8 ">
              <div class="d-grid gap-2">
               <a href="gererOffre.php?type=hotel&&action=ajouter" class="btn btn-success mb-2 " ><i class="fa-solid fa-plus"></i>Ajouter offre hotel</a>
              </div>  
            </div>
        </div>
        <?php if($sql->rowCount() > 0) {
          $result = $sql->fetchAll();  ?>
          <div class="row">
             <div class="table-responsive" >
                  <table id="myTable" class="table table-bordered table-hover text-center display" style="width: 100%; border: solid 1px black; box-shadow: 5px 5px 20px gray; background-color:white;">
                     <tr style="background-color: gray; color:white; Font-size:20px; cursor:pointer; "> 
                       <th>Id</th>
                       <th>Nom hotel</th>
                       <th>Nombre d'étoiles</th>
                       <th>Ville</th>
                       <th>Pays</th>
                       <th colspan="2">Controle</th>
                     </tr>
                     <?php 
                     $num = 1;
                     foreach($result as $hot) {
                         echo "<tr class='data'>";
                           echo "<td>".$num."</td>";
                           echo "<td>".$hot['nom_hotel']."</td>";
                           echo "<td>".$hot['nbr_etoiles']."</td>";
                           echo "<td>".$hot['ville']."</td>";
                           echo "<td>".$hot['pays']."</td>";
                               $idhot = $hot['id_hotel'];
                           echo "<td><a class='btn btn-primary' href='gererOffre.php?type=hotel&&action=modifier&&id=$idhot'><i class='fa-solid fa-pen'></i>Modifier</a></td>";
                           echo "<td><a class='btn btn-danger confirm' href='gererOffre.php?type=hotel&&action=supprimer&&id=$idhot'><i class='fa-solid fa-circle-xmark'></i>Supprimer</a></td>"; 
                         echo "</tr>";
                         $num ++ ;
                         } 
                          ?>
                    </table>
             </div>
          </div>
      </div>               
      <?php  } else {
     aucunResultat("offre hotel");
         }

     }  
  /////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////////////
  elseif ($type == 'remise'){   ?>
	<form class="search mt-4 d-flex col-8 mx-auto " autocomplete="off" method="post" action="?page=liste_remises&&type=remise">
	  <input id="myInput" class="me-2 form-control" name="remise" type="text" placeholder="Rechercher ce que vous voulez...">
	  <button  class="btn btn-primary" name="search" type="submit"><i class="ms-1 fa-solid fa-magnifying-glass"></i></button>
	</form>

	  <h1 class="text-center title mt-3 mb-3">Liste des offres remise</h1>        
	  <?php  
	  $requete = "SELECT id_remise,nom_remise,nbr_etoiles,ville,pays FROM remise";
	  $sql = $connexion->prepare($requete);
	  $sql->execute();
   ?>
   <div class="container-fluid">
	  <div class="row">
		  <div class="col-8">
  
		  </div>
		  <div class="col-4 offset-8 ">
			<div class="d-grid gap-2">
			 <a href="gererOffre.php?type=remise&&action=ajouter" class="btn btn-success mb-2 " ><i class="fa-solid fa-plus"></i>Ajouter offre remise</a>
			</div>  
		  </div>
	  </div>
	  <?php if($sql->rowCount() > 0) {
		$result = $sql->fetchAll();  ?>
		
		<div class="row">
		   <div class="table-responsive" >
				<table id="myTable" class="table table-bordered table-hover text-center display" style="width: 100%; border: solid 1px black; box-shadow: 5px 5px 20px gray; background-color:white;">
				   <tr style="background-color: gray; color:white; Font-size:20px; cursor:pointer; "> 
					 <th>Id</th>
					 <th>Nom hotel</th>
					 <th>Nombre d'étoiles</th>
					 <th>Ville</th>
					 <th>Pays</th>
					 <th colspan="2">Controle</th>
				   </tr>
				   <?php 
				   $num = 1;
				   foreach($result as $rem) {
					
					   echo "<tr class='data'>";
						 echo "<td>".$num."</td>";
						 echo "<td>".$rem['nom_remise']."</td>";
						 echo "<td>".$rem['nbr_etoiles']."</td>";
						 echo "<td>".$rem['ville']."</td>";
						 echo "<td>".$rem['pays']."</td>";
							 $idrem = $rem['id_remise'];
						 echo "<td><a class='btn btn-primary' href='gererOffre.php?type=remise&&action=modifier&&id=$idrem'><i class='fa-solid fa-pen'></i>Modifier</a></td>";
						 echo "<td><a class='btn btn-danger confirm' href='gererOffre.php?type=remise&&action=supprimer&&id=$idrem'><i class='fa-solid fa-circle-xmark'></i>Supprimer</a></td>"; 
					   echo "</tr>";
					   $num ++ ;
					   } 
						?>
				  </table>
		   </div>
		</div>
	</div>               
	<?php  } else {
   aucunResultat("offre remise");
	   }

  }

////////////////////////////////////////////////////////////////////////////
///////////////////////////////////

  elseif ($type === "omra"){ ?>
	  <form class="search mt-4 d-flex col-8 mx-auto " autocomplete="off" method="post" action="?page=liste_omras&&type=omra">
		  <input id="myInput" class="me-2 form-control" name="omra" type="text" placeholder="Rechercher ce que vous voulez...">
		  <button  class="btn btn-primary" name="search" type="submit"><i class="ms-1 fa-solid fa-magnifying-glass"></i></button>
	  </form>
	  <h1 class="text-center title mt-3 mb-3">Liste des offres omra</h1>        
	  <?php  
	  $requete = "SELECT id_omra,intitule,ville,pays FROM omra";
	  $sql = $connexion->prepare($requete);
	  $sql->execute();
   ?>
   <div class="container-fluid">
	  <div class="row">
		  <div class="col-8">
  
		  </div>
		  <div class="col-4 offset-8 ">
			<div class="d-grid gap-2">
			 <a href="gererOffre.php?type=omra&&action=ajouter" class="btn btn-success mb-2 " ><i class="fa-solid fa-plus"></i>Ajouter offre omra</a>
			</div>  
		  </div>
	  </div>
	  <?php if($sql->rowCount() > 0) {
		$result = $sql->fetchAll();  
		?>		  
		<div class="row">
		   <div class="table-responsive" >
				<table id="myTable" class="table table-bordered table-hover text-center display" style="width: 100%; border: solid 1px black; box-shadow: 5px 5px 20px gray; background-color:white;">
				   <tr style="background-color: gray; color:white; Font-size:20px; cursor:pointer; "> 
					 <th>Id</th>
					 <th>Intitulé omra</th>
					 <th>Ville</th>
					 <th>Pays</th>
					 <th colspan="2">Controle</th>
				   </tr>
				   <?php 
				   $num = 1;
				   foreach($result as $omr) {
			
					   echo "<tr class='data'>";
						 echo "<td>".$num."</td>";
						 echo "<td>".$omr['intitule']."</td>";
						 echo "<td>".$omr['ville']."</td>";
						 echo "<td>".$omr['pays']."</td>";
							 $idomr = $omr['id_omra'];
						 echo "<td><a class='btn btn-primary' href='gererOffre.php?type=omra&&action=modifier&&id=$idomr'><i class='fa-solid fa-pen'></i>Modifier</a></td>";
						 echo "<td><a class='btn btn-danger confirm' href='gererOffre.php?type=omra&&action=supprimer&&id=$idomr'><i class='fa-solid fa-circle-xmark'></i>Supprimer</a></td>"; 
					   echo "</tr>";
					   $num ++ ;
					   } 
						?>
				  </table>
		   </div>
		</div>
	</div>               
	<?php  } else {
   aucunResultat("offre omra");
	   }
  }





     

 
  