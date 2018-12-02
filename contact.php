<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Contact</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body>

	<?php include('header.php') ?>

	<section>
		<div id="form-container">
			<form action="contact.php" method="post" id="mailto">
				<label for="email">Email : <input type="text" name="email"></label>
				<label for="objet">Objet : <input type="text" name="objet"></label>
				<label for="">Votre message : <textarea name="msg" id="msg" cols="50" rows="6"></textarea></label>
				<input type="submit" name="envoyer" value="Envoyer">
			</form>
		</div>
	</section>
	
	<?php include('footer.php'); ?>

	
	<?php 

	if(isset($_POST['envoyer'])) {
		if(!empty($_POST['email']) && !empty($_POST['objet']) && !empty($_POST['msg'])) {
			$message = $_POST['msg'];
			$objet = $_POST['objet'];
			$expediteur = $_POST['email'];
			$destinataire = 'aurelien.carpentier@etu.unice.fr';
			$headers = 'From: '.$expediteur.'\r\n';

			mail($destinataire, $objet, $message, $headers);
		}
		
	}

	?>

</body>
</html>