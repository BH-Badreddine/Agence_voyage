<?php 
$pageTitle = "Accueil";
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
    ?>
<div id="carouselExampleCaptions" class="carousel firstcarousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="2000">
      <img src="IMAGES/hotels/2393103100533_SheratonAnnaba2.jpg" height="500px"  class="d-block w-100" alt="indonésie">
      <div class="carousel-caption d-none d-md-block ">
        <h5 class="topDest">Sheraton Annaba Hotel</h5>
        <p>- Algérie Annaba -</p> <?php $nomh = transform(stripAccents("Sheraton Annaba Hotel")); ?>
        <div class="d-grid gap-2 col-6 mx-auto mt-1 mb-2">
          <a href="consulterHotel.php?nom=<?php echo $nomh; ?>" class="btn btn-warning">Details</a>
        </div>
      </div>
    </div>
    <div class="carousel-item " data-bs-interval="2000">
      <img src="IMAGES/hotels/3107482039610_sol-azur-beach2.jpg" height="500px" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block ">
        <h5 class="topDest">Sol Azur Beach Hotel</h5>
        <p>- Tunisie Hammamet -</p> <?php $nomh = transform(stripAccents("Sol Azur Beach Hotel")); ?>
        <div class="d-grid gap-2 col-6 mx-auto mt-1 mb-2">
          <a href="consulterHotel.php?nom=<?php echo $nomh; ?>" class="btn btn-warning">Details</a>
        </div>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="IMAGES/hotels/6860113698231_sol-oasis-marrakech1.jpg" height="500px" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="topDest">Sol Oasis Marrakech</h5>
        <p>- Maroc Marrakech -</p> <?php $nomh = transform(stripAccents("Sol Oasis Marrakech")); ?>
        <div class="d-grid gap-2 col-6 mx-auto mt-1 mb-2">
          <a href="consulterHotel.php?nom=<?php echo $nomh; ?>" class="btn btn-warning">Details</a>
        </div>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
   
<h1 class="title text-center" id="DESTPOP">Destinations populaires</h1>
<div class="d-flex justify-content-center">
    <i class="fa-solid fa-circle blue"></i>
    <i class="fa-solid fa-circle yellow"></i>
    <i class="fa-solid fa-circle gray"></i>
</div>

<div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="true">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="2500">
      <div class="row d-flex justify-content-center">
          <div class="col-3">
           <div class="card cardVille" style="width: 19rem;height: 350px;">
               <img src="IMAGES/paris.png" height="200px" class="card-img-top" alt="...">
               <div class="card-body">
                 <h3 class="card-title text-center">Paris</h3>
                 <div class="d-grid gap-2 col-6 mx-auto mt-3 mb-1">
                    <a href="destinationPopulaire.php?ville=Paris" class="btn btn-primary">Consulter</a>
                 </div>
               </div>
           </div>
         </div>
         <div class="col-3">
           <div class="card cardVille" style="width: 19rem;height: 350px;">
               <img src="IMAGES/Madrid.jpg" height="200px" class="card-img-top" alt="...">
               <div class="card-body">
                 <h3 class="card-title text-center">Madrid</h3>
                 <div class="d-grid gap-2 col-6 mx-auto mt-3 mb-1">
                    <a href="destinationPopulaire.php?ville=Madrid" class="btn btn-primary">Consulter</a>
                 </div>
               </div>
           </div>
         </div>
         <div class="col-3">
           <div class="card cardVille" style="width: 19rem;height: 350px;">
               <img src="IMAGES/Istanbul.jpg" height="200px" class="card-img-top" alt="...">
               <div class="card-body">
                 <h3 class="card-title text-center">Istanbul</h3>
                 <div class="d-grid gap-2 col-6 mx-auto mt-3 mb-1">
                    <a href="destinationPopulaire.php?ville=Istanbul" class="btn btn-primary">Consulter</a>
                 </div>
               </div>
           </div>
         </div>
      </div>
    </div>



    <div class="carousel-item" data-bs-interval="2500">
     <div class="row d-flex justify-content-center">
        <div class="col-4 offset-1">
           <div class="card cardVille" style="width: 19rem;height: 350px;">
               <img src="IMAGES/Dubai.jpg" height="200px" class="card-img-top" alt="...">
               <div class="card-body">
                 <h3 class="card-title text-center">Dubai</h3>
                 <div class="d-grid gap-2 col-6 mx-auto mt-3 mb-1">
                    <a href="destinationPopulaire.php?ville=Dubai" class="btn btn-primary">Consulter</a>
                 </div>
               </div>
           </div>
         </div>
         <div class="col-4 offset-1">
           <div class="card cardVille" style="width: 19rem;height: 350px;">
               <img src="IMAGES/Londres.jpg" height="200px" class="card-img-top" alt="...">
               <div class="card-body">
                 <h3 class="card-title text-center">Londres</h3>
                 <div class="d-grid gap-2 col-6 mx-auto mt-3 mb-1">
                    <a href="destinationPopulaire.php?ville=Londres" class="btn btn-primary">Consulter</a>
                 </div>
               </div>
           </div>
         </div>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span style="background-color:#00acb0 !important;" class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span style="background-color:#00acb0 !important;" class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<h1 class="title text-center">Les hôtels les mieux notés</h1>
