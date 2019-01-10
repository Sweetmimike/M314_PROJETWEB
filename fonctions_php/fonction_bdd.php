<?php

function connectWebHost() {
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=id8437320_projet_php", 'id8437320_root', 'popopo06');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(Exception $e) {

        die('Erreur : ' . $e ->getMessage());

    }
    return $bdd;
}

function connectLocalhost() {
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=projet_php", 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(Exception $e) {

        die('Erreur : ' . $e ->getMessage());

    }
    return $bdd;
}

?>