<?php

try {
    
    $bdd = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'root', '');
    
} catch(Exception $e) {
    
    die('Erreur : ' . $e ->getMessage());
    
}


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Inscription</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>

        <?php include('header.php');?>


        <section>
            <div id="form-container">
                <form action="inscription.php" method="post">
                    <label for="nom">Nom : <input type="text" name="nom"></label>
                    <label for="prenom">Prenom : <input type="text" name="prenom"></label>
                    <label for="email">Email : <input type="text" name="email"></label>
                    <label for="mdp">Mot de passe : <input type="password" name="mdp"></label>
                    <label for="c_mdp">Confirmer : <input type="password" name="c_mdp"></label>
                    <input type="submit" name="envoyer" value="Envoyer">
                </form>
            </div>
        </section>


        <?php include('footer.php');?>
        
        <?php 
        
        if(!isset($_POST['envoyer'])) {
            
        }
        
        ?>

    </body>
</html>