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
    <title>Mon panier</title>
</head>
<body>

    <?php include('header.php') ?>
    <?php include_once('fonctions_php/fonction_panier.php'); ?>

    <div class="container p-3">
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
        
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Article</th>
                    <th>Prix €</th>
                    <th>Quantite</th>
                </tr>
            </thead>
            <tbody>

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
</div>

<?php
$bdd = connectLocalhost();


if(isset($_GET['action'])) {
    if($_GET['action'] == 'vider_panier') {

        for($i = 0; $i < $nbProduit; $i++) {
            $req = $bdd->prepare('update produit set quantite = quantite+:quantite where id_produit = :id_produit');
            $req->execute(array('id_produit' => $_SESSION['panier']['idProduit'][$i], 'quantite' => $_SESSION['panier']['qteProduit'][$i]));
        }

        supprimePanier();
        header('Location: panier.php');
    }
    if($_GET['action'] == 'passer_commande') {
       ?>

        <form action="commande.php" method="POST">
            <div class="form-group">
                <label for="rue">Rue : </label>
                <input type="text" name="rue" class="form-control">
            </div>
             <div class="form-group">
                <label for="rue">Ville : </label>
                <input type="text" name="ville" class="form-control">
            </div>
             <div class="form-group">
                <label for="rue">Pays : </label>
                <input type="text" name="pays" class="form-control">
            </div>
            <input type="submit" name="valider_commande" class="btn btn-outline-primary" value="Valider">
        </form>

       <?php

        
    }
}
?>

<?php include('footer.php') ?>

</body>
</html>