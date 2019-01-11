<?php 
session_start();
include_once('fonctions_php/fonction_bdd.php');

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <title>Mon espace membre</title>
    </head>
    <body>

        <?php
    $bdd = connectLocalhost();

        ?>

        <?php
        include('header.php');

        if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom']) || !isset($_SESSION['email'])) {
            echo '<p>Vous devez être connecté pour accéder à votre espace membre</p>';
        } else {
        ?>

        <div class="container-fluid">

            <h3>Espace membre de <?php echo $_SESSION['nom'].' '.$_SESSION['prenom']?></h3>

            <div class="row">

                <div class="col-3 bg-light border rounded shadow-sm">
                    <p style="text-align: center"><span class="underline_blue">Mes factures</span></p>

                    <?php


            $req = $bdd->prepare('select * from facture f, client c where f.id_client = c.id_client && c.email = :email');
            $req->execute(array('email' => $_SESSION['email']));
            $i = 1;
            while($s = $req->fetch()) {

                echo '<h5>Facture '.$i.'</h5>';
                echo '<ul>';
                echo '<li><span class="font-weight-bold">Date : </span>'.$s['laDate'].'</li>';
                echo '<li><span class="font-weight-bold">Article(s) acheté(s) : </li>';
                echo "<ul>";
                
                //affichage des articles achetés
                $display = $bdd->prepare('select * from facture_details where id_facture = :id_facture');
                $display->execute(array(
                    'id_facture' => $s['id_facture']
                ));
                while($facture_detail = $display->fetch()) {

                    //recupération des infos de l'article
                    $select_produit = $bdd->prepare('select * from produit where id_produit = :id_produit');
                    $select_produit->execute(array(
                        'id_produit' => $facture_detail['id_produit']
                    ));
                    while($produit = $select_produit->fetch()) {
                        echo '<li>'.$produit['intitule'].' * '.$facture_detail['quantite'].' : '.$facture_detail['prix_total'].'€</li>';
                    }

                    
                }
                echo "</ul>";
                echo '<li><span class="font-weight-bold">Montant total : </span>'.$s['prix'].' €</li>';
                echo '</ul>';

                $i++;
            }
                    ?>
                </div>

                <div class="col-1">

                </div>

                <div class="col-7 bg-light pb-3 border rounded shadow-sm">
                    <p style="text-align: center"><span class="underline_blue">Mes informations</span></p>

                    <?php

            $email = $_SESSION['email'];
            //Récuperation des infos
            $req = $bdd->prepare('select * from client where email=:email'); 
            $req->execute(array('email' => $email));
            $infos = $req->fetch();
            $req->closeCursor();
                    ?>


                    <div class="container-fluid ">
                        <ul>
                            <li>Nom : <?php echo $infos['nom'] ?></li>
                            <li>Prenom : <?php echo $infos['prenom'] ?></li>
                            <li>Email : <?php echo $infos['email'] ?></li>
                            <li>Rue : <?php echo $infos['rue'] ?></li>
                            <li>Ville : <?php echo $infos['ville'] ?></li>
                            <li>Pays : <?php echo $infos['pays'] ?></li>
                        </ul>
                        <a href="?action=modifier_info" class="btn btn-danger btn-sm float-right">Modifier mes informations</a>
                    </div>


                </div>

            </div>
            <div class="row">
                <div class="col-3">

                </div>
                <div class="col-1">

                </div>
                <div class="col-7">
                    <div class="container-fluid mt-5">


                        <?php
                        if(isset($_GET['action'])) {
                            if($_GET['action'] == 'modifier_info') {
                                
                                echo '<form method="POST" action="espace_membre.php" id="form_modif">';
                                echo '<p>';
                                echo '<label for="nom">Nom : </label><input type="text" name="nom" value='.$_SESSION['nom'].'><br>';
                                echo '</p>';
                                echo '<p>';
                                echo '<label for="prenom">Prenom : </label><input type="text" name="prenom" value='.$_SESSION['prenom'].'><br>';
                                echo '</p>';
                                echo '<p>';
                                echo '<label for="email">Email : </label><input disabled type="text" name="email" value='.$_SESSION['email'].'><br>';
                                echo '</p>';
                                echo '<p>';
                                echo '<label for="mdp">Mot de passe : </label><input type="text" name="mdp" value='.$_SESSION['mdp'].'><br>';
                                echo '</p>';
                                echo '<p>';
                                echo '<label for="rue">Rue : </label><input type="text" name="rue" value='.$_SESSION['rue'].'><br>';
                                echo '</p>';
                                echo '<p>';
                                echo '<label for="ville">Ville : </label><input type="text" name="ville" value='.$_SESSION['ville'].'><br>';
                                echo '</p>';
                                echo '<p>';
                                echo '<label for="pays">Pays : </label><input type="text" name="pays" value='.$_SESSION['pays'].'><br>';
                                echo '</p>';
                                echo '<p>';
                                echo '<input type="submit" name="send_modif">';
                                echo '</p>';
                                echo '</form>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>


        </div>


        <?php
        }

        //insertions des nouvelles valeurs
        if(isset($_POST['send_modif'])) {
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $rue = htmlspecialchars($_POST['rue']);
            $ville = htmlspecialchars($_POST['ville']);
            $pays = htmlspecialchars($_POST['pays']);

            $id_client = $_SESSION['id_client'];

            $insertNew = $bdd->prepare("update client
            set nom = :nom, prenom = :prenom, mdp = :mdp, rue = :rue, ville = :ville, pays = :pays
            where id_client = :id_client");
            $insertNew->execute(array(
                'nom' => $nom,
                'prenom' => $prenom,
                'mdp' => $mdp,
                'rue' => $rue,
                'ville' => $ville,
                'pays' => $pays,
                'id_client' => $id_client
            ));
            
            //actualisation des variables de session
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['rue'] = $rue;
            $_SESSION['ville'] = $ville;
            $_SESSION['pays'] = $pays;

            //Actualisation de la page
            header('Location: espace_membre.php');
        }

        include('footer.php');

        ?>

    </body>
</html>