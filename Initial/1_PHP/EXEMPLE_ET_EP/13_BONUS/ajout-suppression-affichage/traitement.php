<?php 
    require_once('./fonction_traitement.php');
    require_once('./fonction_bdd.php');
    if (!verifierSiChampExisteEtNonVide('email-input')) {
        header("Location: http://127.0.0.1:8080/13_BONUS/form.php?erreur=".urlencode('Email manquant'));
        return;
    }

    if (!verifierSiChampExisteEtNonVide('username-input')) {
        header("Location: http://127.0.0.1:8080/13_BONUS/form.php?erreur=".urlencode('Username manquant'));
    }

    if (!verifierSiChampExisteEtNonVide('password-input')) {
        header("Location: http://127.0.0.1:8080/13_BONUS/form.php?erreur=".urlencode('Mot de passe manquant'));
    }

    $donneesFormulaire = [
        'email' => nettoyerLaVariable($_POST['email-input']),
        'username' => nettoyerLaVariable($_POST['username-input']),
        'password' => nettoyerLaVariable($_POST['password-input']),
    ];

    if (!verifierSiCestUnEmailValide($donneesFormulaire['email'])){
        header("Location: http://127.0.0.1:8080/13_BONUS/form.php?erreur=".urlencode('Email invalide'));
    }

    $connexionBDD = connexionBDD();
    $retourBDD = insererUnUtilisateur($connexionBDD, $donneesFormulaire['username'], $donneesFormulaire['email'], $donneesFormulaire['password']);
    if ($retourBDD){
        die($retourBDD);
    }else{
        header("Location: http://127.0.0.1:8080/13_BONUS");
    }

?>