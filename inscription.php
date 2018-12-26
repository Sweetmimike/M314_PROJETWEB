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
                    <label for="c_mdp">Rue : <input type="text" name="rue"></label>
                    <label for="c_mdp">Ville : <input type="text" name="ville"></label>
                    <label for="c_mdp">Pays : <input type="text" name="pays"></label>
                    <input type="submit" name="envoyer" value="Envoyer">
                </form>
            </div>
        </section>

        <?php
        
        //expression régulière permettant de verifier la validité de l'adresse mail
        $expr_mail = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{1,}$#";

        if(isset($_POST['envoyer'])) {
            if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['mdp']) && !empty($_POST['c_mdp'])
               && !empty($_POST['rue']) && !empty($_POST['ville']) && !empty($_POST['pays'])) {
                
                /* test de l'adresse mail*/
                if(preg_match($expr_mail, $_POST['email'])) {
                    if($_POST['mdp'] == $_POST['c_mdp']) {

                        /* Test pour savoir si l'utilisateur est déjà inscrit */
                        $req_check = $bdd->prepare('select email from client where email = :email');
                        $req_check->execute(array('email' => $_POST['email']));

                        /* Si on ne trouve pas de résultat alors le client peut être inscrit */
                        if(!($req_check->fetch())) {

                            $req = $bdd->prepare('insert into client (nom, prenom, email,rue, ville, pays, mdp) values(:nom, :prenom, :email, :rue, :ville, :pays, :mdp)');
                            $req->execute(array(
                                'nom' => $_POST['nom'],
                                'prenom' => $_POST['prenom'],
                                'email' => $_POST['email'],
                                'rue' => $_POST['rue'],
                                'ville' => $_POST['ville'],
                                'pays' => $_POST['pays'],
                                'mdp' => $_POST['mdp']));
                            echo '<p class="rep_inscription">Inscription reussi !</p>';
                            echo '<p class="rep_inscription"><a href="connexion.php">Cliquez ici pour vous connecter</a></p>';
                        } else {
                            echo '<p class="rep_inscription">Cette adresse email est déjà enregistrée !</p>';
                        }
                    } else {
                        echo '<p class="rep_inscription">Les mots de passes doivent être identiques</p>';
                    }
                } else {
                    echo '<p class="rep_inscription">L\'email n\'est pas conforme, il doit etre du type aa@aa.aa</p>';
                }
            } else {
                echo '<p class="rep_inscription">Tous les champs sont obligatoires !</p>';
            }
        }

        ?>


        <?php include('footer.php'); ?>



    </body>
</html>