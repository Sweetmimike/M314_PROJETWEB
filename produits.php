

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
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>

        <?php include('header.php'); ?>
        <?php include_once('fonctions_php/fonction_panier.php'); ?>

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
                    echo '<td>'.$item['prix_ttc'].'<a href="?action=ajouter_panier&idProduit='.$item['id_produit'].'&libelleProduit='.$item['intitule'].
                        '&qteProduit=1&prixProduit='.$item['prix_ttc'].'" class="btn btn-primary btn-sm button_panier">ajouter au panier</a></td>';
                    echo '</tr>';
                }
                $produits->closeCursor();

                ?>

            </table>
        </section>


        <?php
        
        if(isset($_GET['action'])) {
            if($_GET['action'] == 'ajouter_panier') {
                $id_produit = $_GET['idProduit'];
                $libelle_produit = $_GET['libelleProduit'];
                $quantite = $_GET['qteProduit'];
                $prix = $_GET['prixProduit'];
                    
                    
                    
                ajouterArticle($id_produit, $libelle_produit, $quantite, $prix);
            }
        }
        
        ?>


        <?php include('footer.php'); ?>

    </body>
</html>