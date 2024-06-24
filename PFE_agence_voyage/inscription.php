<?php  ob_start();
$pageTitle = "page inscription";
include "init.php";  
?>
  
  <link rel="stylesheet" href="CSS/styleBB.css">
</head>
<body class="inscription">

<?php include $templates."navbarSimple.php"; ?>

<div class="error container text-center mt-2">
  
</div>

<div class="container inscripForm">
    <h1 class="text-center" style="font-family: 'Bitter', serif;">Créer un compte</h1>
    
    <form autocomplete="off" method="post" action="inscription.php">
        <div class="mb-2">
          <label for="civilité" class="form-label">Civilité</label>
          <select name="civ" id="civilité" class="form-select">
               <option value="Mr" selected >Mr</option>
               <option value="Mme">Mme</option>
               <option value="Mlle">Mlle</option>
          </select>
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="login" class="form-label text-center">Login</label>
          <i class="fa-solid fa-user insideInputLogin2"></i>
          <input  name="login" type="text" class="form-control" id="login" placeholder="Entrer login" value="<?php echo @$_POST['login']; ?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="pass" class="form-label">Mot de passe</label>
          <i class="fa-solid fa-lock insideInputPass2"></i>
          <input   name="password" type="password" class="form-control password2" id="pass" placeholder="Entrer mot de passe">
          <i class="fa-solid fa-eye show-pass2"></i>
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="Confirmpass" class="form-label">Confirmer mot de passe</label>
          <i class="fa-solid fa-lock insideInputPass2"></i>
          <input  name="Confpassword" type="password" class="form-control password3" placeholder="Confirmer mot de passe" id="Confirmpass" >
          <i class="fa-solid fa-eye show-pass3"></i>
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="nom" class="form-label">Nom</label>
          <input  name="nom" type="text" class="form-control pad" id="nom" placeholder="Entrer nom" value="<?php echo @$_POST['nom']; ?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="prenom" class="form-label">Prénom</label>
          <input  name="prenom" type="text" class="form-control pad" id="prenom" placeholder="Entrer prenom" value="<?php echo @$_POST['prenom']; ?>" >
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="email" class="form-label">Email</label>
          <i class="fa-solid fa-envelope insideInputEmail"></i>
          <input  name="email" type="email" class="form-control" id="email" placeholder="Entrer email" value="<?php echo @$_POST['email']; ?>">
        </div>
        <div class="mb-2" style="position:relative;">
          <label for="tél" class="form-label">Téléphone</label>
          <i class="fa-solid fa-phone insideInputTel"></i>
          <input  name="tél" type="tel" class="form-control" placeholder="Entrer numéro téléphone" id="tél"  value="<?php echo @$_POST['tél']; ?>" >
        </div>
    <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-2">
        <button name="valider" type="submit" class="btn btn-primary btn-lg mb-2" style="font-size:23px;">S'inscrire</button>
    </div>
    </form>
</div>

<?php include $templates."footer.php";  

if(isset($_POST['valider'])) {
  
  $civ = trim($_POST['civ']);
  $login = trim($_POST['login']);
  $pass = trim($_POST['password']);
  $hashpass = sha1($_POST['password']);
  $Confpass = trim($_POST['Confpassword']);
  $nom = trim($_POST['nom']);
  $prenom = trim($_POST['prenom']);
  $email = trim($_POST['email']);
  $tel = trim($_POST['tél']);
   //Validation du formulaire
   $errors = array();
   if(empty($login)) {
     array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Le champ login est obligatoire</p>");
   }
   if(empty($pass)) {
    array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Le champ mot de passe est obligatoire</p>");
  }
  if(empty($nom)) {
    array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Le champ Nom est obligatoire</p>");
  }
  if(empty($prenom)) {
    array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Le champ Prenom est obligatoire</p>");
  }
  if(empty($email)) {
    array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Le champ email est obligatoire</p>");
  }
  if(!preg_match("/^[a-z0-9A-Z]{5,10}$/",$login)) {//login doit contenir entre 5 et 10 caractères alphanumériques
    array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>login doit contenir entre 5 et 10 caractères (lettres et chiffres)</p>"); 
 }
 if(!preg_match("/^.{6,15}$/",$pass)) {//password doit contenir entre 6 et 15 caractères alphanumériques
  array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>mot de passe doit contenir entre 6 et 15 caractères</p>"); 
}
 if($pass !== $Confpass) {
  array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Veuillez confirmer le mot de passe saisi</p>");
 }

  if(!empty($errors)) { 
    $string = "";
    foreach($errors as $error) {
      $string .= $error;
    }
    ?>
    <script>
      $("div.error").html("<?php echo $string;  ?>");
    </script>
    
  <?php }
  else { 
    $requete = "SELECT login FROM compte WHERE login=:login ";
    $sql = $connexion->prepare($requete);
    $sql->bindParam(":login",$login);
    $sql->execute();
    if($sql->rowCount() > 0) { ?>
      <script>
      $("div.error").html("<?php echo "<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>le login existe déjà</p>"  ?>");
    </script>
   <?php  }
   else {//Ajouter un tuple dans la table client
     $requete = "INSERT INTO client(civilite,nom_cli,prenom_cli,tel_cli,email_cli) VALUES (:civ,:nom,:prenom,:tel,:email)";
     $sql = $connexion->prepare($requete);
    $sql->bindParam(":civ",$civ);
    $sql->bindParam(":nom",$nom);
    $sql->bindParam(":prenom",$prenom);
    $sql->bindParam(":tel",$tel);
    $sql->bindParam(":email",$email);
    $sql->execute();
    //Récupérer le id du client ajouté
    $query = "SELECT id_cli FROM client WHERE email_cli=:email";
    $sql1 = $connexion->prepare($query);
    $sql1->bindParam(":email",$email);
    $sql1->execute();
    if($sql1->rowCount() > 0) {
       $result = $sql1->fetch();
       $idcli = $result['id_cli'];
   }
   //Ajouter un tuple dans la table compte qu'on relie à celui de la table client
   $requete2 = "INSERT INTO compte(login,mot_de_passe,id_cli,GroupID) VALUES (:login,:hashpass,:idcli,'0')";
   $sql2 = $connexion->prepare($requete2);
    $sql2->bindParam(":login",$login);
    $sql2->bindParam(":hashpass",$hashpass);
    $sql2->bindParam(":idcli",$idcli);
    $sql2->execute();
    
      header('Location: accueil.php');
      exit();
  }




}

}

ob_end_flush();
?>






