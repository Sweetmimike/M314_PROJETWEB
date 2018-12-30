<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <title>Ma commande</title>
    </head>
    <body>
        <?php include('header.php') ?>
        <?php include_once('fonctions_php/fonction_panier.php'); ?>


        <?php include('footer.php') ?>
    </body>
</html>