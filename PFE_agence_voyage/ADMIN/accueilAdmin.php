<?php 
$pageTitle = "Accueil admin";
include "init.php"; ?>
   <!-- Bootstrap CSS CDN -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> 
   <link rel="stylesheet" href="CSS/style.css">
   <link rel="stylesheet" href="CSS/styleB.css">
</head>

<body>
    <?php session_start();
         if(isset($_SESSION['admin'])) {  ?>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?php include  $templates.'sideBar.php'; ?>

        <!-- Page Content  -->
        <div id="content">

            <?php include  $templates.'navbarAdmin.php'; ?>
            <div class="container-fluid">
                <?php 
                $page="home";
                $page= isset($_GET['page']) ? filter_var($_GET['page'], FILTER_SANITIZE_STRING):$page;
                
                switch ($page) {
                    
                    case 'home':
                        echo '<h1 class="text-center home">Bienvenue administrateur</h1>'; ?>
                        <br>
                        <div class="text-center">
                            <img src="IMAGES/Accueil.jpg" alt="image accueil admin" height="43%" width="43%" style="border-style: double;">
                        </div>
                        <?php break; 

                    case 'liste_compte':
                        include 'listeComptes.php' ;
                        break;
                    
                    case 'liste_hotels':
                        
                        include 'listeOffre.php' ;
                        break;
                    
                    case 'liste_remises':
                         
                        include 'listeOffre.php' ;
                        break;
                    
                    case 'liste_omras':
                        
                        include 'listeOffre.php' ;
                        break;
                    
                    case 'liste_avis':
                        include 'listeAvis.php' ;
                        break;

                    case 'liste_res_vol':
                        include 'listeResVol.php' ;
                        break;

                    case 'liste_res_offre':
                        include 'listeResOffre.php' ;
                        break;

                    default:
                    echo '<div class="alert alert-danger text-center">';
                      echo 'Oops! cette page est introuvable!';
                   echo '</div>';
                        break;
                }                
                ?>
            </div>
        </div>
    </div>
 <?php include $templates . "footer.php"; ?>
        <?php  } else {
            rediriger();
        }
 
     

