<?php 
session_start() 


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
    try {

        $bdd = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(Exception $e) {

        die('Erreur : ' . $e ->getMessage());

    }

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

                <div class="col-2">
                    <p style="text-align: center">Mes factures</p>

                    <?php


            $req = $bdd->prepare('select * from facture f, client c where f.id_client = c.id_client && c.email = :email');
            $req->execute(array('email' => $_SESSION['email']));
            $i = 1;
            while($s = $req->fetch()) {
                
                echo '<h4>Facture '.$i.'</h4>';
                echo '<ul>';
                echo '<li>'.s['date'].'</li>';
                echo '<li>'.s['prix'].'</li>';
                echo '</ul>';
                
                $i++;
            }
                    ?>
                </div>

                <div class="col-1">

                </div>

                <div class="col-4">
                    <p style="text-align: center">Mes informations</p>

                    <?php

            $email = $_SESSION['email'];
            //Récuperation des infos
            $req = $bdd->prepare('select * from client where email=:email'); 
            $req->execute(array('email' => $email));
            $infos = $req->fetch();
            $req->closeCursor();
                    ?>


                    <div class="container-fluid">
                        <ul>
                            <li>Nom : <?php echo $infos['nom'] ?></li>
                            <li>Prenom : <?php echo $infos['prenom'] ?></li>
                            <li>Email : <?php echo $infos['email'] ?></li>
                            <li>Rue : <?php echo $infos['rue'] ?></li>
                            <li>Ville : <?php echo $infos['ville'] ?></li>
                            <li>Pays : <?php echo $infos['pays'] ?></li>
                        </ul>
                    </div>
                </div>

            </div>


        </div>


        <?php
        }

        include('footer.php');

        ?>

    </body>
</html>