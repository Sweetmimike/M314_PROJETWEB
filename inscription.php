<?php
session_start();
include_once('fonctions_php/fonction_bdd.php');

$bdd = connectLocalhost();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="css/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body>

    <?php include('header.php');?>


    <section>
        <div class="container p-3 bg-f3 border rounded shadow-sm">
            <form action="inscription.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom : </label><input type="text" name="nom" class="form-control">
                </div>
                <div class="form-group">
                    <label for="prenom">Prenom : </label><input type="text" name="prenom" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email : </label><input type="text" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe : </label><input type="password" name="mdp" class="form-control">
                </div>
                <div class="form-group">
                    <label for="c_mdp">Confirmer : </label><input type="password" name="c_mdp" class="form-control">
                </div>
                <div class="form-group">
                    <label for="rue">Rue : </label><input type="text" name="rue" class="form-control">
                </div>
                <div class="form-group">
                    <label for="ville">Ville : </label><input type="text" name="ville" class="form-control">
                </div>
                <div class="form-group">
                    <label for="pays">Pays : </label><input type="text" name="pays" class="form-control">
                </div>
                <input type="submit" name="envoyer" value="Envoyer" class="form-control btn btn-primary">
            </form>
        </div>
    </section>

    <?php

        //expression régulière permettant de verifier la validité de l'adresse mail
    $expr_mail = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{1,}$#";

    if(isset($_POST['envoyer'])) {

        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $c_mdp = htmlspecialchars($_POST['c_mdp']);
        $rue = htmlspecialchars($_POST['rue']);
        $ville = htmlspecialchars($_POST['ville']);
        $pays = htmlspecialchars($_POST['pays']);

        if(!empty($nom) && !empty($prenom) && !empty($email) && !empty($mdp) && !empty($c_mdp)
           && !empty($rue) && !empty($ville) && !empty($pays)) {

            /* test de l'adresse mail*/
        if(preg_match($expr_mail, $_POST['email'])) {
            if($mdp == $c_mdp) {

                /* Test pour savoir si l'utilisateur est déjà inscrit */
                $req_check = $bdd->prepare('select email from client where email = :email');
                $req_check->execute(array('email' => $email));

                /* Si on ne trouve pas de résultat alors le client peut être inscrit */
                if(!($req_check->fetch())) {

                    $req = $bdd->prepare('insert into client (nom, prenom, email,rue, ville, pays, mdp) values(:nom, :prenom, :email, :rue, :ville, :pays, :mdp)');
                    $req->execute(array(
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'email' => $email,
                        'rue' => $rue,
                        'ville' => $ville,
                        'pays' => $pays,
                        'mdp' => $mdp));
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