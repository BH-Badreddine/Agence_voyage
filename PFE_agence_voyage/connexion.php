
<?php //////////////////Pour tester des comptes:
///////////Comptes client: rayann-123456  proplayer-123456
///////////Compte admin:  badro-123456
ob_start();

$pageTitle = "Page de connexion";
include "init.php"; ?>
  <link rel="stylesheet" href="CSS/styleBB.css">
</head>
<body class="connexion"> 

 <?php include $templates."navbarSimple.php"; ?>

 <div class="container conForm ">
     <h1 class="text-center" style="font-family: 'Bitter', serif;">Connexion</h1>
     <form autocomplete="off" method="post" action="connexion.php">
        <div class="mb-4 mt-4" style="position:relative;">
            <i class="fa-solid fa-user insideInputLogin1"></i>
            <input  name="username" type="text" placeholder="Entrer login" class="form-control" value="<?php echo @$_GET['login']; ?>">
            <div class="form-text">
               <P><?php  echo @$_GET['Loginerreur']; ?></p>
            </div>
        </div>
        <div class="mb-4" style="position:relative;">
            <i class="fa-solid fa-lock insideInputPass1"></i>
            <input name="password" type="password" placeholder="Entrer mot de passe" class=" password1 form-control">
            <i class="fa-solid fa-eye show-pass1"></i>
            <div class="form-text">
               <p><?php   echo @$_GET['Passerreur']; ?></p>
            </div>
        </div>
        <div class="d-grid gap-2 col-10 mx-auto" style="height: 50px;">
            <button name="envoyer" type="submit" class="btn btn-primary " style="font-size:23px;">Se connecter</button>
        </div>
    </form>
     <hr>
     <p class="text-center">Vous n'avez pas de compte ? créer un <a href="inscription.php">ici</a></p>
 </div>


 


 <?php 
  
 include $templates."footer.php"; ?>

<?php  
  if(isset($_POST['envoyer'])) {
    $login = $_POST['username'];
    $pass = $_POST['password'];
    $hashpass = sha1($pass);
    
    //Vérifier si un ou plusieurs champs sont vides  
      $passerror = "";
      $loginerror ="";
      $error = false;
    if(empty($login)) {
        $loginerror = "Vous devez remplir ce champ";
        $error = true;
    }
    if(empty($pass)) {
        $passerror = "Vous devez remplir ce champ";
        $error = true;
    }
    if($error) {
        header("Location: connexion.php?Passerreur=$passerror&&Loginerreur=$loginerror&&login=$login");
        exit();
    }
    else {
    //Ici, tous les champs sont remplis
    $requete = "SELECT * FROM compte WHERE login= :login and mot_de_passe= :hashpass";
    $sql = $connexion->prepare($requete);
    $sql->bindParam(":login",$login);
    $sql->bindParam(":hashpass",$hashpass);
    $sql->execute();
    if($sql->rowCount() > 0) {
       $result = $sql->fetch();
       if($result['GroupID']==0) {//connexion du client
           session_start();
           $idCli = $result['id_cli'];
           $_SESSION['clientId']= $idCli;
           $requete2 = "SELECT prenom_cli FROM client WHERE id_cli='$idCli'";
           $sql2 = $connexion->prepare($requete2);
           $sql2->execute();
           if($sql2->rowCount() > 0) {
            $result2 = $sql2->fetch();
            $_SESSION['clientName'] = $result2['prenom_cli'];
           }
           header("Location: accueil.php");
       }
       if($result['GroupID']==1) {//connexion admin
           session_start();
           $_SESSION['admin'] = $result['id_admin'];
           header("Location: ADMIN/accueilAdmin.php");
       }
    } 
    else {
        $passerror = "Login ou mot de passe incorrect(s)";
        $loginerror = "Login ou mot de passe incorrect(s)";
        header("Location: connexion.php?Passerreur=$passerror&&Loginerreur=$loginerror&&login=$login");
    }  
}
    
}  ob_end_flush();
?>





