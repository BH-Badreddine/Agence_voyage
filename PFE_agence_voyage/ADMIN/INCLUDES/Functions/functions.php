<?php


Function getTitle() {
    GLOBAL $pageTitle;
    echo $pageTitle;
}

function rediriger() { 
    echo "<div class='alert alert-danger conObligatoire' role='alert'>";
       echo "<i class='fa-solid fa-triangle-exclamation'></i><h2 class='alert-heading'>Vous devez vous connecter</h2>";
       echo "<p >Patientez, redirection vers la page connexion dans 3 secondes...</p>";
    echo "</div>"; 
    header("refresh:3,url=../connexion.php"); 
}
//Indique qu'il y a aucun résultat aprés l'execution d'une requète
function aucunResultat($chaine) {
    echo '<div class="alert alert-info aucunResultat">';
          echo '<p style="font-size: 20px; color:rgba(0, 0, 0, 0.705);" class="text-center">Aucune '.$chaine.' trouvée!</p>';
    echo '</div>';
}

//Transformer une chaine de caractères dans le format:lettre1Majuscule restedeslettresMiniscule
function transform($chaine) {
    $TRchaine = strtoupper(trim($chaine)[0]).strtolower(substr(trim($chaine), 1));
    return $TRchaine;
}
//Enlever les accents
function stripAccents($string){
    $trans = array("ô"=> "o" ,"Ô"=>"O", "Ü"=>"U", "Ä"=>"A", "Ï"=>"I"  ,"ù"=>"u","è"=>"e","â"=>"a","î"=>"i","ï"=>"i","û"=>"u" , "É" => "E" ,"ç"=>"c", "í"=>"i","î"=>"i", "ê"=>"e", "é" => "e","â"=>"a", "à" => "a", "-" => "", "*" => "", );
    return strtr($string, $trans);
}
//********************POUR LES CHAMPS DE TEXTE TROP LONGS***************************
//Tronquer une chaine longue pour qu'elle soit adaptée à la taille de son container (ex:div)
function tronquer($chaine,$max) {
    if(strlen($chaine) >= $max){
        $courte = "";
        $nbrLigne = ceil(strlen($chaine)/$max);
        for($i=0 ; $i<$nbrLigne; $i++) {
           $courte = $courte . substr($chaine, $i*($max+1),$max) ."<br>" ;
        } 
    } else {
        $courte = $chaine;
    }
  return $courte;
}
//FIN

//*****************POUR ENUMERER LES POINTS FORTS SOUS FORME DE TIRETS *****************************/
  function pointsf($chaine, $symbole) {
      $points = explode("\n",$chaine);
      for($i=0 ;$i<count($points); $i++) {
          echo $symbole." ".$points[$i]."<br>";
      }
  }
//FIN

// Partie fonctions liste compte + gérer comptes

Function readUsers($type_user) {
	global $connexion;
	if ($type_user == 'administrateur') {
		$request="SELECT * FROM administrateur";
	}else{
		$request="SELECT * FROM client";
	}
    
    $ps= $connexion->prepare($request);
    $ps->execute();
    $resultat=$ps->fetchall();
    return $resultat;
}

Function getLogin($type_user,$id) {
	global $connexion;
	if ($type_user == 'administrateur') {
		$request="SELECT login FROM compte WHERE id_admin=:id";
	}else{
		$request="SELECT login FROM compte WHERE id_cli=:id";
	}
    
    $ps= $connexion->prepare($request);
    $ps->execute(array('id' => $id));
    $resultat=$ps->fetch();
    
    if ($resultat) {
    	return $resultat['login'];

    } else {
    	return false;
    }
    
}
// Partie fonctions liste avis + supprimer avis

function getComments(){
    global $connexion;
    $request="SELECT * FROM avis";

    $ps= $connexion->prepare($request);
    $ps->execute();
    $resultat=$ps->fetchall();
    return $resultat;
}

function getName($id){
    global $connexion;

    $request="SELECT nom_cli,prenom_cli FROM client WHERE id_cli=:id";

    $ps= $connexion->prepare($request);
    $ps->execute(array('id' => $id));
    $resultat=$ps->fetch();
    return $resultat;
}


function supprimerAvis($id){
    global $connexion;

    $request="DELETE FROM avis WHERE id_avis=:id";

    $ps= $connexion->prepare($request);
    $ps->execute(array('id' => $id));

}


// Partie fonctions liste reservation offre + gérer reservations offre

function getHotel($id){
    global $connexion;
    $request="SELECT nom_hotel FROM hotel WHERE id_hotel=:id";

    $ps= $connexion->prepare($request);
    $ps->execute(array('id' => $id));
    $resultat=$ps->fetch();
    return $resultat;
}
function getRemise($id){
    global $connexion;
    $request="SELECT nom_remise FROM remise WHERE id_remise=:id";

    $ps= $connexion->prepare($request);
    $ps->execute(array('id' => $id));
    $resultat=$ps->fetch();
    return $resultat;
}
function getOmra($id){
    global $connexion;
    $request="SELECT intitule FROM omra WHERE id_omra=:id";

    $ps= $connexion->prepare($request);
    $ps->execute(array('id' => $id));
    $resultat=$ps->fetch();
    return $resultat;
}

function getReservationOffre(){
    global $connexion;
    $request="SELECT * FROM  reservation_offre";

    $ps= $connexion->prepare($request);
    $ps->execute();
    $resultat=$ps->fetchall();
    return $resultat;
}


//Partie fonctions liste offres hotel/omra/remises

function getOffreHotel(){
    global $connexion;
    $request="SELECT * FROM  hotel";

    $ps= $connexion->prepare($request);
    $ps->execute();
    $resultat=$ps->fetchall();
    return $resultat;
}

function getOffreRemise(){
    global $connexion;
    $request="SELECT * FROM  remise";

    $ps= $connexion->prepare($request);
    $ps->execute();
    $resultat=$ps->fetchall();
    return $resultat;
}

function getOffreOmra(){
    global $connexion;
    $request="SELECT * FROM  omra";

    $ps= $connexion->prepare($request);
    $ps->execute();
    $resultat=$ps->fetchall();
    return $resultat;
}
// Fonction verifier si login existe dans table compte + ajouter admin 
function isLoginExist($login){
    global $connexion;

    $request="SELECT login FROM compte WHERE login=:login";

    $ps= $connexion->prepare($request);
    $ps->execute(array('login' => $login));
    $resultat=$ps->fetch();
    return $resultat;
}
function getAll($table){
    global $connexion;
    $request="SELECT * FROM $table";

    $ps= $connexion->prepare($request);
    $ps->execute();
    $resultat=$ps->fetchall();
    return $resultat;
}

function getByField($table,$field,$value){
    global $connexion;
    $request="SELECT * FROM $table WHERE $field=:value";

    $ps= $connexion->prepare($request);
    $ps->execute(array("value"=>$value));
    $resultat=$ps->fetch();
    return $resultat;
}


?>