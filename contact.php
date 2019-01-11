<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Contact</title>
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="css/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body>

	<?php include('header.php') ?>

	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<h3>Support</h3>
				Pour satisfaire au mieux nos clients, notre support client est disponible 24h/24 et 7j/7 en téléphonant au 0102030405.
				<br>
				<br>
				Vous pouvez aussi nous envoyer un mail en utilisant le formulaire, vous recevrez une réponse dans les 24h.
			</div>
			<div class="col-md-7">
				<div class="container bg-f3 p-3 border rounded">
					<form action="contact.php" method="post" id="" class="">
						<div class="form-group">
							<label for="email">Email : </label> <input type="text" name="email" class="form-control">
						</div>
						<div class="form-group">
							<label for="objet">Objet : </label><input type="text" name="objet" class="form-control">
						</div>
						<div class="form-group">
							<label for="">Votre message : </label><textarea name="msg" id="msg" cols="50" rows="6" class="form-control"></textarea>
						</div>
						<input type="submit" name="envoyer" value="Envoyer" class="form-control btn btn-primary">
					</form>
				</div>
			</div>
		</div>
		
	</div>
	
	
	<?php include('footer.php'); ?>

	
	<?php 

	if(isset($_POST['envoyer'])) {
		if(!empty($_POST['email']) && !empty($_POST['objet']) && !empty($_POST['msg'])) {
			$message = htmlspecialchars($_POST['msg']);
			$objet = htmlspecialchars($_POST['objet']);
			$expediteur = htmlspecialchars($_POST['email']);
			$destinataire = 'aurelien.carpentier@etu.unice.fr';
			$headers = 'From: '.$expediteur.'\r\n';

			mail($destinataire, $objet, $message, $headers);
		}
	}

	?>

</body>
</html>