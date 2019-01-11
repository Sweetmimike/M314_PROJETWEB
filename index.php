<?php session_start() 

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>

        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
        <?php include('header.php'); ?>
        <?php include_once('fonctions_php/fonction_panier.php');
        creationPanier(); ?>

        <div class="container w-75">
            <div class="row">
                <div class="col-md-7">
                    <h2>Trouvez votre bonheur sur Product4U</h2>
                    <p>Product4U dispose d'un large catalogue de produit HighTech<br>
                    A consommer sans modération</p>
                </div>
                <div class="col-md-5">
                    <img src="img/shopping-cart.svg" alt="shopping-cart" width="200px">
                </div>
            </div>
            <hr class="featurette-divider">
            <div class="row">
                <div class="col-md-5">
                    <img src="img/settings.png" alt="settings" width="200px;">
                </div>
                <div class="col-md-7">
                    <h2>Un support de haute qualité</h2>
                    <p>Le support est disponible 24h/24 et 7j/7 par email, mais aussi par téléphone <br>
                    Rendez vous dans la section support pour plus de renseignements</p>
                </div>
            </div>
            <hr class="featurette-divider">
            <div class="row">
                <div class="col-md-7">
                    <h2>Une livraison express</h2>
                    <p>Notre service vous assure une livraison dans les plus bref délais</p>
                    
                </div>
                <div class="col-md-5">
                    <img src="img/paper-plane.png" alt="paper-plane" width="200px;">
                </div>
            </div>
            <a href="?action=go" class="d-block mx-auto mt-5 w-25 btn btn-dark btn-lg">Allons-y</a>
        </div>

        <?php

        if(isset($_GET['action'])) {
            if($_GET['action'] == 'go' && !isset($_SESSION['email'])) {
                header('Location: inscription.php');
            } else if($_GET['action'] == 'go' && isset($_SESSION['email'])) {
                header('Location: produits.php');
            }
        }

        ?>



        <?php include('footer.php'); ?>

    </body>
</html>