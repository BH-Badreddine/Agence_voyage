<div class="card">
    <div class="card-header">
        <h2>Gérer les comptes</h2>        
    </div>
    
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="">Veuillez choisir le type de compte:</label>
                <select class="form-control my-2" name="type_compte" required>
                    <option value="">-------</option>
                    <option value="administrateur">Administrateur</option>
                    <option value="client">Client</option>
                </select>
                <button class="btn btn-primary" >Selectionner</button>
            </div>
        </form>
        <div class="container">
        <?php 
        $afficher = false;
        if (isset($_POST['type_compte'])) {
            $afficher =true;
            $type_compte=filter_var($_POST['type_compte'],FILTER_SANITIZE_STRING);
         }
        if(isset($_GET['type_compte'])) {
            $afficher =true;
            $type_compte=filter_var($_GET['type_compte'],FILTER_SANITIZE_STRING);
        }
        if($afficher) {
            if ($type_compte=='administrateur') {
                $administrateur=readUsers($type_compte);
                ?>

                <h5 class="alert alert-info text-center">Liste administrateurs</h5>
                <div class="col-4 offset-8 ">
                    <div class="d-grid gap-2">
                        <a href="gererCompte.php?action=ajouteradmin" class="btn btn-success mb-2 offset-1" ><i class="fa-solid fa-plus"></i>Ajouter un administrateur</a>
                    </div>  
                </div>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="bg-secondary text-light text-center">
                            <th>Login</th>
                            <th>Nom et prénom</th>
                            <th>E-mail</th>
                            <th>Téléphone</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($administrateur as $user) {
                            $id_admin=$user['id_admin'];
                            $fullname=$user['nom_admin']." ".$user['prenom_admin'];
                            $login= getLogin($type_compte,$id_admin);
                        ?>
                        <tr>
                            <td><?= $login ?></td>
                            <td><?= $fullname ?></td>
                            <td><?= $user['email_admin'] ?></td>
                            <td><?= $user['tel_admin'] ?></td>

                            <td>
                                <a class="btn btn-danger confirm" href="gererCompte.php?action=supprimer&&type=admin&&id=<?= $id_admin ?>">Supprimer</a>
                            </td>
                        </tr> 

                        <?php   } ?>
                    
                    </tbody>
                </table>

                <?php
            }else{
                $clients = readUsers($type_compte);
                ?>
                <h5 class="alert alert-info text-center">Liste clients</h5>
                <form class="search mt-2 d-flex col-7 mx-auto" autocomplete="off" method="post" action="?page=liste_compte">
                    <input id="myInput"  class="me-2 form-control" name="name" type="text" placeholder="Rechercher ce que vous voulez...">
                    <button class="btn btn-primary" name="search" type="submit"><i class="ms-1 fa-solid fa-magnifying-glass"></i></button>
                </form>
        
                <br>
                <table id="myTable" class="table table-bordered text-center">
                    <thead>
                        <tr class="bg-secondary text-light text-center">
                            <th>Login</th>
                            <th>Nom et prénom</th>
                            <th>E-mail</th>
                            <th>Téléphone</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $user) {
                            $id_client=$user['id_cli'];
                            $fullname=$user['nom_cli']." ".$user['prenom_cli'];
                            $login= getLogin($type_compte,$id_client);
                        ?>
                        <tr>
                            <td><?= $login ?></td>
                            <td><?= $fullname ?></td>
                            <td><?= $user['email_cli'] ?></td>
                            <td><?= $user['tel_cli'] ?></td>

                            <td>
                                <a class="btn btn-danger confirm" href="gererCompte.php?action=supprimer&&type=client&&id=<?= $id_client ?>">Supprimer</a>
                            </td>
                        </tr> 

                        <?php   } ?>
                    </tbody>
                </table>
            <?php
            }
         
            ?>

        
            
        </div>
        <?php
        }
        ?>
    </div>
    
