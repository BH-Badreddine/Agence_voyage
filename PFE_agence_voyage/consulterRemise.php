<?php  if(isset($_GET['id'])) {
      include "INCLUDES/Templates/connexionBDD.php";
         $idRemise = $_GET['id'];
         $requete = "SELECT * FROM remise WHERE id_remise='$idRemise'";
         $sql = $connexion->prepare($requete);
         $sql->execute();
        if($sql->rowCount() > 0) {
           $result = $sql->fetch();
           $pageTitle = $result['nom_remise'];
           include "INCLUDES/Functions/functions.php";
           include "INCLUDES/Templates/header.php"; ?>
           <link rel="stylesheet" href="CSS/styleBB.css">
         </head>
         <body>
           <?php  session_start();
           if(isset($_SESSION['clientId'])) {
             include  "INCLUDES/Templates/navbarClient.php";
           } else {
             include "INCLUDES/Templates/navbarVisiteur.php";
           } 
           echo "<a style='position:sticky; top:85px; z-index: 2;' class='btn btn-success' href='listeRemise.php'>Aller à Liste remises</a>";
           ?>
          <div class="container">
            <?php 
              if($result['nbr_etoiles'] != 0) {
                echo "<h1 class='display-5 title mt-1 ms-2'>". $result['nom_remise']."&nbsp;&nbsp;&nbsp;" ;
                echo "<span>"; 
                for($i=1 ; $i<=$result['nbr_etoiles'] ; $i++) {
                  echo "<i class='fa-solid fa-star mb-3'></i>";
                }
                echo "</span>";
                echo "</h1>";
              } else {
                echo "<h1 class='display-4 title mt-1 ms-2'>". $result['nom_remise'] ."</h1>";
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
                  <img src="IMAGES/remises/<?php echo $result['image1'];?>" class="d-block  w-100" height="400px" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                  <img src="IMAGES/remises/<?php echo $result['image2'];?>" class="d-block w-100" height="400px" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                  <img src="IMAGES/remises/<?php echo $result['image3'];?>" class="d-block w-100" height="400px" alt="...">
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
              <a style="font-size:28px;" href="reserverOffre.php?type=remise&&id=<?php echo $result['id_remise']; ?>" class="btn btn-warning">Reserver</a>
            </div>
            <h3 class='ms-2 mt-2 mb-4'>Période : du <?php echo date('d M Y', strtotime($result['date_debut_remise']));?> au <?php echo date('d M Y', strtotime($result['date_fin_remise']));?></h3>

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
                  <p>à partir de <span class='tarif '><?php echo $result['tarif_apres_red']; ?> DZD <s><?php echo $result['tarif_avant_red']; ?>DZD</s> </span></p>
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
              <form method="POST" action="consulterRemise.php?id=<?php echo $idRemise; ?>#AffTarif">
                  <label for="nbPers" class="form-label">Entrer nombre de personnes</label>
                  <input id="nbPers" name="personne" type="number" class="form-control " value="<?php echo @$_POST   ['personne']; ?>" required>
                  <input name="cal" type="submit" value="Calculer" class="btn btn-primary ms-3" >
              </form>
              <hr class="w-70 text-center ">
              <label class="form-label offset-3">Le séjour vous coûtera à partir de</label> <input class="tarif form-control " type="number"> <label class="form-label" style="margin-left:-20px;">DZD</label>
            </div>
        </div>
        <br>
            <?php  include "INCLUDES/Templates/footer.php";
            if(isset($_POST['cal'])) {
                $nbPers = $_POST['personne'];
                $tarifTotal = $result['tarif_apres_red'] * $nbPers ;
                  ?>
                  <script>
                  let tarif = <?php echo (string)$tarifTotal; ?>;
                    $("input.tarif").attr('value', tarif);
                </script> 
              
              <?php  }
    }
}?>

