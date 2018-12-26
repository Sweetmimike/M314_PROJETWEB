<?php 
session_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>Connexion</title>
</head>
<body>
   <?php include('header.php');?>
   
   
   <section>
		<div id="form-container">
			<form action="connexion.php" method="post">
				<label for="email">Email : <input type="text" name="email"></label>
				<label for="objet">Mot de passe : <input type="password" name="mdp"></label>
				<input type="submit" name="envoyer" value="Envoyer">
			</form>
		</div>
	</section>
   

   
    
   
   <?php 


 

$bdd = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'root', 'root');
// Vérification de la validité des informations

// Hachage du mot de passe
//$pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

// Insertion
/*$req = $bdd->prepare('INSERT INTO membres(pseudo, mdp, email, date_inscription) VALUES(:pseudo, :pass, :email, CURDATE())');
$req->execute(array(
    'pseudo' => $pseudo,
    'pass' => $pass_hache,
    'email' => $email));
*/
//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT nom, prenom, email, mdp FROM client WHERE email = :email');
$req->execute(array(
    'email' => $_POST['email']));
$resultat = $req->fetch();




// Comparaison du pass envoyé via le formulaire avec la base
//$isPasswordCorrect = password_verify($_POST['mdp'], $resultat['mdp']);


/*if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passes !';
}*/
//else
//{
if(isset($_POST['envoyer']))

{

	     $message='';
    if (empty($_POST['email']) || empty($_POST['mdp']) ) //Oublie d'un champ
    {
        $message = '<p>une erreur s\'est produite pendant votre identification.
	Vous devez remplir tous les champs</p>';
	echo $message;

	
    }
    else if ($_POST['mdp'] = $resultat['mdp']) {
        
        //$_SESSION['id_client'] = $resultat['id_client'];
      
        echo 'Vous êtes connecté !';
        $_SESSION['nom'] = $resultat['nom'];
         $_SESSION['prenom'] = $resultat['prenom'];
          $_SESSION['email'] = $resultat['email'];
           $_SESSION['mdp'] = $resultat['mdp'];
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
//}
}
?>

<?php include('footer.php');?>


    
</body>
</html>