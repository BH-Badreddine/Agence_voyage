<?php 
//Fonction pour afficher le titre de la page dans l'onglet
Function getTitle() {
    GLOBAL $pageTitle;
    echo $pageTitle;
}
//FIN
//Fonction qui envoie l'utilisateur vers la page connexion
function rediriger() { 
    echo "<div class='alert alert-danger conObligatoire' role='alert'>";
       echo "<i class='fa-solid fa-triangle-exclamation'></i><h2 class='alert-heading'>Vous devez vous connecter</h2>";
       echo "<p >Patientez, redirection vers la page connexion dans 3 secondes...</p>";
    echo "</div>"; 
    header("refresh:3,url=connexion.php"); 
}
//FIN

//Indique qu'il y a aucun résultat aprés l'execution d'une requète
function aucunResultat($chaine) {
    echo '<div class="alert alert-info aucunResultat">';
          echo '<p style="font-size: 20px;" class="text-center">Aucune '.$chaine.' trouvée!</p>';
    echo '</div>';
}
//FIN

//Transformer une chaine de caractères dans le format:PremièrelettreMajuscule restedeslettresMiniscule
function transform($chaine) {
    $TRchaine = strtoupper(trim($chaine)[0]).strtolower(substr(trim($chaine), 1));
    return $TRchaine;
}
//FIN
//Enlever les accents
function stripAccents($string){
    $trans = array("ô"=> "o" ,"Ô"=>"O", "ù"=>"u","è"=>"e","â"=>"a","î"=>"i","ï"=>"i","û"=>"u" , "É" => "E" ,"ç"=>"c", "ê"=>"e", "é" => "e", "à" => "a", "-" => "", "*" => "", );
    return strtr($string, $trans);
}

//********************POUR LES CHAMPS DE TEXTE TROP LONGS***************************
//Tronquer une chaine longue pour qu'elle soit adaptée à la taille de son container (ex:div)
function tronquer($chaine,$max) {
    if(strlen($chaine) >= $max){
        $courte = "";
        $nbrLigne = ceil(strlen($chaine)/$max);
        for($i=0 ; $i<$nbrLigne; $i++) {
           $courte = $courte . substr($chaine, $i*($max),$max) ."<br>" ;
        } 
    } else {
        $courte = $chaine;
    }
  return $courte;
}
//FIN

//*****************POUR ENUMERER LES POINTS FORTS SOUS FORME DE TIRETS */
  function pointsf($chaine, $symbole) {
      $points = explode("\n",$chaine);
      for($i=0 ;$i<count($points); $i++) {
          echo "<p class='POINT ms-3'>".$symbole." ".$points[$i]."</p>";
      }
  }
//FIN

//**************Pour énumérer les détails du programme omra */
 function programme($chaine , $symbole) {
    $programme = explode("\n", $chaine);
    for($i=0 ; $i<count($programme)-1 ; $i=$i+2) {
        echo "<p style='font-weight:bold;'>".$symbole." ".$programme[$i]."</p>";
        echo "<p class='ms-3 mt-0' style='font-size:19px;'>".$programme[$i+1]."</p>";
    }
 }
///FIN

