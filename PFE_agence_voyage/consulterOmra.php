<?php  if(isset($_GET['id'])) {
      include "INCLUDES/Templates/connexionBDD.php";
         $idOmra = $_GET['id'];
         $requete = "SELECT * FROM omra WHERE id_omra='$idOmra'";
         $sql = $connexion->prepare($requete);
         $sql->execute();
         if($sql->rowCount() > 0) {
           $result = $sql->fetch();
           $pageTitle = $result['intitule'];
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
           echo "<a style='position:sticky; top:85px; z-index: 2;' class='btn btn-success' href='listeOmra.php'>Revenir à Liste Omra</a>";
           ?>
           <div class="container">
               <h1 class="title mt-1 ms-0"><?php echo $result['intitule'];?></h1>
               
               <div id="carouselExampleIndicators" class="mx-auto carousel slide carousel-fade" data-bs-ride="true">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="2000">
                    <img src="IMAGES/omra/<?php echo $result['image1'];?>" class="d-block  w-100" height="400px" alt="...">
                  </div>
                  <div class="carousel-item" data-bs-interval="2000">
                    <img src="IMAGES/omra/<?php echo $result['image2'];?>" class="d-block w-100" height="400px" alt="...">
                 </div>
                 <div class="carousel-item" data-bs-interval="2000">
                   <img src="IMAGES/omra/<?php echo $result['image3'];?>" class="d-block w-100" height="400px" alt="...">
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
                 <a style="font-size:28px;" href="reserverOffre.php?type=omra&&id=<?php echo $result['id_omra']; ?>" class="btn btn-warning">Reserver</a>
               </div>
               <h3 class='ms-2 mt-2 mb-4'>Période : du <?php echo date('d M Y', strtotime($result['date_debut_omra']));?> au <?php echo date('d M Y', strtotime($result['date_fin_omra']));?></h3>
               
               <div class="container descOmra">
                  <h2>Description</h2> 
                  <hr class="float-start mt-1 mb-1 w-100">
                  <p><?php echo $result['description'];  ?></p>
               </div>
               <div class="row">
                 <div class="col-7">
                    <div class="programme mt-3">
                        <h2 class="ms-2" style="font-family: 'Source Serif Pro', serif; font-weight:bold;">Programme</h2>
                        <hr class="float-start mt-1 mb-3 w-100">
                        <?php echo programme($result['programme'], '<img src="IMAGES/kaabaLogo.jpg" class="rounded-circle me-2 mt-2" height="50px" width="60px">'); ?> 
                    </div>
                 </div>
                 <div class="col-5">
                     <div class="divTarif text-center mt-3">
                        <h2 style="font-family: 'Source Serif Pro', serif;font-weight:bold;">Tarif total</h2>
                        <hr class="float-start mt-1 mb-3 w-100">
                        <p>à partir de <span class='tarif '><?php echo $result['tarif_une_personne']; ?> DZD</span></p>
                        <p style="text-align: left;" class="ms-3">Ce forfait inclut : 
                          <ul>
                             <li>Vol régulier</li>
                             <li>Accueil par notre correspondant local Saoudien</li>
                             <li>Transfert Médine/La Mecque et La Mecque/Jeddah en bus climatisé</li>
                             <li>Logement dans les hotels à Médine et à la Mecque</li>
                             <li>Visites religieuses incluses</li>
                             <li>Petit déjeuner inclus</li> 
                          </ul> 
                        </p>
                        <h3><i class="fa-solid fa-phone"></i>Mobile:+213 559 627 691</h3>
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
                  <form method="POST" action="consulterOmra.php?id=<?php echo $idOmra; ?>#AffTarif">
                     <label for="nbPers" class="form-label">Entrer nombre de personnes</label>
                     <input id="nbPers" name="personne" type="number" class="form-control " value="<?php echo @$_POST   ['personne']; ?>" required>
                     <input name="cal" type="submit" value="Calculer" class="btn btn-primary ms-3" >
                  </form>
                  <hr class="w-70 text-center ">
                  <label class="form-label offset-3">Le séjour vous coûtera à partir de</label> <input class="tarif form-control " type="number"> <label class="form-label" style="margin-left:-20px;">DZD</label>
                </div>

                <div class="container omraInfo">
                  <h1 class="title text-center">Info utiles pour omra</h1>
                  <div class="d-flex justify-content-center">
                      <i class="fa-solid fa-circle blue"></i>
                      <i class="fa-solid fa-circle yellow"></i>
                      <i class="fa-solid fa-circle gray"></i>
                  </div>

                <div class="accordion mt-3" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Qu'est-ce qu'une 'Omra ? Quel est son déroulement ?
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"   data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        La 'Omra commence par la prise d'Ihram. Il lui est conseillé, d'abord, de couper ses cheveux ; de se couper les ongles, de prendre un bain, de faire le Ghusl ; puis, de se vêtir d'un 'izâr et d'un ridâ' -ce sont deux pièces de tissu blanc sans coutures, propres et préférablement nouvelles-, de se parfumer et de prier enfin deux raka` au Mîqât. Vous devez alors commencer à prononcer la Talbiyya.
                        </div>
                    </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Combien de temps doit-on disposer pour effectuer une 'Omra ?
                      </button>
                      </h2>
                      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                     <div class="accordion-body">
                     En elle-même, une 'Omra peut se faire en 2 à 3 heures avec une prise d'Ihram à Tan'im. Cependant, si le Pèlerin prend son Ihram à Abâr 'Aly (Dhoû-l-Houlayfa) à 12 kilomètres de Médine, il doit compter alors environ journée pour cette première 'Omra (il peut partir en milieu de matinée et finir sa 'Omra en fin de soirée en fonction de son rythme).
                    </div>
                    </div>
                  </div>
                   <div class="accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                       Qu'est-ce que l'Ihram ? La tenue d'Ihram ? Quelle tenue pour les femmes ?
                      </button>
                      </h2>
                      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                     <div class="accordion-body">
                     La tenue d'Ihram se compose d'un 'izâr et d'un ridâ' qui sont deux pièces de tissu blanc sans coutures, propres et préférablement nouvelles. Il ne concerne que l'homme. L'une est enroulée autour des reins et tombe sous les genoux et l'autre couvre le torse. Les pieds sont chaussés de sandales laissant les talons découverts. Les sandales doivent être aussi sans coutures.

                     Les femmes peuvent porter des vêtements cousus.
                    </div>
                    </div>
                    </div>
                   <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      Peut-on cumuler plusieurs 'Omra ? Faut-il ressortir de La Mecque pour effectuer une nouvelle 'Omra ?
                    </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    Oui, vous pouvez cumuler plusieurs 'Omra à partir du moment où vous restez en tenue d'Ihram et que vous respectez les interdits liés à cet état (
                    L'acte sexuel et ce qui l'accompagne
                    Les vêtements cousus ou enveloppants
                    Le parfum
                    Les soins de toilette
                    La suppression de la vermine
                    La chasse aux animaux sauvages ).
                    Cependant, si vous sortez de l’état d’Ihram, vous ne pouvez plus entreprendre une autre 'Omra. Si vous voulez faire une nouvelle 'Omra, vous devez alors en effet ressortir de La Mecque et aller vous sacraliser à la Mosquée de `A'icha, qu'Allah soit satisfait d'elle (At-Tan`îm). Vous y accomplissez alors une prière de 2 rak'ât dans la mosquée, puis vous formulez votre intention d'Omra et la fait suivre nécessairement (wâjib) de la Talbiya. A partir de cet instant, les interdits de l'état d'Ihram s'imposent à vous; puis, vous retournez à La Mecque pour accomplir le Tawâf et le Sa`î.
                    </div>
                    </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingFive">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                      Peut-on faire une 'Omra pour d'autres personnes ?
                      </button>
                      </h2>
                      <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                      Oui, il est tout à fait possible d'accomplir pour une autre personne. Dans ce cas, il convient de le préciser au moment de la prise d'intention.
                     </div>
                     </div>
                    </div> 
                    </div>
                    </div>

           </div>

          <?php  include "INCLUDES/Templates/footer.php";
                if(isset($_POST['cal'])) {
                    $nbPers = $_POST['personne'];
                    $tarifTotal = $result['tarif_une_personne'] * $nbPers ;
                     ?>
                     <script>
                      let tarif = <?php echo (string)$tarifTotal; ?>;
                        $("input.tarif").attr('value', tarif);
                    </script> 
                 
                 <?php  }
         }
       }

 ?>



