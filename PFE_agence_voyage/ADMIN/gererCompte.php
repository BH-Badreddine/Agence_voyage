<?php  ob_start();
$pageTitle = "Gestion des comptes";
include "init.php"; ?>
  <link rel="stylesheet" href="../CSS/styleBB.css">
</head>
<body>
  <?php  session_start();

  if(isset($_SESSION['admin']) && isset($_GET['action'])) {
    include $templates."navbarAdmin.php";
    $action= $_GET['action'];
    if ($action ==='ajouteradmin') { ?>
      <div class="error container text-center mt-2">
  
      </div>
      <div class="container inscripForm">

        <h1 class="text-center" style="font-family: 'Bitter', serif;">Ajouter un compte admin</h1>

        <form autocomplete="off" method="post" action="gererCompte.php?action=ajouteradmin">
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
      <?php   include $templates . "footer.php";
        #ajouter admin
        if(isset($_POST['valider'])){    
          $login = filter_var($_POST['login'],FILTER_SANITIZE_STRING);
		      $pass = trim($_POST['password']);
          $hashpass = sha1($_POST['password']);
          $Confpass = trim($_POST['Confpassword']);
          $nom = filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
          $prenom = filter_var($_POST['prenom'],FILTER_SANITIZE_STRING);
          $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
          $tel = filter_var($_POST['tél'],FILTER_SANITIZE_STRING);
          
          #inserer table compte
          $errors = array();
		      if($pass != $Confpass) { 
            array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Veuillez confirmer le mot de passe saisi</p>");
		       }
          if (isLoginExist($login)){
            array_push($errors,"<p class='alert alert-danger'><i class='fa-solid fa-triangle-exclamation'></i>Le login existe déjà</p>");
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
            $requete = "INSERT INTO administrateur(nom_admin,prenom_admin,tel_admin,email_admin) VALUES (:nom,:prenom,:tel,:email)";
            $sql = $connexion->prepare($requete);
            $sql->bindParam(":nom",$nom);
            $sql->bindParam(":prenom",$prenom);
            $sql->bindParam(":tel",$tel);
            $sql->bindParam(":email",$email);
            $st=$sql->execute();
            $last_id=$connexion->lastInsertId();
            $requete2 = "INSERT INTO compte(login,mot_de_passe,id_admin,GroupID) VALUES (:login,:hashpass,:id,'1')";
            $sql2 = $connexion->prepare($requete2);
            $sql2->bindParam(":login",$login);
            $sql2->bindParam(":hashpass",$hashpass);
            $sql2->bindParam(":id",$last_id);
            $st2=$sql2->execute();

            if($sql2->rowCount()==1) {  ?>
              <script>
                  alert("compte administrateur ajouté");
              </script>
              <?php header("refresh:1,url=accueilAdmin.php?page=liste_compte");
              }
              else {
                echo "echec";
              }
          }
          
        }
      ?>
  <?php  }



    //////////////////////////////////////////////////////
    if ($action==="supprimer"&& isset($_GET['id'])) {
      $typecompte = $_GET['type'];
      if ($typecompte==="admin") {
        $idadministrateur = $_GET['id']; 
        $requete = "DELETE FROM administrateur WHERE id_admin='$idadministrateur' ";
        $sql = $connexion->prepare($requete);
        $sql->execute();
        header("Location: accueilAdmin.php?page=liste_compte&&type_compte=administrateur");
        
      }else {
        $idclient = $_GET['id']; 
        $requete = "DELETE FROM client WHERE id_cli='$idclient' ";
        $sql = $connexion->prepare($requete);
        $sql->execute();
        header("Location: accueilAdmin.php?page=liste_compte&&type_compte=client");
      }
    }
  }