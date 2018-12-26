<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Accueil</title>
	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include('header.php'); ?>

	<section>
		<div>
			<p>
				Bienvenue sur le site de notre projet PHP. Dans le cadre de notre DUT informatique, il nous a été proposé de réaliser un site web de e-commerce.
			</p>
			<p>
				Le but étant de réaliser ce site avec un espace membre public et un espace d'administration dont l'accès ne sera autorisé qu'aux admins.
			</p>
		</div>
	</section>

	<?php include('footer.php'); ?>
	
</body>
</html>