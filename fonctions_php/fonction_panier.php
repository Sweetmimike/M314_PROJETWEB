<?php


function creationPanier(){
    if (!isset($_SESSION['panier'])){
        $_SESSION['panier'] = array();
        $_SESSION['panier']['idProduit'] = array();
        $_SESSION['panier']['libelleProduit'] = array();
        $_SESSION['panier']['qteProduit'] = array();
        $_SESSION['panier']['prixProduit'] = array();
        $_SESSION['panier']['verrou'] = false;
    }
    return true;
}

function estVide() {
    if(creationPanier()) {
        if(empty($_SESSION['panier']['libelleProduit'])) {
            return true;
        }
    }
    return false;
}

function ajouterArticle($idProduit, $libelleProduit, $qteProduit, $prixProduit){

    //Si le panier existe
    if (creationPanier() && !isVerrouille())
    {
        //Si le produit existe déjà on ajoute seulement la quantité
        $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

        if ($positionProduit !== false)
        {
            $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
        }
        else
        {
            //Sinon on ajoute le produit
            array_push( $_SESSION['panier']['idProduit'],$idProduit);
            array_push( $_SESSION['panier']['libelleProduit'],$libelleProduit);
            array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
            array_push( $_SESSION['panier']['prixProduit'],$prixProduit);
        }
    }
    else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

function isVerrouille(){
    if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
        return true;
    else
        return false;
}

function compterArticles()
{
    if (isset($_SESSION['panier']))
        return count($_SESSION['panier']['libelleProduit']);
    else
        return 0;

}

function supprimePanier(){
    unset($_SESSION['panier']);
}

function MontantGlobal(){
    $total=0;
    for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
    {
        $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
    }
    return $total;
}


?>