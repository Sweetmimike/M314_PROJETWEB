<?php
session_start();
include_once('fonctions_php/fonction_bdd.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <title>Ma commande</title>
    </head>
    <body>

        <?php
        include_once('fonctions_php/fonction_panier.php');
        
        if(estVide()) {
            header('Location: panier.php');
        }

        if(!isset($_SESSION['email']) || !isset($_SESSION['nom'])) {
        ?>

        <p>Veuillez vous connecter avant de passer la commande</p>


        <?php
        } else if(isset($_POST['valider_commande'])){
            $rue = htmlspecialchars($_POST['rue']);
            $ville = htmlspecialchars($_POST['ville']);
            $pays = htmlspecialchars($_POST['pays']);


        ?>

        <?php include('header.php') ?>
        <h3>Récapitulatif de la commande passée</h3>

        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <table class="table w-75 mx-auto bg-light">
                        <tbody>
                            <tr>
                                <th>Article</th>
                                <th>Prix</th>
                                <th>Quantite</th>
                            </tr>

                            <?php
            $montantTotal = MontantGlobal();
            $nbProduit = count($_SESSION['panier']['idProduit']);
            for($i = 0; $i < $nbProduit; $i++) {
                echo '<tr>';
                echo '<td>'.$_SESSION['panier']['libelleProduit'][$i].'</td>';
                echo '<td>'.$_SESSION['panier']['prixProduit'][$i].'</td>';
                echo '<td>'.$_SESSION['panier']['qteProduit'][$i].'</td>';
                echo '</tr>';
            }

                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-2 bg-light">
                    <p><span class="font-weight-bold">Nombre d'article(s) :</span> <?php echo $nbProduit; ?></p>
                    <p><span class="font-weight-bold">Pour un montant total de :</span> <?php echo $montantTotal.'€'; ?></p>
                    <p>
                        La commande sera livrée à l'adresse renseignée dans vos informations : <br>
                        <?php echo '<span class="font-weight-bold">'.$rue. ' à ' .$ville. ' en ' .$pays.'</span>'; ?>

                    </p>
                    <p>Un mail concernant le récapitulatif de la commande va vous être envoyé.</p>

                    <?php
            //création du mail pour l'envoi
            $to = $_SESSION['email'];
            $from = 'aurelien.carpentier@etu.unice.fr';

            $objet = "Achat sur ...";

            $message = "Merci d'avoir commandé sur notre site ! Voici votre récapitulatif de commande : <br>
                    Vous avez acheté $nbProduit produit(s)<br>
                    Pour un total de : $montantTotal €<br>
                    Produit(s) acheté(s) : <br>";
            for($i = 0; $i < $nbProduit; $i++) {
                $message.= "- ".$_SESSION['panier']['libelleProduit'][$i].'<br>';
            }
            $message .= "<br>A bientôt sur notre site !";

            $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
            $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
            $headers .= 'Reply-To: '.$from."\n"; // Mail de reponse
            $headers .= 'From: "e-commerce"<'.$from.'>'."\n"; // Expediteur

            //envoi du mail
            mail($to, $objet, $message, $headers);


            //insertion des infos dans la base de données : 
            $bdd = connectLocalhost();
            $idClient = $_SESSION['id_client'];
            $date = date("Y-m-d H:i:s");
            echo $date;
            $req = $bdd->prepare("insert into facture (laDate, prix, id_client) values(now(), $montantTotal, $idClient)");
            $req->execute();

            $req2 = $bdd->query("select * from facture where id_client = $idClient order by id_facture DESC limit 0,1");
            $s = $req2->fetch();
            $id_facture = $s['id_facture'];

            for($i = 0; $i < $nbProduit; $i++) {
                $req3 = $bdd->prepare("insert into facture_details (id_produit, id_facture, prix_total, quantite) values (:id_produit, :id_facture, :prix_total, :quantite)");
                $req3->execute(array(
                    'id_produit' => $_SESSION['panier']['idProduit'][$i],
                    'id_facture' => $id_facture,
                    'prix_total' => $_SESSION['panier']['prixProduit'][$i] * $_SESSION['panier']['qteProduit'][$i],
                    'quantite' => $_SESSION['panier']['qteProduit'][$i]
                ));

                
            }

                    supprimePanier();
                    ?>
                </div>
            </div>
        </div>


        <?php
        }
        ?>

        <?php include('footer.php') ?>
    </body>
</html>