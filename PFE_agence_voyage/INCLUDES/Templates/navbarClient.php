<nav class="navbar navbar-expand-xl navbar-light  sticky ">  
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img  class="logo" src="IMAGES/logo.jpg" alt="logo" width="70px" height="50px">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
        <li class="nav-item">
          <a class="nav-link active accClient" href="accueil.php"><i class="fa-solid fa-house"></i><span>Accueil</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="reserverVol.php"><i class="fa-solid fa-plane"></i><span>Vol</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-hotel"></i><span>Hotel</span>
          </a>
          <ul class="dropdown-menu hotel" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="listeHotels.php?type=national">national</a></li>
            <li><a class="dropdown-item" href="listeHotels.php?type=international">international</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="listeRemise.php"><i class="fa-solid fa-hand-holding-dollar"></i><span>Remise</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="listeOmra.php"><i class="fa-solid fa-kaaba"></i><span>Omra</span></a>
        </li>
        
        <li class="nav-item dropdown">
          <a id="bonjour" class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-user-large"></i><span>Bonjour <?php echo $_SESSION['clientName']; ?></span>
          </a>
          <ul class="dropdown-menu mouve" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="mesReservations.php">Mes reservations</a></li>
            <li><a class="dropdown-item" href="deconnexion.php">Deconnexion</a></li>
          </ul>
        </li>
      
      </ul>
    </div>
  </div>
</nav>