//Destinations populaires
Function destpopul ($ville) {
    $dsn = "mysql:host=localhost;dbname=agencevoyage";
    $USER = "root";
    $PASS = "";
    try { 
      $connexion = new PDO($dsn,$USER,$PASS);
      //echo "connexion successful";
    }
    catch(PDOException $e) {
        echo "Echec".$e->getMessage();
    }

    echo "<div class='container destPop mt-3'>";
        echo "<div class='row'>";
            echo "<h1 class='text-center'>Destination ".$ville."</h>";
            switch ($ville) {
                case "Paris":
                  echo "<p class='mt-4'>Environ 38 millions de touristes son venus à Paris en 2019, un nouveau record battu avant la crise du Covid, permis par l'afflux des clientèles française et japonaise, et à la fidélité croissante des touristes Américains, malgré la demande croissante pour un tourisme durable. C'est près d'un cinquième de plus que les 32 millions de 2013, dont approximativement 15,5 millions d'étrangers, ce qui fait d'elle la ville la plus visitée au monde.</p>";
                  break;
                case "Madrid":
                  echo "<p class='mt-4'>C'est une des villes les plus visitées en Europe, derrière Paris et Londres grâce aux nombreuses activités pour les touristes, récréatives et culturelles mais aux foires et expositions : Madrid est le principal organisateur de la foire en Europe, en termes de superficie louée par les exposants. L'IFEMA, qui organise des salons comme FITUR, Madrid Fusion, ARCO, SIMO TCI, le moteur et la Cibeles Madrid Fashion Week.</p>";
                  break;
                case "Istanbul":
                  echo "<p class='mt-4'>Istanbul, avec plus de 9,4 millions de visiteurs en 2011, est une destination touristique importante et la 7e dans le monde. Le nombre de touristes a augmenté de 9,2 % par rapport à l'année 2010. 14,6 % de ces touristes sont allemands, suivent ensuite les Russes (6,0 %), les Américains et les Britanniques (5,1 %), les Français et les Italiens (4,9 %), les Néerlandais (3,5 %), les Espagnols (3 %)44. Istanbul a donc accueilli environ un quart des 31,5 millions de touristes venus en Turquie en 201145. Elle reste en 2014 la 7e ville la plus visitée dans le monde (derrière Londres, Bangkok et Paris) avec 11,6 millions de visiteurs.</p>";
                  break;
                case "Dubai":
                  echo "<p class='mt-4'>A Dubaï, il existe une multitude et une diversités de choses incontournables à faire.
                  Dans premier temps, nous avons le monument symbolique de la ville qui est le Burj Khalifa ! Cette tour de 828 mètres de hauteur est constituée de 163 étages. Actuellement, le Burj Khalifa s'avère être le bâtiment le plus haut du monde. Il est tout à fait possible pour les visiteurs et les touristes de se procurer des billets en ligne ou sur place afin de pouvoir visiter son intérieur et d'avoir l'exclusivité de profiter d'une belle vue au sommet de la tour. Les prix varient entre 159 AED et 759 AED.
                  Ensuite, comme deuxième monument symbolique et incontournables de Dubaï, il y a la possibilité de visiter le plus grand centre commercial du monde : Dubai Mall. Ce centre est constitué de plus de 1200 magasins, divers loisirs et divertissements, et surtout de centaines de restaurants regroupant des cuisines des 4 coins du monde.</p>";
                  break;
                case "Londres":
                  echo "<p class='mt-4'>Londres est une des principales destinations touristiques au monde. Ce secteur génère entre 280 000 et 350 000 emplois selon les sources. En 2008, les revenus du tourisme représentaient 10,5 milliards £. En 2014, Londres a reçu 17,4 millions de touristes étrangers, pour un total d'environ 28 millions.
                  Londres bénéficie de son statut de capitale anglophone en Europe et attire ainsi chaque année de très nombreux étudiants du continent venus apprendre la langue anglaise. Une importante économie du tourisme estudiantin s'est développée autour de cette manne, certains n'hésitant pas à en profiter par des pratiques à la limite de la légalité.</p>";
                  break;
             }
        echo "</div>";
        echo "<div class='row '>";
             echo "<div class='col-md-4'>";
                echo "<img src='IMAGES/".$ville."1.jpg' height='250px' width='300px' class='mb-3'>";
             echo "</div>";
             echo "<div class='col-md-4'>";
                echo "<img src='IMAGES/".$ville."2.jpg' height='250px' width='300px' class='mb-3'>";
             echo "</div>";
             echo "<div class='col-md-4'>";
                echo "<img src='IMAGES/".$ville."3.jpg' height='250px'width='300px' class='mb-3'>";
             echo "</div>";
        echo "</div>";
    echo "</div>";

    echo "<h1 class='title text-center'>Nos offres hotels proposées</h1>";
    echo '<div class="d-flex justify-content-center mb-3">';
        echo '<i class="fa-solid fa-circle blue"></i>';
        echo '<i class="fa-solid fa-circle yellow"></i>';
        echo '<i class="fa-solid fa-circle gray"></i>';
    echo "</div>";
    $requete = "SELECT * FROM hotel WHERE ville='$ville'";
    $sql = $connexion->prepare($requete);
    $sql->execute();
    if($sql->rowCount() > 0) {
        $result = $sql->fetchAll();
        echo "<div class='container'>";
        foreach($result as $hotel) { 
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
       echo "</div>";
    } else {
        aucunResultat('offre hotel');
    }
 }


?>