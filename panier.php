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
        //Le panier est vide donc on affiche une phrase
        if(estVide()) {
            echo '<h2> Votre panier est vide :( </h2>';
        } else {    //Panier non vide => affichage d'une table


        ?>
        <table class="table">
            <tbody>
                <tr>
                    <th>Libelle</th>
                    <th>Prix</th>
                    <th>Quantite</th>
                </tr>
            </tbody>
            <?php
            $nbProduit = count($_SESSION['panier']['idProduit']);
            for($i = 0; $i < $nbProduit; $i++) {
                echo '<tr>';
                echo '<td>'.$_SESSION['panier']['libelleProduit'][$i].'</td>';
                echo '<td>'.$_SESSION['panier']['prixProduit'][$i].'</td>';
                echo '<td>'.$_SESSION['panier']['qteProduit'][$i].'</td>';
                echo '</tr>';
            }
            
            ?>

        </table>

        <?php 
        }
        ?>


        <?php include('footer.php') ?>

    </body>
</html>