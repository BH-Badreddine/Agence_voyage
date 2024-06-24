<div class="card">
    <div class="card-header">
        <h2>Gérer les avis client:</h2>        
    </div>

    <br>
    <div class="container-fluid">
        <h5 class="alert alert-info text-center">Liste des avis</h5>
        <form class="search mt-4 d-flex col-8 mx-auto" autocomplete="off" method="post" action="?page=liste_avis">
            <input id="myInput" class="me-2 form-control" name="login" type="text" placeholder="Rechercher ce que vous voulez...">
            <button class="btn btn-primary" name="search" type="submit"><i class="ms-1 fa-solid fa-magnifying-glass"></i></button>
        </form>
        <br>
        <table id="myTable" class="table table-bordered ">
            <thead>
                <tr class="bg-secondary text-light ">
                    <th>Login</th>
                    <th>Nom et pénom</th>
                    <th>Hotel concerné</th>
                    <th>Publié le</th>
                    <th>Contenu commentaire</th>
                    <th>Opérations</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $avis= getComments();
                    foreach ($avis as $avis) {
                        
                        $id_client=$avis['id_cli'];
                        $id_hotel=$avis['id_hotel'];
                        $nom_client= getName($id_client);
                        $fullname=$nom_client['nom_cli']." ".$nom_client['prenom_cli'];
                        $nom_hotel= getHotel($id_hotel);
                        $name_hotel= $nom_hotel['nom_hotel'];
                        $login=getLogin("client",$id_client);

                ?>
                <tr>
                    <td><?php echo "$login"; ?></td>
                    <td><?= $fullname ?></td>
                    <td><?= $name_hotel ?></td>
                    <td><?= $avis['date_publication'] ?></td>
                    <td>"<?= tronquer($avis['commentaire'],50); ?>"</td>
                    <td>
                        <a class="btn btn-danger confirm" href="supprimerAvis.php?id_avis=<?= $avis['id_avis'] ?>">Supprimer</a>
                    </td>
                </tr> 

                <?php   } ?>
            </tbody>
        </table>