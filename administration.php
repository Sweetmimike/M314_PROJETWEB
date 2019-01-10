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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>Administration</title>
</head>
<body>

    <?php if($_SESSION['email'] != 'admin@gmail.com') {header('Location: index.php');} ?>

    <?php include('header.php'); ?>

    <h2>Bienvenue sur la page d'administration</h2>
    <p>Ici vous pouvez gérer les comptes client, les produits ainsi que les fournisseurs.</p>

    <a href="?action=client">Action sur les clients</a>
    <a href="?action=produit">Action sur les produits</a>
    <a href="?action=fournisseur">Action sur les fournisseurs</a>

    <?php 
    if(isset($_GET['action'])) {
        if($_GET['action'] == 'client') {
            $select = $bdd->query('SELECT * FROM client');
            echo '<h3>Liste des clients</h3>';
            echo '<table class="administration_table">';
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
                echo '<td><a href="?action=delete_client&id_client='.$s['id_client'].'">oui</a></td>';
                echo '</tr>';
            }
            $select->closeCursor();


            echo '</table>';
        } else if($_GET['action'] == 'fournisseur') {
            $select = $bdd->query('SELECT * FROM fournisseur');

            echo "<div class='container-fluid w-75 mt-3 p-3 bg-light border rounded'>";
            echo "<h3>Liste des fournisseurs</h3>";
            echo "<table class='table table-bordered table-light'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Nom</th>";
            echo "<th>Adresse</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($s = $select->fetch()) {
                echo "<tr>";
                echo "<td>".$s['nom']."</td>";
                echo "<td>".$s['adresse']."
                <a href='?action=delete_fournisseur&amp;id_fournisseur='".$s['id_fournisseur']."' class='btn btn-danger btn-sm float-right'>supprimer</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<a href='?action=ajouter_fournisseur' class='btn btn-outline-primary'>ajouter</a>";
            echo "</div>";
        }
        else if($_GET['action'] == 'produit') {

            echo '<p><a href="?action=ajouter_produit">Ajouter un produit</a></p>';

            $select = $bdd->query('SELECT * FROM produit');
            echo '<h3>Liste des produits</h3>';
            echo '<table class="administration_table">';
            echo '<tr>';
            echo '<th>Intitule</th>';
            echo '<th>Description</th>';
            echo '<th>Quantite</th>';
            echo '<th>Action</th>';
            echo '</tr>';

            while($s = $select->fetch()) {
                echo '<tr>';
                echo '<td>'.$s['intitule'].'</td>';
                echo '<td>'.$s['description'].'</td>';
                echo '<td>'.$s['quantite'].'</td>';
                echo '<td><a href="?action=delete_produit&id_produit='.$s['id_produit'].'">Supprimer</a> / <a href="?action=modifier_produit&id_produit='.$s['id_produit'].'">Modifier</a></td>';
                echo '</tr>';
            }
            $select->closeCursor();


            echo '</table>';

        }
        else if($_GET['action'] == 'delete_client') {
            $id_client = $_GET['id_client'];
            $delete = $bdd->prepare("delete from client where id_client = $id_client");
            $delete->execute();
        }
        else if($_GET['action'] == 'delete_produit') {
            $id_produit = $_GET['id_produit'];
            $delete = $bdd->prepare("delete from produit where id_produit = $id_produit");
            $delete->execute();
        } else if($_GET['action'] == 'delete_fournisseur') {
            $id_fournisseur = $_GET['id_fournisseur'];
            $delete = $bdd->prepare("delete from fournisseur where id_fournisseur = $id_fournisseur");
            $delete->execute();
        } else if($_GET['action'] == 'ajouter_fournisseur') {
            ?>
            
            <div class="container-fluid p-2">
                <form class='form-inline' action='administration.php' method="POST">
                    <label for='nom' class='mr-2'>Nom : </label>
                    <input type='text' class='form-control mr-2' name='nom' placeholder='ex : Apple'>
                    <label for='adresse' class='mr-2'>Adresse : </label>
                    <input type='text' class='form-control mr-2' name='adresse' placeholder='ex : 2 place Massena'>
                    <input type='submit' class='form-control btn btn-primary mr-2' name='valider_fournisseur' value='Valider'>
                </form>
            </div>

            <?php
        } 
        else if($_GET['action'] == 'modifier_produit') {
            $id_produit = $_GET['id_produit'];
            $select = $bdd->query("select * from produit where id_produit = $id_produit");
            $s = $select->fetch();
            ?>
            <!-- formulaire de modification -->
            <form action="administration.php" method="post" id="modif_produit">
                <label for="intitule">Intitule :</label><input type="text" name="intitule" value="<?php echo $s['intitule']?>"><br>
                <label for="description">Description :</label><input type="text" name="description" value="<?php echo $s['description']?>"><br>
                <label for="prix_ht">Prix ht :</label><input type="text" name="prix_ht" value="<?php echo $s['prix_ht']?>"><br>
                <label for="prix_ttc">Prix ttc :</label><input type="text" name="prix_ttc" value="<?php echo $s['prix_ttc']?>"><br>
                <label for="quantite">Quantite :</label><input type="text" name="quantite" value="<?php echo $s['quantite']?>"><br>
                <label for="id_produit">Id du produit :</label><input type="text" name="id_produit" value="<?php echo $s['id_produit']?>" readonly><br> <!-- Readonly car l'id ne doit pas etre modifiable, juste pour qu'il soit envoyer pour faire les modif après -->
                <input type="submit" value="Valider" name="valider_modif"><br>
            </form>

            <?php
        }
        else if($_GET['action'] == 'ajouter_produit') {
            ?>


            <!-- formulaire d'ajout -->
            <form action="administration.php" method="post" id="ajouter_produit">
                <label for="intitule">Intitule : </label><input type="text" name="intitule"><br>
                <label for="description">Description : </label><input type="text" name="description" ><br>
                <label for="prix_ht">Prix ht : </label><input type="text" name="prix_ht" ><br>
                <label for="prix_ttc">Prix ttc : </label><input type="text" name="prix_ttc" ><br>
                <label for="quantite">Quantite : </label><input type="text" name="quantite" ><br>
                <label for="id_fournisseur">Fournisseur : </label>
                <select name="id_fournisseur">
                    <?php

                    $req = $bdd->query('select * from fournisseur');
                    while($s = $req->fetch()) {
                        echo '<option value="'.$s['id_fournisseur'].'">'.$s['nom'].'</option>';
                    }
                    $req->closeCursor();

                    ?>
                </select><br>
                <input type="submit" value="Valider" name="valider_ajout"><br>
            </form>


            <?php
        }


        if(isset($_POST['valider_modif'])) {
            $update = $bdd->prepare('update produit 
                set intitule = :intitule, description = :description, prix_ht = :prix_ht, prix_ttc = :prix_ttc, quantite = :quantite 
                where id_produit = :id_produit');
            $update->execute(array(
                'intitule' => $_POST['intitule'],
                'description' => $_POST['description'],
                'prix_ht' => $_POST['prix_ht'],
                'prix_ttc' => $_POST['prix_ttc'],
                'quantite' => $_POST['quantite'],
                'id_produit' => $_POST['id_produit']
            ));
        }

        if(isset($_POST['valider_ajout'])) {
            if(!empty($_POST['intitule']) && !empty($_POST['description']) && !empty($_POST['prix_ht']) 
               && !empty($_POST['prix_ttc']) && !empty($_POST['quantite']) && !empty($_POST['id_fournisseur']) ) {

                $insert = $bdd->prepare('insert into produit (intitule, description, prix_ht, prix_ttc, quantite, id_fournisseur) values(:intitule, :description, :prix_ht, :prix_ttc, :quantite, :id_fournisseur) ');
            $insert->execute(array(
                'intitule' => $_POST['intitule'],
                'description' => $_POST['description'],
                'prix_ht' => $_POST['prix_ht'],
                'prix_ttc' => $_POST['prix_ttc'],
                'quantite' => $_POST['quantite'],
                'id_fournisseur' => $_POST['id_fournisseur']
            ));
        }

    }

    if(isset($_POST['valider_fournisseur']) && !empty($_POST['nom']) && !empty($_POST['adresse'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $adresse = htmlspecialchars($_POST['adresse']);

        $insert = $bdd->prepare('INSERT INTO fournisseur (nom, adresse) VALUES(:nom, :adresse) ');
        $insert->execute(array(
            'nom' => $_POST['nom'],
            'adresse' => $_POST['adresse']
        ));
    } 



    ?>


    <?php include('footer.php'); ?>

</body>
</html>