<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <title>Mon panier</title>
    </head>
    <body>

        <?php include('header.php') ?>
        <?php include_once('fonctions_php/fonction_panier.php'); ?>

        <h3>Mon panier</h3>

        <?php
        if(!isset($_SESSION['panier'])) {
            creationPanier();
        }
        if(estVide()) {
            echo '<h2> Votre panier est vide :( </h2>';
        } else {
            
        
        ?>
        <table class="table">
            <tbody>
                <tr>
                    <th>Libelle</th>
                    <th>Prix</th>
                    <th>Quantite</th>
                </tr>
            </tbody>

        </table>
        
        <?php 
        }
        ?>


        <?php include('footer.php') ?>

    </body>
</html>