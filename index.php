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

        <section>
            <div>
                <p>
                    Bienvenue sur le site de notre projet PHP. Dans le cadre de notre DUT informatique, il nous a été proposé de réaliser un site web de e-commerce.
                </p>
                <p>
                    Le but étant de réaliser ce site avec un espace membre public et un espace d'administration dont l'accès ne sera autorisé qu'aux admins.
                </p>
                <p>
                    Notre site web se nomme donc "Product4U". Pour acceder au à la page Administration du site, il faut s'y connecter avec comme identifiant : <span class="font-weight-bold">admin@gmail.com</span>, et comme mot de passe : <span class="font-weight-bold">admin</span>
                </p>
            </div>
        </section>

        <?php include('footer.php'); ?>

    </body>
</html>