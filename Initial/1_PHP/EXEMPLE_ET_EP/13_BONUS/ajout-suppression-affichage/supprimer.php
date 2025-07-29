<?php 
    if (!isset($_GET['id']) || empty($_GET['id'])){
        die('ID INTROUVABLE');
    }

    require_once('./fonction_bdd.php');

    $connexionBDD = connexionBDD();
    supprimerUnUtilisateur($connexionBDD, $_GET['id']);
    header("Location: http://127.0.0.1:8080/13_BONUS");
?>