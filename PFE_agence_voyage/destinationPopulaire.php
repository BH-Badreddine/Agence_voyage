<?php $pageTitle = "Destinations populaires";
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
 if(isset($_GET['ville'])) {
     $ville = $_GET['ville'];
     destpopul($ville);
     include $templates."footer.php";
 } 
  
  
  
  
  
  ?>
