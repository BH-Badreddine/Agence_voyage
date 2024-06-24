<?php   session_start();
  if(isset($_GET['type'])) {  
    $type = $_GET['type'];
    $type === "national"? $pageTitle = "Hotels nationaux" : $pageTitle = "Hotels internationaux";
    if(isset($_POST['search'])) {
        $ville = $_POST['ville']; 
        $pageTitle = "Hotels à ". $ville;
    }
    include "init.php";
  ?>
   <link rel="stylesheet" href="CSS/styleBB.css">
</head>
<body>
    <?php  
        if(isset($_SESSION['clientId'])) {
          include $templates . "navbarClient.php";
        } else {
          include $templates . "navbarVisiteur.php";
        } 
    if($type === "national") {
        //Récupérer toutes les villes nationales
        $requete = "SELECT DISTINCT ville FROM hotel WHERE pays='Algerie' ORDER BY ville ASC";
        $sql = $connexion->prepare($requete);
        $sql->execute();
        //Récupérer le nombre total d'hotels nationaux existants
        $requete1 = "SELECT count(*) as nbHotels FROM hotel WHERE pays='Algerie'";
        $sql1 = $connexion->prepare($requete1);
        $sql1->execute();
        $result1 = $sql1->fetch();
        //pagination
        $total = $result1['nbHotels'];
        $nbHotelParPage = 5;
        $nbPages = ceil($total/$nbHotelParPage);
        if(isset($_GET['page'])) {
            $pageActuelle = $_GET['page'];
        }
        else {
            $pageActuelle = 1;
        }
        if($pageActuelle < 1) {
            $pageActuelle = 1;
        }
        if($pageActuelle > $nbPages) {
            $pageActuelle = $nbPages;
        }
        $debut = $nbHotelParPage * ($pageActuelle-1);
        //Récupérer les hotels nationaux à afficher dans une seule page
        $requete2 = "SELECT * FROM hotel WHERE pays='Algerie' ORDER BY nom_hotel ASC LIMIT $debut,5 ";//LIMIT prend 2 paramètres: le numéro de la ligne à partir duquel on veut afficher , le nbr de lignes à afficher
        $sql2 = $connexion->prepare($requete2);
        $sql2->execute();
        
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 mt-3">
                 <form method="POST" action="listeHotels.php?type=national">
                     <div class="mt-2 listeVille">
                        <label for="ville" class="form-label ms-4 mt-4">Veuillez choisir une ville</label>
                        <select name="ville" id="ville" class="form-select ms-4">
                            <option value="" selected>----</option>
                            <?php if($sql->rowCount() > 0) {
                                       $result = $sql->fetchAll();
                                        foreach($result as $hotel) {
                                            echo "<option value=".$hotel['ville'].">". $hotel['ville']."</option>";
                                          }
                                   }  ?>
                        </select>
                        <button name="search" type="submit" class="btn btn-sm btn-success ms-4" style="font-size:17px;">Rechercher</button>
                     </div>
                 </form>
                    
                </div>
                <div class="col-md-9">  

                    <?php if(isset($_POST['search'])) {
                        $ville = $_POST['ville']; 
                        include "listeHotelParVille.php";
                    }
                     else {
                    ?>
                    <h1 class="hotelNat text-center mb-2 mt-3">- Hotels Nationaux <span>(<?php echo $result1['nbHotels']; ?> résultats trouvés) -</span></h1>
                    <?php 
                        if($sql2->rowCount() > 0) {
                           echo "<h2 class='text-center mb-5'> - Page ".$pageActuelle." -</h2>";
                            
                           $result2 = $sql2->fetchAll();
                           foreach($result2 as $hotel) { 
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
                                                <img src="IMAGES/hotels/<?php echo $hotel['image1'];?>" alt="hotel" height="280px" width="300px">
                                            </div>
                                            <div class="col-8">
                                                <h4 class="card-title">Pays : <?php echo $hotel['pays'];  ?></h4>
                                                <h4 class="card-title">Ville : <?php echo $hotel['ville'];  ?></h4>
                                                <h4 class="card-title">Tarif : <?php echo $hotel['tarif_unitaire']." DA/nuitée";  ?></h4>
                                                <p class="card-text"><?php echo substr($hotel['description'],0,230)."...";
                                                                         ?></p>
                                                <a href="consulterHotel.php?id=<?php echo $idHot; ?>" class="btn btn-lg btn-primary ">Details</a>
                                            </div>
                                        </div>
                                       
                                </div>
                </div>

                          <?php  }
                          //les numéros des pages
                          echo '<div class="container mt-5 mb-3 text-center">';
                            $previous = $pageActuelle-1;
                              if($previous > 0) {
                                echo "<a class='me-4' href='listeHotels.php?type=national&&page=$previous'><i class='fa-solid fa-angle-left'></i></a>";
                              }else {
                                echo "<a href='listeHotels.php?type=national&&page=$previous' style='visibility:hidden;'><i class='fa-solid fa-angle-left'></i></a>";
                              }
                               
                               for($i=1 ; $i<= $nbPages ; $i++) {
                                   if($pageActuelle==$i) {
                                    echo "<a class='btn btn-success me-2 ms-2' href='listeHotels.php?type=national&&page=$i'>$i</a>";
                                   }
                                   else {
                                    echo "<a class='btn btn-outline-success me-2 ms-2' href='listeHotels.php?type=national&&page=$i'>$i</a>";
                                   }
                                  
                                 }
                             $next = $pageActuelle+1;
                             if($next <= $nbPages) {
                                echo "<a class='ms-4' href='listeHotels.php?type=national&&page=$next'><i class='fa-solid fa-angle-right'></i></a>";
                             }
                             else {
                                echo "<a href='listeHotels.php?type=national&&page=$next' style='visibility:hidden;'><i class='fa-solid fa-angle-right'></i></a>";
                             }
                              
                         echo '</div>';
                         //Fin numéro de pages
                          
                        }
                        else {
                            aucunResultat("offre hotel national"); 
                        }
                         
                        }
                    ?>
                </div>
                <?php include $templates."footer.php";?>
            </div>
        </div>





      <?php  }
/////////////////////////////////////////////////////////
///////////////////////////////////////////////////

    if($type === "international") {
        //Récupérer toutes les villes internationales
        $requete = "SELECT DISTINCT ville, pays FROM hotel WHERE pays != 'Algerie' ORDER BY ville ASC";
        $sql = $connexion->prepare($requete);
        $sql->execute();
        //Récupérer le nombre total d'hotels internationaux existants
        $requete1 = "SELECT count(*) as nbHotels FROM hotel WHERE pays !='Algerie'";
        $sql1 = $connexion->prepare($requete1);
        $sql1->execute();
        $result1 = $sql1->fetch();
        //pagination
        $total = $result1['nbHotels'];
        $nbHotelParPage = 5;
        $nbPages = ceil($total/$nbHotelParPage);
        if(isset($_GET['page'])) {
            $pageActuelle = $_GET['page'];
        }
        else {
            $pageActuelle = 1;
        }
        if($pageActuelle < 1) {
            $pageActuelle = 1;
        }
        if($pageActuelle > $nbPages) {
            $pageActuelle = $nbPages;
        }
        $debut = $nbHotelParPage * ($pageActuelle-1);
        //Récupérer les hotels internationaux à afficher dans une seule page
        $requete2 = "SELECT * FROM hotel WHERE pays !='Algerie' ORDER BY nom_hotel ASC LIMIT $debut,5 ";//LIMIT prend 2 paramètres: le numéro de la ligne à partir de laquelle on veut afficher , le nbr de lignes à afficher
        $sql2 = $connexion->prepare($requete2);
        $sql2->execute();
        
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 mt-3">
                 <form method="POST" action="listeHotels.php?type=international">
                     <div class="mt-2 listeVille">
                        <label for="ville" class="form-label ms-4 mt-4">Veuillez choisir une ville</label>
                        <select name="ville" id="ville" class="form-select ms-4">
                            <option value="" selected>----</option>
                            <?php if($sql->rowCount() > 0) {
                                       $result = $sql->fetchAll();
                                        foreach($result as $hotel) {  ?>
                                            <option value="<?php echo $hotel['ville'];  ?>" > <?php echo $hotel['ville']." (".$hotel['pays'].")" ;  ?> </option>
                                         <?php  }
                                   }  ?>
                        </select>
                        <button name="search" type="submit" class="btn btn-sm btn-success ms-4" style="font-size:17px;">Rechercher</button>
                     </div>
                 </form>
                    
                </div>
                <div class="col-md-9">
                     <?php if(isset($_POST['search'])) {
                        $ville = $_POST['ville']; 
                        include "listeHotelParVille.php";
                        include $templates."footer.php";
                      }
                     else {  ?>
                    <h1 class="hotelNat text-center mb-2 mt-3">- Hotels Internationaux <span>(<?php echo $result1['nbHotels']; ?> résultats trouvés) -</span></h1>
                    <?php 
                        if($sql2->rowCount() > 0) {
                           echo "<h2 class='text-center mb-5'> - Page ".$pageActuelle." -</h2>";
                            
                           $result2 = $sql2->fetchAll();
                           foreach($result2 as $hotel) { 
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
                                                <img src="IMAGES/hotels/<?php echo $hotel['image1'];?>" alt="hotel" height="280px" width="300px">
                                            </div>
                                            <div class="col-8">
                                                <h4 class="card-title">Pays : <?php echo $hotel['pays'];  ?></h4>
                                                <h4 class="card-title">Ville : <?php echo $hotel['ville'];  ?></h4>
                                                <h4 class="card-title">Tarif : <?php echo $hotel['tarif_unitaire']." DA/nuitée";  ?></h4>
                                                <p class="card-text"><?php echo substr($hotel['description'],0,230)."...";
                                                                         ?></p>
                                                <a href="consulterHotel.php?id=<?php echo $idHot; ?>" class="btn btn-lg btn-primary">Details</a>
                                            </div>
                                        </div>
                                       
                                </div>
                </div>

                          <?php  }
                          //les numéros des pages
                          echo '<div class="container mt-5 mb-3 text-center">';
                            $previous = $pageActuelle-1;
                              if($previous > 0) {
                                echo "<a class='me-4' href='listeHotels.php?type=international&&page=$previous'><i class='fa-solid fa-angle-left'></i></a>";
                              }else {
                                echo "<a href='listeHotels.php?type=international&&page=$previous' style='visibility:hidden;'><i class='fa-solid fa-angle-left'></i></a>";
                              }
                               
                               for($i=1 ; $i<= $nbPages ; $i++) {
                                   if($pageActuelle==$i) {
                                    echo "<a class='btn btn-success me-2 ms-2' href='listeHotels.php?type=international&&page=$i'>$i</a>";
                                   }
                                   else {
                                    echo "<a class='btn btn-outline-success me-2 ms-2' href='listeHotels.php?type=international&&page=$i'>$i</a>";
                                   }
                                  
                                 }
                             $next = $pageActuelle+1;
                             if($next <= $nbPages) {
                                echo "<a class='ms-4' href='listeHotels.php?type=international&&page=$next'><i class='fa-solid fa-angle-right'></i></a>";
                             }
                             else {
                                echo "<a href='listeHotels.php?type=international&&page=$next' style='visibility:hidden;'><i class='fa-solid fa-angle-right'></i></a>";
                             }
                              
                         echo '</div>';
                         //Fin numéro de pages
                          
                        }
                        else {
                            aucunResultat("offre hotel international"); 
                        }
                         
                     }
                    ?>
                </div>
                <?php include $templates."footer.php";?>
            </div>
        </div>  
    <?php  }

    }
     ?>




