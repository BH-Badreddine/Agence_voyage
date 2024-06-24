<?php
include 'init.php';
if (isset($_POST['validerhotel'])) {
    $operation = $_POST['operation'];

    if ($operation == "a") {
        
        $civ = $_POST['civ'];
        $nom = stripAccents(trim($_POST['nom']));
        $prenom = stripAccents(trim(($_POST['prenom'])));
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $nbPers = $_POST['nbP'];
        $typeC = $_POST['typeC'];
        $pension = $_POST['pension'];
        $dateDR = $_POST['dateDR'];
        $dateFR = $_POST['dateFR'];
        $statut = $_POST['statut'];
        $id_hotel = $_POST['id_hotel'];
        $date_enreg_res = strtotime(date("d-m-Y H:i:s"));
        
        //Ajouter les données du client
            $requete1 = "INSERT INTO client(civilite,nom_cli,prenom_cli,tel_cli,email_cli) VALUES (:civ,:nom,:prenom,:telephone,:email)";
            $sql1 = $connexion->prepare($requete1);
            $sql1->bindParam(":civ", $civ);
            $sql1->bindParam(":nom", $nom);
            $sql1->bindParam(":prenom", $prenom);
            $sql1->bindParam(":telephone", $telephone);
            $sql1->bindParam(":email", $email);
            $st = $sql1->execute();
            $id_cli = $connexion->lastInsertId();

            //Ajouter les données de réservation offre
            if ($st) {
                $requete3 = "INSERT INTO reservation_offre(nbr_personnes,type_chambre,pension,date_debut_res,date_fin_res,statut,date_enreg_res,id_cli,id_hotel) VALUES (:nbP,:typeC,:pension,:dateDR,:dateFR,:statut,:date_enreg_res,:id_cli,:id_hotel)";
                $sql3 = $connexion->prepare($requete3);
                $sql3->bindParam(":nbP", $nbPers);
                $sql3->bindParam(":typeC", $typeC);
                $sql3->bindParam(":pension", $pension);
                $sql3->bindParam(":dateDR", $dateDR);
                $sql3->bindParam(":dateFR", $dateFR);
                $sql3->bindParam(":statut", $statut);
                $sql3->bindParam(":date_enreg_res", $date_enreg_res);
                $sql3->bindParam(":id_cli", $id_cli);
                $sql3->bindParam(":id_hotel", $id_hotel);
                $st2 = $sql3->execute();
                if ($st2) {
                    header('Location: accueilAdmin.php?page=liste_res_offre&operation=success');
                }
            } else {
                echo 'erreur';
            }
        }
     elseif($operation == "m"){

        $idres=$_POST['idres'];
        $nbPers = $_POST['nbP'];
        $typeC = $_POST['typeC'];
        $pension = $_POST['pension'];
        $dateDR = $_POST['dateDR'];
        $dateFR = $_POST['dateFR'];
        $statut = $_POST['statut'];  
        
            //Mise à jour des données de réservation hotel
            $requete2 = "UPDATE reservation_offre
                            SET nbr_personnes=:nbPers,type_chambre=:typeC,pension=:pension,date_debut_res=:dateDR,date_fin_res=:dateFR,statut=:statut 
                            WHERE id_Res_offre=:idres";
            $sql2 = $connexion->prepare($requete2);
            
            $sql2->bindParam(":nbPers", $nbPers);
            $sql2->bindParam(":typeC", $typeC);
            $sql2->bindParam(":pension", $pension);
            $sql2->bindParam(":dateDR", $dateDR);
            $sql2->bindParam(":dateFR", $dateFR);
            $sql2->bindParam(":statut", $statut);
            $sql2->bindParam(":idres", $idres);
            $st=$sql2->execute();
            
        
            header('Location: accueilAdmin.php?page=liste_res_offre&operation=success');
        }
    
} 

