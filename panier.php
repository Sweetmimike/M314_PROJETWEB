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
        if(!estVide()) {
        ?>
        <p><a href="?action=vider_panier" class="btn btn-danger btn-sm">Vider mon panier</a></p>
        <?php
        }
        ?>

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
                    <th>Article</th>
                    <th>Prix</th>
                    <th>Quantite</th>
                </tr>

                <?php
            $montantTotal = MontantGlobal();
            $nbProduit = count($_SESSION['panier']['idProduit']);
            for($i = 0; $i < $nbProduit; $i++) {
                echo '<tr>';
                echo '<td>'.$_SESSION['panier']['libelleProduit'][$i].'</td>';
                echo '<td>'.$_SESSION['panier']['prixProduit'][$i].'</td>';
                echo '<td>'.$_SESSION['panier']['qteProduit'][$i].'</td>';
                echo '</tr>';
            }

                ?>
            </tbody>
        </table>
        <p>Prix total : <?php echo $montantTotal . ' €'; ?></p>

        <?php 
            echo '<p><a href="?action=passer_commande" class="btn btn-primary mt-4 mb-4 float-right">Passer ma commande</a>';
        }
        ?>

        <?php
        if(isset($_GET['action'])) {
            if($_GET['action'] == 'vider_panier') {
                supprimePanier();
                header('Location: panier.php');
            }
            if($_GET['action'] == 'passer_commande') {
                
                header('Location: commande.php');
            }
        }
        ?>

        <?php include('footer.php') ?>

    </body>
</html>