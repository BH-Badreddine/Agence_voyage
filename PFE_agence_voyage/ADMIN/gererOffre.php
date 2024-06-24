<?php  ob_start();
$pageTitle = "Gestion des offres";
include "init.php"; ?>

  <link rel="stylesheet" href="CSS/styleB.css">
</head>
<body>
 <?php  session_start();
 if(isset($_SESSION['admin']) && isset($_GET['type'])) {  
    include $templates."navbarAdmin.php";
     $type = $_GET['type'];
   if($type === "hotel") {
    if(isset($_GET['action'])) {
          $action = $_GET['action'];
      if($action === "ajouter") { ?>
              <div class="error container text-center mt-2">

              </div>
            <div class="container volForm">
                <h1 class="title text-center">Formulaire Ajouter offre hotel</h1>
          
                <form autocomplete="off" method="post" action="gererOffre.php?type=hotel&&action=ajouter" enctype="multipart/form-data">
                  <div class="mb-2" style="position:relative;">
                    <label for="nomh" class="form-label text-center">Nom hotel</label>
                    <input required name="nomh" type="text" class="form-control pad" id="nomh" placeholder="Entrer nom hotel" value="<?php echo @$_POST['nomh'];?>">
                  </div>
                  <div class="mb-2" style="position:relative;">
                    <label for="nbetoil" class="form-label">Nombre étoiles</label>
                    <input required name="nbetoil" type="number" min="0" max="5" class="form-control pad" id="nbetoil" placeholder="Entrer nombre étoiles" value="<?php echo @$_POST['nbetoil'];?>">
                  </div>
                  <div class="mb-2" style="position:relative;">
                    <label for="adress" class="form-label">Adresse</label>
                    <input required name="adress" type="text" class="form-control pad" id="adress" placeholder="Entrer adresse hotel" value="<?php echo @$_POST['adress'];?>" >
                  </div>
                  <div class="mb-2" style="position:relative;">
                    <label for="pays" class="form-label">Pays</label>
                    <input required name="pays" type="text" class="form-control pad" id="pays" placeholder="Entrer pays" value="<?php echo @$_POST['pays'];?>">
                  </div>
                  <div class="mb-2" style="position:relative;">
                    <label for="ville" class="form-label">Ville</label>
                    <input required name="ville" type="text" class="form-control pad" id="ville" placeholder="Entrer ville" value="<?php echo @$_POST['ville'];?>" >
                  </div>
                  <div class="mb-2" style="position:relative;">
                   <label for="floatingTextarea1">Description(Entrer texte...)</label>
                   <textarea required name="desc" class="form-control pad d-flex mx-auto" id="floatingTextarea1" style="height: 200px; width:70%;"><?php echo @$_POST['desc'];?></textarea> 
                  </div>
                  <div class="mb-2" style="position:relative;">
                    <label for="floatingTextarea2">Points forts(des tirets avec saut de ligne)</label>
                    <textarea required name="pointf" class="form-control pad d-flex mx-auto" id="floatingTextarea2" style="height: 200px; width:70%;""><?php echo @$_POST['pointf'];?></textarea>
                  </div>
                  <div class="mb-2 tarif" style="position:relative;">
                    <label for="tarif" class="form-label">Tarif unitaire (DZD/nuitée)</label>
                    <input required name="tarif" type="number" class="form-control pad" placeholder="tarif pour une nuitée en DA" id="tarif" value="<?php echo @$_POST['tarif']; ?>" >
                  </div> 
                  <div class="mb-2" style="position:relative;">
                    <label for="img" class="form-label text-center">Images</label>
                    <input  name="img1" type="file" class="form-control pad mb-2" id="img" placeholder="image1" >
                    <input  name="img2" type="file" class="form-control pad mb-2" id="img" placeholder="image2" >
                    <input  name="img3" type="file" class="form-control pad mb-2" id="img" placeholder="image3" >
                  </div>

                  <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                    <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                  </div>
          
                </form>
              </div>
        <?php   
        include $templates."footer.php";
        if(isset($_POST['valider'])) {  
          $nomh = transform(stripAccents($_POST['nomh']));
          $nbetoil = $_POST['nbetoil'];
          $adress = stripAccents(trim($_POST['adress']));
          $pays = transform(stripAccents($_POST['pays']));
          $ville = transform(stripAccents($_POST['ville']));
          $desc = stripAccents(trim($_POST['desc']));
          $pointf =stripAccents(trim($_POST['pointf']));
          $tarif = $_POST['tarif'];
            //list of allowed image extensions
          $imageExtensions = array("jpeg","jpg","png","gif");

          $images = array();//vecteur qui va contenir les noms de toutes les images
          $imagesTmp = array();//vecteur qui va contenir les tmp des images
          
          $errors = array();

          for($i=1 ; $i<=3 ; $i++) {
              @$imageName = $_FILES['img'.$i]['name'];
              @$imageSize = $_FILES['img'.$i]['size'];
              @$imageTmp = $_FILES['img'.$i]['tmp_name'];
              @$imageType = $_FILES['img'.$i]['type'];
              if(!empty($imageName)) {//l'image est sélectionnée
                //Get avatar extension
                @$imageExtension = strtolower(end(explode(".", $imageName)));
                  
                 if(in_array($imageExtension, $imageExtensions)) {//extension exists in allowed extensions
                      if(@$imageSize > 4194304) {//la taille de l'image dépasse 4 mégabytes=4194304bytes
                        array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Echec, image".$i." trés volumineuse</p>");
                          
                        }
                      else {//extension acceptée et taille acceptée
                        $image = rand(0, 10000000000000)."_". $imageName;
                         array_push($images,$image);
                         array_push($imagesTmp,$imageTmp);
                       }
                  }
                  else{
                    array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>L'extension de l'image".$i." n'est pas prise en compte</p>");
                      
                     }
               }
       
              else {
                array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>veuillez ajouter l'image".$i."</p>");
                  
                }
           }

           if(empty($errors)) {
              for($i=0;$i<=2;$i++) {
                  move_uploaded_file($imagesTmp[$i],"../IMAGES/hotels/".$images[$i]);//déplacer le fichier temporaire de l'image vers le dossier voulu
                }

              $requete = "INSERT INTO hotel(nom_hotel,adresse,description,points_forts,nbr_etoiles,tarif_unitaire,pays,ville,image1,image2,image3) VALUES (:nomh,:adress,:desc,:pointf,:nbetoil,:tarif,:pays,:ville,'$images[0]', '$images[1]', '$images[2]')";
              $sql = $connexion->prepare($requete);
              $sql->bindParam(":nomh",$nomh);
              $sql->bindParam(":adress",$adress);
              $sql->bindParam(":desc",$desc);
              $sql->bindParam(":pointf",$pointf);
              $sql->bindParam(":nbetoil",$nbetoil);
              $sql->bindParam(":tarif",$tarif);
              $sql->bindParam(":pays",$pays);
              $sql->bindParam(":ville",$ville);
              $sql->execute();

              if($sql->rowCount()==1) {  ?>
                <script>
                    alert(<?php echo $sql->rowCount();?>+" offre hotel ajoutée");
                </script>
                <?php header("refresh:1,url=accueilAdmin.php?page=liste_hotels&&type=hotel");
              }
            } else {  ?>
              
              <script>
                  var string = " " ;
                  <?php foreach($errors as $error) { ?>
                  string = string.concat(" ","<?php echo $error; ?>"); 
                  <?php   }  ?>
                  $("div.error").html(string);
              </script>
                 
            <?php   }

        }
      }
    
        /////////////////////////////////////////////
          if($action === "supprimer") {
             if(isset($_GET['id']))  {
              $idhot = $_GET['id'];
              $requete = "DELETE FROM hotel WHERE id_hotel='$idhot'";
              $sql = $connexion->prepare($requete);
              $sql->execute();
              header("Location: accueilAdmin.php?page=liste_hotels&&type=hotel");
             }
          }
        ////////////////////////////////////////////
          if($action === "modifier") {
              if(isset($_GET['id'])) {
                $idhot = $_GET['id'];
                $requete1 = "SELECT * FROM hotel WHERE id_hotel='$idhot' ";
                $sql1 = $connexion->prepare($requete1);
                $sql1->execute();
                if($sql1->rowCount() > 0) {
                  $result1 = $sql1->fetch();  ?>
                    <div class="error container text-center mt-2">

                    </div>
                    <div class="container volForm">
                      <h1 class="title text-center">Formulaire Modifier offre hotel</h1>

                       <form autocomplete="off" method="post" action="gererOffre.php?type=hotel&&action=modifier&&id=<?php echo $idhot;?>" enctype="multipart/form-data">
                          <div class="mb-2" style="position:relative;">
                            <label for="nomh" class="form-label text-center">Nom hotel</label>
                            <input required name="nomh" type="text" class="form-control pad" id="nomh" placeholder="Entrer nom hotel" value="<?php echo @$result1['nom_hotel'];?>">
                          </div>
                          <div class="mb-2" style="position:relative;">
                            <label for="nbetoil" class="form-label">Nombre étoiles</label>
                            <input required name="nbetoil" type="number" min="0" max="5" class="form-control pad" id="nbetoil" placeholder="Entrer nombre étoiles" value="<?php echo @$result1['nbr_etoiles'];?>">
                          </div>
                          <div class="mb-2" style="position:relative;">
                            <label for="adress" class="form-label">Adresse</label>
                            <input required name="adress" type="text" class="form-control pad" id="adress" placeholder="Entrer adresse hotel" value="<?php echo @$result1['adresse'];?>" >
                          </div>
                          <div class="mb-2" style="position:relative;">
                            <label for="pays" class="form-label">Pays</label>
                            <input required name="pays" type="text" class="form-control pad" id="pays" placeholder="Entrer pays" value="<?php echo @$result1['pays'];?>">
                          </div>
                          <div class="mb-2" style="position:relative;">
                            <label for="ville" class="form-label">Ville</label>
                            <input required name="ville" type="text" class="form-control pad" id="ville" placeholder="Entrer ville" value="<?php echo @$result1['ville'];?>" >
                          </div>
                          <div class="mb-2" style="position:relative;">
                            <label for="floatingTextarea1">Description(Entrer texte...)</label>
                            <textarea required name="desc" class="form-control pad d-flex mx-auto" id="floatingTextarea1" style="height: 200px; width:70%;"><?php echo @$result1['description'];?></textarea> 
                          </div>
                          <div class="mb-2" style="position:relative;">
                            <label for="floatingTextarea2">Points forts(des tirets avec saut de ligne)</label>
                            <textarea required name="pointf" class="form-control pad d-flex mx-auto" id="floatingTextarea2" style="height: 200px; width:70%;""><?php echo @$result1['points_forts'];?></textarea>
                          </div>
                          <div class="mb-2 tarif" style="position:relative;">
                            <label for="tarif" class="form-label">Tarif unitaire (DZD/nuitée)</label>
                            <input required name="tarif" type="number" class="form-control pad" placeholder="tarif pour une nuitée en DA" id="tarif" value="<?php echo @$result1['tarif_unitaire']; ?>" >
                          </div> 
                          <div class="mb-2" style="position:relative;">
                            <label for="img" class="form-label text-center">Images</label>
                            <input  name="img1" type="file" class="form-control pad mb-2" id="img" placeholder="image1" >
                            <input  name="img2" type="file" class="form-control pad mb-2" id="img" placeholder="image2" >
                            <input  name="img3" type="file" class="form-control pad mb-2" id="img" placeholder="image3" >
                          </div>

                          <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                              <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                          </div>

                        </form>
                    </div>
                  <?php     
                  include $templates."footer.php";
                  }
              if(isset($_POST['valider'])) {  
                    
                $nomh = transform(stripAccents($_POST['nomh']));
                $nbetoil = $_POST['nbetoil'];
                $adress = stripAccents(trim($_POST['adress']));
                $pays = transform(stripAccents($_POST['pays']));
                $ville = transform(stripAccents($_POST['ville']));
                $desc = stripAccents(trim($_POST['desc']));
                $pointf =stripAccents(trim($_POST['pointf']));
                $tarif = $_POST['tarif'];
                  //list of allowed image extensions
                  $imageExtensions = array("jpeg","jpg","png","gif");

                  $images = array();//vecteur qui va contenir les noms de toutes les images
                  $imagesTmp = array();//vecteur qui va contenir les tmp des images

                  $errors = array();

                 for($i=1 ; $i<=3 ; $i++) {
                  @$imageName = $_FILES['img'.$i]['name'];
                  @$imageSize = $_FILES['img'.$i]['size'];
                  @$imageTmp = $_FILES['img'.$i]['tmp_name'];
                  @$imageType = $_FILES['img'.$i]['type'];
                  if(!empty($imageName)) {//l'image est sélectionnée
                      //Get avatar extension
                      @$imageExtension = strtolower(end(explode(".", $imageName)));

                       if(in_array($imageExtension, $imageExtensions)) {//extension exists in allowed extensions
                          if(@$imageSize > 4194304) {//la taille de l'image dépasse 4 mégabytes=4194304bytes
                            array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Echec, image".$i." trés volumineuse</p>");
                             }
                          else {//extension acceptée et taille acceptée
                            $image = rand(0, 10000000000000)."_". $imageName;
                             array_push($images,$image);
                             array_push($imagesTmp,$imageTmp);
                            }
                        }
                        else{
                          array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>L'extension de l'image".$i." n'est pas prise en compte</p>");
                          }
                      }
                      else {
                         array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>veuillez ajouter l'image".$i."</p>");
    
                         }
                  }

                if(empty($errors)) {
                  for($i=0;$i<=2;$i++) {
                    move_uploaded_file($imagesTmp[$i],"../IMAGES/hotels/".$images[$i]);//déplacer le fichier temporaire de l'image vers le dossier voulu
                     }

                  $requete = "UPDATE hotel
                              SET nom_hotel=:nomh,
                                  adresse=:adress,
                                  description=:desc,
                                  points_forts=:pointf,
                                  nbr_etoiles=:nbetoil,
                                  tarif_unitaire=:tarif,
                                  pays=:pays,                           
                                  ville=:ville,
                                  image1='$images[0]',
                                  image2='$images[1]',
                                  image3='$images[2]'
                              WHERE id_hotel='$idhot'";
                              
                  $sql = $connexion->prepare($requete);
                  $sql->bindParam(":nomh",$nomh);
                  $sql->bindParam(":adress",$adress);
                  $sql->bindParam(":desc",$desc);
                  $sql->bindParam(":pointf",$pointf);
                  $sql->bindParam(":nbetoil",$nbetoil);
                  $sql->bindParam(":tarif",$tarif);
                  $sql->bindParam(":pays",$pays);
                  $sql->bindParam(":ville",$ville);
                  $sql->execute();
                    
                  if($sql->rowCount()==1) {  ?>
                    <script>
                        alert(<?php echo $sql->rowCount();?>+" offre hotel modifiée");
                    </script>
                    <?php header("refresh:1,url=accueilAdmin.php?page=liste_hotels&&type=hotel");
                    }
                    else {
                      echo "echec";
                    }

                } else {  ?>

                <script>
                    var string = " " ;
                    <?php foreach($errors as $error) { ?>
                    string = string.concat(" ","<?php echo $error; ?>"); 
                    <?php   }  ?>
                    $("div.error").html(string);
                </script>

                <?php   }
                     }     
            } else {
              rediriger();
            }
          } 
        }      
      }
   
 ////////////////////////////////////////////////
 ////////////////////////////////////////////
 if($type === "remise") {
  if(isset($_GET['action'])) {
        $action = $_GET['action'];
    if($action === "ajouter") { ?>
            <div class="error container text-center mt-2">

            </div>
            <div class="container volForm">
              <h1 class="title text-center">Formulaire Ajouter offre remise</h1>
        
              <form autocomplete="off" method="post" action="gererOffre.php?type=remise&&action=ajouter" enctype="multipart/form-data">
                <div class="mb-2" style="position:relative;">
                  <label for="nomrem" class="form-label text-center">Nom remise</label>
                  <input required name="nomrem" type="text" class="form-control pad" id="nomrem" placeholder="Entrer nom remise" value="<?php echo @$_POST['nomrem'];?>">
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="nbetoil" class="form-label">Nombre étoiles</label>
                  <input required name="nbetoil" type="number" min="0" max="5" class="form-control pad" id="nbetoil" placeholder="Entrer nombre étoiles" value="<?php echo @$_POST['nbetoil'];?>">
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="adress" class="form-label">Adresse</label>
                  <input required name="adress" type="text" class="form-control pad" id="adress" placeholder="Entrer adresse remise" value="<?php echo @$_POST['adress'];?>" >
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="pays" class="form-label">Pays</label>
                  <input required name="pays" type="text" class="form-control pad" id="pays" placeholder="Entrer pays" value="<?php echo @$_POST['pays'];?>">
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="ville" class="form-label">Ville</label>
                  <input required name="ville" type="text" class="form-control pad" id="ville" placeholder="Entrer ville" value="<?php echo @$_POST['ville'];?>" >
                </div>
                <div class="mb-2" style="position:relative;">
                      <label for="floatingTextarea1">Description(Entrer texte...)</label>
                      <textarea required name="desc" class="form-control pad d-flex mx-auto" id="floatingTextarea1" style="height: 200px; width:70%;"><?php echo @$_POST['desc'];?></textarea> 
                </div>
                <div class="mb-2" style="position:relative;">
                   <label for="floatingTextarea2">Points forts(des tirets avec saut de ligne)</label>
                   <textarea required name="pointf" class="form-control pad d-flex mx-auto" id="floatingTextarea2" style="height: 200px; width:70%;""><?php echo @$_POST['pointf'];?></textarea>
                </div>
                <div class="mb-2 tarif" style="position:relative;">
                  <label for="tarifavantrem" class="form-label">Tarif unitaire avant remise (DZD/nuitée)</label>
                  <input required name="tarifavantrem" type="number" class="form-control pad" placeholder="avant la remise" id="tarifavantrem" value="<?php echo @$_POST['tarifavantrem']; ?>" >
                </div> 
                <div class="mb-2 tarif" style="position:relative;">
                  <label for="tarifapresrem" class="form-label">Tarif unitaire après remise (DZD/nuitée)</label>
                  <input required name="tarifapresrem" type="number" class="form-control pad" placeholder="après la remise" id="tarifapresrem" value="<?php echo @$_POST['tarifapresrem']; ?>" >
                </div>
                <div class="mb-2 tarif" style="position:relative;">
                  <label for="pourcentage" class="form-label">pourcentage remise</label>
                  <input required name="pourcentage" type="number" min="0" max="100" class="form-control pad" id="pourcentage" placeholder="Entrer %" value="<?php echo @$_POST['pourcentage']; ?>"> 
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="dateDR" class="form-label">Date début remise</label>
                  <input required name="dateDR" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date debut remise" id="dateDR" value="<?php echo @$_POST['dateDR'];?>">
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="dateFR" class="form-label">Date fin remise</label>
                  <input required name="dateFR" type="date" min="<?php echo @$_POST['dateDR']; ?>" class="form-control pad" placeholder="Entrer date fin remise" id="dateFR" value="<?php echo @$_POST['dateFR']; ?>" >
                </div> 
                
                
                <div class="mb-2" style="position:relative;">
                  <label for="img" class="form-label text-center">Images</label>
                  <input  name="img1" type="file" class="form-control pad mb-2" id="img" placeholder="image1" >
                  <input  name="img2" type="file" class="form-control pad mb-2" id="img" placeholder="image2" >
                  <input  name="img3" type="file" class="form-control pad mb-2" id="img" placeholder="image3" >
                </div>

                <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                  <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                </div>
        
              </form>
            </div>
      <?php   
      include $templates."footer.php";
      if(isset($_POST['valider'])) {  
        $nomrem = transform(stripAccents($_POST['nomrem']));
        $nbetoil = $_POST['nbetoil'];
        $adress = stripAccents(trim($_POST['adress']));
        $pays = transform(stripAccents($_POST['pays']));
        $ville = transform(stripAccents($_POST['ville']));
        $desc = stripAccents(trim($_POST['desc']));
        $pointf =stripAccents(trim($_POST['pointf']));
        $tarifavantrem = $_POST['tarifavantrem'];
        $tarifapresrem = $_POST['tarifapresrem'];
        $pourcentage = $_POST['pourcentage'];
        $dateDR = $_POST['dateDR'];
        $dateFR = $_POST['dateFR'];

        

          //list of allowed image extensions
        $imageExtensions = array("jpeg","jpg","png","gif");

        $images = array();//vecteur qui va contenir les noms de toutes les images
        $imagesTmp = array();//vecteur qui va contenir les tmp des images
        
        $errors = array();

        for($i=1 ; $i<=3 ; $i++) {
            @$imageName = $_FILES['img'.$i]['name'];
            @$imageSize = $_FILES['img'.$i]['size'];
            @$imageTmp = $_FILES['img'.$i]['tmp_name'];
            @$imageType = $_FILES['img'.$i]['type'];
            if(!empty($imageName)) {//l'image est sélectionnée
              //Get avatar extension
              @$imageExtension = strtolower(end(explode(".", $imageName)));
                
               if(in_array($imageExtension, $imageExtensions)) {//extension exists in allowed extensions
                    if(@$imageSize > 4194304) {//la taille de l'image dépasse 4 mégabytes=4194304bytes
                      array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Echec, image".$i." trés volumineuse</p>");
                        
                      }
                    else {//extension acceptée et taille acceptée
                      $image = rand(0, 10000000000000)."_". $imageName;
                       array_push($images,$image);
                       array_push($imagesTmp,$imageTmp);
                     }
                }
                else{
                  array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>L'extension de l'image".$i." n'est pas prise en compte</p>");
                    
                   }
             }
     
            else {
              array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>veuillez ajouter l'image".$i."</p>");
                
              }
         }

         if(empty($errors)) {
            for($i=0;$i<=2;$i++) {
                move_uploaded_file($imagesTmp[$i],"../IMAGES/remises/".$images[$i]);//déplacer le fichier temporaire de l'image vers le dossier voulu
               }
              
            $requete = "INSERT INTO remise(nom_remise,adresse,description,points_forts,nbr_etoiles,pourcentage_red,tarif_avant_red,tarif_apres_red,date_debut_remise,date_fin_remise,pays,ville,image1,image2,image3) VALUES (:nomrem,:adress,:desc,:pointf,:nbetoil,:pourcentage,:tarifavantrem,:tarifapresrem,:dateDR,:dateFR,:pays,:ville,'$images[0]', '$images[1]', '$images[2]')";
            $sql = $connexion->prepare($requete);
            $sql->bindParam(":nomrem",$nomrem);
            $sql->bindParam(":adress",$adress);
            $sql->bindParam(":desc",$desc);
            $sql->bindParam(":pointf",$pointf);
            $sql->bindParam(":nbetoil",$nbetoil);
            $sql->bindParam(":pourcentage",$pourcentage);
            $sql->bindParam(":tarifavantrem",$tarifavantrem);
            $sql->bindParam(":tarifapresrem",$tarifapresrem);
            $sql->bindParam(":dateDR",$dateDR);
            $sql->bindParam(":dateFR",$dateFR);
            $sql->bindParam(":pays",$pays);
            $sql->bindParam(":ville",$ville);
            $sql->execute();

            if($sql->rowCount()==1) {  ?>
              <script>
                  alert(<?php echo $sql->rowCount();?>+" offre remise ajoutée");
              </script>
              <?php header("refresh:1,url=accueilAdmin.php?page=liste_remises&&type=remise");
            }else {
              echo "erreur";
            }
          } else {  ?>
            
            <script>
                var string = " " ;
                <?php foreach($errors as $error) { ?>
                string = string.concat(" ","<?php echo $error; ?>"); 
                <?php   }  ?>
                $("div.error").html(string);
            </script>
               
          <?php   }

      }
    }
  
      /////////////////////////////////////////////
        if($action === "supprimer") {
           if(isset($_GET['id']))  {
            $idrem = $_GET['id'];
            $requete = "DELETE FROM remise WHERE id_remise='$idrem'";
            $sql = $connexion->prepare($requete);
            $sql->execute();
            header("Location: accueilAdmin.php?page=liste_remises&&type=remise");
           }
        }
      ////////////////////////////////////////////
        if($action === "modifier") {
            if(isset($_GET['id'])) {
              $idrem = $_GET['id'];
              $requete1 = "SELECT * FROM remise WHERE id_remise='$idrem' ";
              $sql1 = $connexion->prepare($requete1);
              $sql1->execute();
              if($sql1->rowCount() > 0) {
                $result1 = $sql1->fetch();  ?>
                  <div class="error container text-center mt-2">

                  </div>
                  <div class="container volForm">
                    <h1 class="title text-center">Formulaire Modifier offre remise</h1>
        
                    <form autocomplete="off" method="post" action="gererOffre.php?type=remise&&action=modifier&&id=<?php echo $idrem;?>" enctype="multipart/form-data">
                      <div class="mb-2" style="position:relative;">
                        <label for="nomrem" class="form-label text-center">Nom remise</label>
                        <input required name="nomrem" type="text" class="form-control pad" id="nomrem" placeholder="Entrer nom remise" value="<?php echo @$result1['nom_remise'] ?>">
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="nbetoil" class="form-label">Nombre étoiles</label>
                        <input required name="nbetoil" type="number" min="0" max="5" class="form-control pad" id="nbetoil" placeholder="Entrer nombre étoiles" value="<?php echo @$result1['nbr_etoiles'];?>">
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="adress" class="form-label">Adresse</label>
                        <input required name="adress" type="text" class="form-control pad" id="adress" placeholder="Entrer adresse remise" value="<?php echo @$result1['adresse'];?>" >
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="pays" class="form-label">Pays</label>
                        <input required name="pays" type="text" class="form-control pad" id="pays" placeholder="Entrer pays" value="<?php echo @$result1['pays'];?>">
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="ville" class="form-label">Ville</label>
                        <input required name="ville" type="text" class="form-control pad" id="ville" placeholder="Entrer ville" value="<?php echo @$result1['ville'];?>" >
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="floatingTextarea1">Description(Entrer texte...)</label>
                        <textarea required name="desc" class="form-control pad d-flex mx-auto" id="floatingTextarea1" style="height: 200px; width:70%;"><?php echo @$result1['description'];?></textarea> 
                      </div>
                      <div class="mb-2" style="position:relative;">
                         <label for="floatingTextarea2">Points forts(des tirets avec saut de ligne)</label>
                         <textarea required name="pointf" class="form-control pad d-flex mx-auto" id="floatingTextarea2" style="height: 200px; width:70%;"><?php echo @$result1['points_forts'];?></textarea>
                      </div>
                      <div class="mb-2 tarif" style="position:relative;">
                        <label for="tarifavantrem" class="form-label">Tarif unitaire avant remise (DZD/nuitée)</label>
                        <input required name="tarifavantrem" type="number" class="form-control pad" placeholder="avant la remise" id="tarifavantrem" value="<?php echo @$result1['tarif_avant_red'] ?>" >
                      </div> 
                      <div class="mb-2 tarif" style="position:relative;">
                        <label for="tarifapresrem" class="form-label">Tarif unitaire après remise (DZD/nuitée)</label>
                        <input required name="tarifapresrem" type="number" class="form-control pad" placeholder="après la remise" id="tarifapresrem" value="<?php echo @$result1['tarif_apres_red'] ?>" >
                      </div>
                      <div class="mb-2 tarif" style="position:relative;">
                        <label for="pourcentage" class="form-label">pourcentage remise</label>
                        <input required name="pourcentage" type="number" min="0" max="100" class="form-control pad" id="pourcentage" placeholder="Entrer %" value="<?php echo @$result1['pourcentage_red'] ?>"> 
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="dateDR" class="form-label">Date début remise</label>
                        <input required name="dateDR" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date debut remise" id="dateDR" value="<?php echo @$result1['date_debut_remise']?>">
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="dateFR" class="form-label">Date fin remise</label>
                        <input required name="dateFR" type="date" min="<?php echo @$_POST['dateDR']; ?>" class="form-control pad" placeholder="Entrer date fin remise" id="dateFR" value="<?php echo @$result1['date_fin_remise'] ?>" >
                      </div> 
                      
                      
                      <div class="mb-2" style="position:relative;">
                        <label for="img" class="form-label text-center">Images</label>
                        <input  name="img1" type="file" class="form-control pad mb-2" id="img" placeholder="image1" >
                        <input  name="img2" type="file" class="form-control pad mb-2" id="img" placeholder="image2" >
                        <input  name="img3" type="file" class="form-control pad mb-2" id="img" placeholder="image3" >
                      </div>

                      <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                        <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                      </div>
                    </form>
                  </div>
                <?php     
                include $templates."footer.php";
                }
            if(isset($_POST['valider'])) {  
                    
                $nomrem = transform(stripAccents($_POST['nomrem']));
                $nbetoil = $_POST['nbetoil'];
                $adress = stripAccents(trim($_POST['adress']));
                $pays = transform(stripAccents($_POST['pays']));
                $ville = transform(stripAccents($_POST['ville']));
                $desc = stripAccents(trim($_POST['desc']));
                $pointf =stripAccents(trim($_POST['pointf']));
                $tarifavantrem = $_POST['tarifavantrem'];
                $tarifapresrem = $_POST['tarifapresrem'];
                $pourcentage = $_POST['pourcentage'];
                $dateDR = $_POST['dateDR'];
                $dateFR = $_POST['dateFR'];
                  //list of allowed image extensions
                  $imageExtensions = array("jpeg","jpg","png","gif");

                  $images = array();//vecteur qui va contenir les noms de toutes les images
                  $imagesTmp = array();//vecteur qui va contenir les tmp des images

                  $errors = array();

                 for($i=1 ; $i<=3 ; $i++) {
                  @$imageName = $_FILES['img'.$i]['name'];
                  @$imageSize = $_FILES['img'.$i]['size'];
                  @$imageTmp = $_FILES['img'.$i]['tmp_name'];
                  @$imageType = $_FILES['img'.$i]['type'];
                  if(!empty($imageName)) {//l'image est sélectionnée
                      //Get avatar extension
                      @$imageExtension = strtolower(end(explode(".", $imageName)));

                       if(in_array($imageExtension, $imageExtensions)) {//extension exists in allowed extensions
                          if(@$imageSize > 4194304) {//la taille de l'image dépasse 4 mégabytes=4194304bytes
                            array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Echec, image".$i." trés volumineuse</p>");
                             }
                          else {//extension acceptée et taille acceptée
                            $image = rand(0, 10000000000000)."_". $imageName;
                             array_push($images,$image);
                             array_push($imagesTmp,$imageTmp);
                            }
                        }
                        else{
                          array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>L'extension de l'image".$i." n'est pas prise en compte</p>");
                          }
                      }
                      else {
                         array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>veuillez ajouter l'image".$i."</p>");
    
                         }
                  }

                if(empty($errors)) {
                  for($i=0;$i<=2;$i++) {
                      move_uploaded_file($imagesTmp[$i],"../IMAGES/remises/".$images[$i]);//déplacer le fichier temporaire de l'image vers le dossier voulu
                     }

                     $requete = "UPDATE remise
                     SET nom_remise=:nomrem,
                         adresse=:adress,
                         description=:desc,
                         points_forts=:pointf,
                         nbr_etoiles=:nbetoil,
                         pourcentage_red=:pourcentage,
                         tarif_avant_red=:tarifavantrem,
                         tarif_apres_red=:tarifapresrem,
                         date_debut_remise=:dateDR,
                         date_fin_remise=:dateFR,
                         pays=:pays,
                         ville=:ville,
                         image1='$images[0]',
                         image2='$images[1]',
                         image3='$images[2]'
                     WHERE id_remise='$idrem'";

                     $sql = $connexion->prepare($requete);
                     $sql->bindParam(":nomrem",$nomrem);
                     $sql->bindParam(":adress",$adress);
                     $sql->bindParam(":desc",$desc);
                     $sql->bindParam(":pointf",$pointf);
                     $sql->bindParam(":nbetoil",$nbetoil);
                     $sql->bindParam(":pourcentage",$pourcentage);
                     $sql->bindParam(":tarifavantrem",$tarifavantrem);
                     $sql->bindParam(":tarifapresrem",$tarifapresrem);
                     $sql->bindParam(":dateDR",$dateDR);
                     $sql->bindParam(":dateFR",$dateFR);
                     $sql->bindParam(":pays",$pays);
                     $sql->bindParam(":ville",$ville);
                     $sql->execute();

                  if($sql->rowCount()==1) {  ?>
                    <script>
                        alert(<?php echo $sql->rowCount();?>+" offre remise modifiée");
                    </script>
                    <?php header("refresh:1,url=accueilAdmin.php?page=liste_remises&&type=remise");
                    }
                    else {
                      echo "echec";
                    }

                } else {  ?>

                <script>
                    var string = " " ;
                    <?php foreach($errors as $error) { ?>
                    string = string.concat(" ","<?php echo $error; ?>"); 
                    <?php   }  ?>
                    $("div.error").html(string);
                </script>

                <?php   }
             }     
          } else {
            rediriger();
          }
        } 
      }      
  }
 //////////////////////////////////////////////////
 ///////////////////////////////////////////////////
 if($type === "omra") {
  if(isset($_GET['action'])) {
      $action = $_GET['action'];
    if($action === "ajouter") { ?>
            <div class="error container text-center mt-2">

            </div>
          <div class="container volForm">
              <h1 class="title text-center">Formulaire Ajouter offre omra</h1>
        
              <form autocomplete="off" method="post" action="gererOffre.php?type=omra&&action=ajouter" enctype="multipart/form-data">
                <div class="mb-2" style="position:relative;">
                  <label for="intituleomra" class="form-label text-center">intitulé Omra</label>
                  <input required name="intituleomra" type="text" class="form-control pad" id="intituleomra" placeholder="Entrer nom omra" value="<?php echo @$_POST['intituleomra'];?>">
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="pays" class="form-label">Pays</label>
                  <input required name="pays" type="text" class="form-control pad" id="pays" placeholder="Entrer pays" value="<?php echo @$_POST['pays'];?>">
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="ville" class="form-label">Ville</label>
                  <input required name="ville" type="text" class="form-control pad" id="ville" placeholder="Entrer ville" value="<?php echo @$_POST['ville'];?>" >
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="floatingTextarea1">Description omra(Entrer texte...)</label>
                  <textarea required name="desc" class="form-control pad d-flex mx-auto" id="floatingTextarea1" style="height: 200px; width:70%;"><?php echo @$_POST['desc'];?></textarea>
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="floatingTextarea1">Programme(tirets avec saut de ligne)</label>
                  <textarea required name="programme" class="form-control pad d-flex mx-auto" id="floatingTextarea1" style="height: 200px; width:70%;"><?php echo @$_POST['programme'];?></textarea>
                </div>
              
                <div class="mb-2 tarif" style="position:relative;">
                  <label for="tarif" class="form-label">Tarif unitaire (DZD/nuitée)</label>
                  <input required name="tarif" type="number" class="form-control pad" placeholder="tarif pour une nuitée en DA" id="tarif" value="<?php echo @$_POST['tarif']; ?>" >
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="dateDO" class="form-label">Date début omra</label>
                  <input required name="dateDO" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date debut omra" id="dateDO" value="<?php echo @$_POST['dateDO'];?>">
                </div>
                <div class="mb-2" style="position:relative;">
                  <label for="dateFO" class="form-label">Date fin omra</label>
                  <input required name="dateFO" type="date" min="<?php echo @$_POST['dateDO']; ?>" class="form-control pad" placeholder="Entrer date fin omra" id="dateFO" value="<?php echo @$_POST['dateFO']; ?>" >
                </div>

                <div class="mb-2" style="position:relative;">
                  <label for="img" class="form-label text-center">Images</label>
                  <input  name="img1" type="file" class="form-control pad mb-2" id="img" placeholder="image1" >
                  <input  name="img2" type="file" class="form-control pad mb-2" id="img" placeholder="image2" >
                  <input  name="img3" type="file" class="form-control pad mb-2" id="img" placeholder="image3" >
                </div>

                <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                  <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                </div>
        
              </form>
            </div>
      <?php   
      include $templates."footer.php";
      if(isset($_POST['valider'])) {  
        $intitule = transform(stripAccents($_POST['intituleomra']));
        $pays = transform(stripAccents($_POST['pays']));
        $ville = transform(stripAccents($_POST['ville']));
        $desc = stripAccents(trim($_POST['desc']));
        $programme = stripAccents(trim($_POST['programme']));
        $tarif = $_POST['tarif'];
        $dateDO = $_POST['dateDO'];
        $dateFO = $_POST['dateFO'];
          //list of allowed image extensions
        $imageExtensions = array("jpeg","jpg","png","gif");

        $images = array();//vecteur qui va contenir les noms de toutes les images
        $imagesTmp = array();//vecteur qui va contenir les tmp des images
        
        $errors = array();

        for($i=1 ; $i<=3 ; $i++) {
            @$imageName = $_FILES['img'.$i]['name'];
            @$imageSize = $_FILES['img'.$i]['size'];
            @$imageTmp = $_FILES['img'.$i]['tmp_name'];
            @$imageType = $_FILES['img'.$i]['type'];
            if(!empty($imageName)) {//l'image est sélectionnée
              //Get avatar extension
              @$imageExtension = strtolower(end(explode(".", $imageName)));
                
               if(in_array($imageExtension, $imageExtensions)) {//extension exists in allowed extensions
                    if(@$imageSize > 4194304) {//la taille de l'image dépasse 4 mégabytes=4194304bytes
                      array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Echec, image".$i." trés volumineuse</p>");
                        
                      }
                    else {//extension acceptée et taille acceptée
                      $image = rand(0, 10000000000000)."_". $imageName;
                       array_push($images,$image);
                       array_push($imagesTmp,$imageTmp);
                     }
                }
                else{
                  array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>L'extension de l'image".$i." n'est pas prise en compte</p>");
                    
                   }
             }
     
            else {
              array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>veuillez ajouter l'image".$i."</p>");
                
              }
         }

         if(empty($errors)) {
            for($i=0;$i<=2;$i++) {
                move_uploaded_file($imagesTmp[$i],"../IMAGES/omra/".$images[$i]);//déplacer le fichier temporaire de l'image vers le dossier voulu
               }

            $requete = "INSERT INTO omra(intitule,programme,description,tarif_une_personne,date_debut_omra,date_fin_omra,pays,ville,image1,image2,image3) VALUES (:intitule,:programme,:desc,:tarif,:dateDO,:dateFO,:pays,:ville,'$images[0]', '$images[1]', '$images[2]')";
            $sql = $connexion->prepare($requete);
            $sql->bindParam(":intitule",$intitule);
            $sql->bindParam(":desc",$desc);
            $sql->bindParam(":dateDO",$dateDO);
            $sql->bindParam(":dateFO",$dateFO);
            $sql->bindParam(":tarif",$tarif);
            $sql->bindParam(":programme",$programme);
            $sql->bindParam(":pays",$pays);
            $sql->bindParam(":ville",$ville);
            $sql->execute();

            if($sql->rowCount()==1) {  ?>
              <script>
                  alert(<?php echo $sql->rowCount();?>+" offre omra ajoutée");
              </script>
              <?php header("refresh:1,url=accueilAdmin.php?page=liste_omras&&type=omra");
            }else {
              echo "erreur";
            }
          } else {  ?>
            
            <script>
                var string = " " ;
                <?php foreach($errors as $error) { ?>
                string = string.concat(" ","<?php echo $error; ?>"); 
                <?php   }  ?>
                $("div.error").html(string);
            </script>
               
          <?php   }

      }
    }
  
      /////////////////////////////////////////////
        if($action === "supprimer") {
           if(isset($_GET['id']))  {
            $idomra = $_GET['id'];
            $requete = "DELETE FROM omra WHERE id_omra='$idomra'";
            $sql = $connexion->prepare($requete);
            $sql->execute();
            header("Location: accueilAdmin.php?page=liste_omras&&type=omra");
           }
        }
      ////////////////////////////////////////////
        if($action === "modifier") {
          if(isset($_GET['id'])) {
              $idomra = $_GET['id'];
              $requete1 = "SELECT * FROM omra WHERE id_omra='$idomra' ";
              $sql1 = $connexion->prepare($requete1);
              $sql1->execute();
              if($sql1->rowCount() > 0) {
                $result1 = $sql1->fetch();  ?>
                  <div class="error container text-center mt-2">

                  </div>
                  <div class="container volForm">
                    <h1 class="title text-center">Formulaire Modifier offre omra</h1>
              
                    <form autocomplete="off" method="post" action="gererOffre.php?type=omra&&action=modifier&&id=<?php echo $idomra;?>" enctype="multipart/form-data">
                      <div class="mb-2" style="position:relative;">
                        <label for="intituleomra" class="form-label text-center">intitulé Omra</label>
                        <input required name="intituleomra" type="text" class="form-control pad" id="intituleomra" placeholder="Entrer nom omra" value="<?php echo @$result1['intitule'];?>">
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="pays" class="form-label">Pays</label>
                        <input required name="pays" type="text" class="form-control pad" id="pays" placeholder="Entrer pays" value="<?php echo @$result1['pays'];?>">
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="ville" class="form-label">Ville</label>
                        <input required name="ville" type="text" class="form-control pad" id="ville" placeholder="Entrer ville" value="<?php echo  @$result1['ville'];?>" >
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="floatingTextarea1">Description omra(Entrer texte...)</label>
                        <textarea required name="desc" class="form-control pad d-flex mx-auto" id="floatingTextarea1" style="height: 200px; width:70%;"><?php echo @$result1['description'];?></textarea>
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="floatingTextarea1">Programme(tirets avec saut de ligne)</label>
                        <textarea required name="programme" class="form-control pad d-flex mx-auto" id="floatingTextarea1" style="height: 200px; width:70%;"><?php echo @$result1['programme'];?></textarea>
                      </div>
                    
                      <div class="mb-2 tarif" style="position:relative;">
                        <label for="tarif" class="form-label">Tarif unitaire (DZD/nuitée)</label>
                        <input required name="tarif" type="number" class="form-control pad" placeholder="tarif pour une nuitée en DA" id="tarif" value="<?php echo @$result1['tarif_une_personne'] ?>" >
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="dateDO" class="form-label">Date début omra</label>
                        <input required name="dateDO" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control pad" placeholder="Entrer date debut omra" id="dateDO" value="<?php echo @$result1['date_debut_omra'];?>">
                      </div>
                      <div class="mb-2" style="position:relative;">
                        <label for="dateFO" class="form-label">Date fin omra</label>
                        <input required name="dateFO" type="date" min="<?php echo @$_POST['dateDO']; ?>" class="form-control pad" placeholder="Entrer date fin omra" id="dateFO" value="<?php echo @$result1['date_fin_omra'] ?>" >
                      </div>

                      <div class="mb-2" style="position:relative;">
                        <label for="img" class="form-label text-center">Images</label>
                        <input  name="img1" type="file" class="form-control pad mb-2" id="img" placeholder="image1" >
                        <input  name="img2" type="file" class="form-control pad mb-2" id="img" placeholder="image2" >
                        <input  name="img3" type="file" class="form-control pad mb-2" id="img" placeholder="image3" >
                      </div>

                      <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
                        <button name="valider" type="submit" class="btn btn-primary btn-lg mb-3" style="font-size:23px;">Enregistrer</button>
                      </div>
              
                    </form>
                  </div>
                <?php     
                include $templates."footer.php";
                }
            if(isset($_POST['valider'])) {  
                  
              $intitule = transform(stripAccents($_POST['intituleomra']));
              $pays = transform(stripAccents($_POST['pays']));
              $ville = transform(stripAccents($_POST['ville']));
              $desc = stripAccents(trim($_POST['desc']));
              $programme = stripAccents(trim($_POST['programme']));
              $tarif = $_POST['tarif'];
              $dateDO = $_POST['dateDO'];
              $dateFO = $_POST['dateFO'];

                //list of allowed image extensions
                $imageExtensions = array("jpeg","jpg","png","gif");

                $images = array();//vecteur qui va contenir les noms de toutes les images
                $imagesTmp = array();//vecteur qui va contenir les tmp des images

                $errors = array();

               for($i=1 ; $i<=3 ; $i++) {
                @$imageName = $_FILES['img'.$i]['name'];
                @$imageSize = $_FILES['img'.$i]['size'];
                @$imageTmp = $_FILES['img'.$i]['tmp_name'];
                @$imageType = $_FILES['img'.$i]['type'];
                if(!empty($imageName)) {//l'image est sélectionnée
                    //Get image extension
                    @$imageExtension = strtolower(end(explode(".", $imageName)));

                     if(in_array($imageExtension, $imageExtensions)) {//extension exists in allowed extensions
                        if(@$imageSize > 4194304) {//la taille de l'image dépasse 4 mégabytes=4194304bytes
                          array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Echec, image".$i." trés volumineuse</p>");
                           }
                        else {//extension acceptée et taille acceptée
                          $image = rand(0, 10000000000000)."_". $imageName;
                           array_push($images,$image);
                           array_push($imagesTmp,$imageTmp);
                          }
                      }
                      else{
                        array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>L'extension de l'image".$i." n'est pas prise en compte</p>");
                        }
                    }
                    else {
                       array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>veuillez ajouter l'image".$i."</p>");
  
                       }
                }

              if(empty($errors)) {
                for($i=0;$i<=2;$i++) {//imagesTmp: vecteur des images temporaires(non uploadées)
                  //images: vecteur contenant les noms des images
                    move_uploaded_file($imagesTmp[$i],"../IMAGES/omra/".$images[$i]);//déplacer le fichier temporaire de l'image vers le dossier voulu
                   }

                   $requete = "UPDATE omra
                   SET intitule=:intitule,
                       programme= :programme,
                       description=:desc,
                       tarif_une_personne=:tarif,
                       date_debut_omra=:dateDO,
                       date_fin_omra=:dateFO,
                       pays=:pays,                           
                       ville=:ville,
                       image1='$images[0]',
                        image2='$images[1]',
                         image3='$images[2]'
                   WHERE id_omra='$idomra'";
                   $sql = $connexion->prepare($requete);
                   $sql->bindParam(":intitule",$intitule);
                   $sql->bindParam(":desc",$desc);
                   $sql->bindParam(":dateDO",$dateDO);
                   $sql->bindParam(":dateFO",$dateFO);
                   $sql->bindParam(":tarif",$tarif);
                   $sql->bindParam(":programme",$programme);
                   $sql->bindParam(":pays",$pays);
                   $sql->bindParam(":ville",$ville);
                   $sql->execute();

                if($sql->rowCount()==1) {  ?>
                  <script>
                      alert(<?php echo $sql->rowCount();?>+" offre omra modifiée");
                  </script>
                  <?php header("refresh:1,url=accueilAdmin.php?page=liste_omras&&type=omra");
                  }
                  else {
                    echo "echec";
                  }

              } else {  ?>

              <script>
                  var string = " " ;
                  <?php foreach($errors as $error) { ?>
                  string = string.concat(" ","<?php echo $error; ?>"); 
                  <?php   }  ?>
                  $("div.error").html(string);
              </script>

              <?php   }
              }     
          }else{
            rediriger();
          }
        } 
      }      
    }

} else {
 rediriger();
}
ob_end_flush();