elseif (isset($_POST['validerremise'])) {

    $operation = $_POST['operation'];
    

    if ($operation == "a") {

        $civ = $_POST['civ'];
        $nom = stripAccents(trim($_POST['nom']));
        $prenom = stripAccents(trim(($_POST['prenom'])));
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $nbr_personnes = $_POST['nbP'];
        $type_chambre = $_POST['typeC'];
        $pension = $_POST['pension'];
        $statut = $_POST['statut'];
        $id_remise = $_POST['id_remise'];
        $date_enreg_res = strtotime(date("d-m-Y H:i:s"));

        //Ajouter les données du client
        $requete1 = "INSERT INTO client(civilite,nom_cli,prenom_cli,tel_cli,email_cli) VALUES (:civ,:nom,:prenom,:telephone,:email)";
        $sql1 = $connexion->prepare($requete1);
        $sql1->bindParam(":civ", $civ);
        $sql1->bindParam(":nom", $nom);
        $sql1->bindParam(":prenom", $prenom);
        $sql1->bindParam(":telephone", $telephone);
        $sql1->bindParam(":email", $email);
        $st = $sql1->execute();
        $id_cli = $connexion->lastInsertId();
        $remise=getByField("remise","id_remise",$id_remise);
        $date_debut_res=$remise['date_debut_remise'];
        $date_fin_res=$remise['date_fin_remise'];
        

        //Ajouter les données de réservation offre
        if ($st) {
            $requete3 = "INSERT INTO reservation_offre(nbr_personnes,type_chambre,pension,date_debut_res,date_fin_res,statut,date_enreg_res,id_cli,id_remise) 
            VALUES(:nbr_personnes,:type_chambre,:pension,:date_debut_res,:date_fin_res,:statut,:date_enreg_res,:id_cli,:id_remise)";
            $sql3 = $connexion->prepare($requete3);
            $st2 = $sql3->execute(array(
                'nbr_personnes'=>$nbr_personnes,
                'type_chambre'=>$type_chambre,
                'pension'=>$pension,
                'date_debut_res'=>$date_debut_res,
                'date_fin_res'=>$date_fin_res,
                'statut'=>$statut,
                'date_enreg_res'=>$date_enreg_res,
                'id_cli'=>$id_cli,
                'id_remise'=>$id_remise,
            ));
            if ($st2) {
                header('Location: accueilAdmin.php?page=liste_res_offre&operation=success');
            }
        } else {
            echo 'erreur';
        }

    }elseif($operation == "m") {

        $idres=$_POST['idres'];
        $nbPers = $_POST['nbP'];
        $typeC = $_POST['typeC'];
        $pension = $_POST['pension'];
        $statut = $_POST['statut']; 
        
        //Mise à jour des données de réservation remise
        $requete2 = "UPDATE reservation_offre
                        SET nbr_personnes=:nbPers,type_chambre=:typeC,pension=:pension,statut=:statut 
                        WHERE id_Res_offre=:idres";
        $sql2 = $connexion->prepare($requete2);
        $sql2->bindParam(":nbPers", $nbPers);
        $sql2->bindParam(":typeC", $typeC);
        $sql2->bindParam(":pension", $pension);
        $sql2->bindParam(":statut", $statut);
        $sql2->bindParam(":idres", $idres);
        $sql2->execute();
        
        header('Location: accueilAdmin.php?page=liste_res_offre&operation=success');
        
    }
} 

elseif (isset($_POST['valideromra'])) {

    $operation = $_POST['operation'];
    

    if ($operation == "a") {

        $civ = $_POST['civ'];
        $nom = stripAccents(trim($_POST['nom']));
        $prenom = stripAccents(trim(($_POST['prenom'])));
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $nbr_personnes = $_POST['nbP'];
        $type_chambre = $_POST['typeC'];
        $pension = $_POST['pension'];
        $statut = $_POST['statut'];
        $id_omra = $_POST['id_omra'];
        $date_enreg_res = strtotime(date("d-m-Y H:i:s"));

        //Ajouter les données du client
        $requete1 = "INSERT INTO client(civilite,nom_cli,prenom_cli,tel_cli,email_cli) VALUES (:civ,:nom,:prenom,:telephone,:email)";
        $sql1 = $connexion->prepare($requete1);
        $sql1->bindParam(":civ", $civ);
        $sql1->bindParam(":nom", $nom);
        $sql1->bindParam(":prenom", $prenom);
        $sql1->bindParam(":telephone", $telephone);
        $sql1->bindParam(":email", $email);
        $st = $sql1->execute();
        $id_cli = $connexion->lastInsertId();

        $omra=getByField("omra","id_omra",$id_omra);
        $date_debut_res=$omra['date_debut_omra'];
        $date_fin_res=$omra['date_fin_omra'];

        //Ajouter les données de réservation offre
        if ($st) {
            $requete3 = "INSERT INTO reservation_offre(nbr_personnes,type_chambre,pension,date_debut_res,date_fin_res,statut,date_enreg_res,id_cli,id_omra) 
            VALUES(:nbr_personnes,:type_chambre,:pension,:date_debut_res,:date_fin_res,:statut,:date_enreg_res,:id_cli,:id_omra)";
            $sql3 = $connexion->prepare($requete3);
            $st2 = $sql3->execute(array(
                'nbr_personnes'=>$nbr_personnes,
                'type_chambre'=>$type_chambre,
                'pension'=>$pension,
                'date_debut_res'=>$date_debut_res,
                'date_fin_res'=>$date_fin_res,
                'statut'=>$statut,
                'date_enreg_res'=>$date_enreg_res,
                'id_cli'=>$id_cli,
                'id_omra'=>$id_omra,
            ));
            if ($st2) {
                header('Location: accueilAdmin.php?page=liste_res_offre&operation=success');
            }
        } else {
            echo 'erreur';
        }
    } elseif($operation == "m"){

        $idres=$_POST['idres'];
        $nbPers = $_POST['nbP'];
        $typeC = $_POST['typeC'];
        $pension = $_POST['pension'];
        $statut = $_POST['statut']; 
        
        //Mise à jour des données de réservation omra
        $requete2 = "UPDATE reservation_offre
                        SET nbr_personnes=:nbPers,type_chambre=:typeC,pension=:pension,statut=:statut 
                        WHERE id_Res_offre=:idres";

        $sql2 = $connexion->prepare($requete2);
        $sql2->bindParam(":nbPers", $nbPers);
        $sql2->bindParam(":typeC", $typeC);
        $sql2->bindParam(":pension", $pension);
        $sql2->bindParam(":statut", $statut);
        $sql2->bindParam(":idres", $idres);
        $st=$sql2->execute();
        
        header('Location: accueilAdmin.php?page=liste_res_offre&operation=success');
        
    }
}
