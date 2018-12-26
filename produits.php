

<?php 

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>Nos produits</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>

        <?php include('header.php'); ?>

        <section>
            <table id="table-produit">
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix €</th>
                </tr>
                <?php 

                //Récupération des produits dans la db
                $produits = $bdd->query('select * from produit');

                //affichage
                while($item = $produits->fetch())
                {
                    echo '<tr>';
                    echo '<td>'.$item['intitule'].'</td>';
                    echo '<td>'.$item['description'].'</td>';
                    echo '<td>'.$item['prix_ttc'].'<button class="button_panier" type="button">ajouter au panier</button></td>';
                    echo '</tr>';
                }
                $produits->closeCursor();

                ?>

            </table>
        </section>





        <?php include('footer.php'); ?>

    </body>
</html>