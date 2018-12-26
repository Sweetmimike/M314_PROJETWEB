<?php 

session_start();

try {

    $bdd = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {

    die('Erreur : ' . $e ->getMessage());

}

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <title>Administration</title>
    </head>
    <body>

        <?php include('header.php'); ?>

        <h2>Bienvenue sur la page d'administration</h2>
        <p>Ici vous pouvez supprimer des comptes client, ajouter et supprimer des produits.</p>

        <a href="?action=client">Action sur les clients</a>
        <a href="?action=produit">Action sur les produits</a>

        <?php 
        if(isset($_GET['action'])) {
            if($_GET['action'] == 'client') {
                $select = $bdd->query('SELECT * FROM client');
                echo '<h3>Liste des clients</h3>';
                echo '<table>';
                echo '<tr>';
                echo '<th>Nom</th>';
                echo '<th>Prenom</th>';
                echo '<th>Email</th>';
                echo '<th>Supprimer</th>';
                echo '</tr>';

                while($s = $select->fetch()) {
                    echo '<tr>';
                    echo '<td>'.$s['nom'].'</td>';
                    echo '<td>'.$s['prenom'].'</td>';
                    echo '<td>'.$s['email'].'</td>';
                    echo '<td><a href="?action=delete&id_client='.$s['id_client'].'">oui</a></td>';
                    echo '</tr>';
                }
                $select->closeCursor();


                echo '</table>';
            }
            else if($_GET['action'] == 'produit') {

            }
            else if($_GET['action'] == 'delete') {
                $id_client = $_GET['id_client'];
                $delete = $bdd->prepare("delete from client where id_client = $id_client");
                $delete->execute();
            }
        }

        ?>


        <?php include('footer.php'); ?>

    </body>
</html>