<div class="d-flex justify-content-center">
    <i class="fa-solid fa-circle blue"></i>
    <i class="fa-solid fa-circle yellow"></i>
    <i class="fa-solid fa-circle gray"></i>
</div>
<?php $requete = "SELECT id_hotel, nom_hotel, nbr_etoiles, image1 FROM hotel ORDER BY nbr_etoiles DESC LIMIT 5";
      $sql = $connexion->prepare($requete);
      $sql->execute();
      if($sql->rowCount() > 0) {
        $result = $sql->fetchAll();  ?>
        <div class="container mt-3">
           <div class="row d-flex justify-content-evenly flex-wrap">
              <?php  foreach($result as $hotel) {
                      $idHot = $hotel['id_hotel'];
                      echo "<div class='col-3 topHotel mt-3'>";  ?>
                        <img src='IMAGES/hotels/<?php echo $hotel['image1']; ?>' height='220px' width='280px'>
                        <?php echo "<h3 class='text-center'>".$hotel['nom_hotel']."</h3>";
                         echo "<div class='text-center'>";
                         for($i=1 ; $i<=$hotel['nbr_etoiles'] ; $i++) {
                          echo "<i class='fa-solid fa-star'></i>";
                           }
                         echo "</div>";
                        echo "<div class='d-grid gap-2 col-6 mx-auto mt-4'>";  
                           echo "<a class='btn btn-warning ' href='consulterHotel.php?id=$idHot'>Voir plus</a>";
                        echo "</div>";
                      echo "</div>";
                      }
                    }
              ?>
           </div>
        </div>

<h1 class="title text-center" id="etapesRes">Comment réserver dans notre site ?</h1>
<div class="d-flex justify-content-center">
    <i class="fa-solid fa-circle blue"></i>
    <i class="fa-solid fa-circle yellow"></i>
    <i class="fa-solid fa-circle gray"></i>
</div>

<div class="container-fluid mt-3">
    <div class="row d-flex justify-content-evenly">
      <div class="col-3" style="position:relative;">
        <p>
          <div class="etapeReservation" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample1" aria-expanded="false" aria-controls="collapseWidthExample">
             1
          </div>
        </p>
        <div class="detailsEtape" style="height: 120px;">
          <div class="collapse collapse-horizontal" id="collapseWidthExample1">
            <div class="card card-body" style="width: 300px;">
                 <p class="text-center">Créer un compte </p>
            </div>
          </div>
        </div>
     </div>
    
      <div class="col-3" style="position:relative;">
        <p>
          <div class="etapeReservation" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample2" aria-expanded="false" aria-controls="collapseWidthExample">
             2
          </div>
        </p>
        <div class="detailsEtape" style="height: 120px;">
          <div class="collapse collapse-horizontal" id="collapseWidthExample2">
            <div class="card card-body" style="width: 300px;">
               <p class="text-center">Sélectionner une offre puis réserver en un clic</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-3" style="position:relative;">
        <p>
          <div class="etapeReservation" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample3" aria-expanded="false" aria-controls="collapseWidthExample">
             3
          </div>
        </p>
        <div class="detailsEtape" style="height: 120px;">
          <div class="collapse collapse-horizontal" id="collapseWidthExample3">
            <div class="card card-body" style="width: 300px;">
                <p class="text-center">Remplir le formulaire (par vos propres coordonées) et le valider</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-3" style="position:relative;">
        <p>
          <div class="etapeReservation" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample4" aria-expanded="false" aria-controls="collapseWidthExample">
             4
          </div>
        </p>
        <div class="detailsEtape" style="height: 120px;">
          <div class="collapse collapse-horizontal" id="collapseWidthExample4">
            <div class="card card-body" style="width: 300px;">
                  <p class="text-center">Confirmer avec l'agence (par Tél ou email) dans un délais de 48h</p>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
      



  

<div class="alert alert-success w-50 mx-auto mt-4 text-center" >
  <p class="remarque">N.B pour une réservation vol, il suffit de créer un compte, remplir le formulaire, le valider puis confirmer avec l'agence de voyage</p>
</div>


<?php  include $templates . "footer.php"; ?>