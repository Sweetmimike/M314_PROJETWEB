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
   
   
    <?php include('footer.php');?>
   
    
</body>
</html>