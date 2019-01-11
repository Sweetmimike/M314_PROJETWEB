<?php 

session_start();
include_once('fonctions_php/fonction_bdd.php');
$bdd = connectLocalhost();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="css/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<title>Comptabilité</title>
</head>
<body>

	<?php include('header.php'); ?>


	<div class="container">
		<h3>Espace comptabilité</h3>
		<form action="?action=select_mois" class="mt-3 mb-3" method="post">
			<div class="form-group">
				<label for="mois">Selectionnez le mois : </label>
				<select name="mois" id="mois" class="form-control">
					<option value="01">Janvier</option>
					<option value="02">Fevrier</option>
					<option value="03">Mars</option>
					<option value="04">Avril</option>
					<option value="05">Mai</option>
					<option value="06">Juin</option>
					<option value="07">Juillet</option>
					<option value="08">Aout</option>
					<option value="09">Septembre</option>
					<option value="10">Octobre</option>
					<option value="11">Novembre</option>
					<option value="12">Decembre</option>
				</select>
			</div>
			<div class="form-group">
				<label for="mois">Selectionnez l'année : </label>
				<select name="annee" id="annee" class="form-control">
					<?php 

					for($i = 2000; $i <= date('Y'); $i++) {
						echo "<option value=$i>$i</option>";
					}

					 ?>
				</select>
			</div>
			<input class="btn btn-primary" type="submit" value="Valider" name="valider_select_mois">
		</form>
		<?php

		if(isset($_POST['valider_select_mois'])) {
			$nbProduitVendu = 0;
			$prixTotal = 0;
			$mois_actuelle = $_POST['mois'];
			$annee_actuelle = $_POST['annee'];
			$select = $bdd->query("select prix, Month(laDate) as mois, year(laDate) as annee from facture");
			while($res = $select->fetch()) {
				if($res['mois'] == $mois_actuelle && $res['annee'] == $annee_actuelle){
					$nbProduitVendu++;
					$prixTotal += $res['prix'];
				}
			}
			$select->closeCursor();


			?>
			<p>Nombre de produit vendu ce mois-ci : <span class="font-weight-bold"><?php echo $nbProduitVendu; ?></span></p>
			<p>Total : <span class="font-weight-bold"><?php echo $prixTotal; ?> €</span></p>
		<?php } ?>
	</div>


	<?php include('footer.php'); ?>
	
</body>
</html>