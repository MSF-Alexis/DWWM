<?php 
    // Importation des différents fichiers de fonctions
    require_once('./fonctions/testeurUrl.php');
    require_once('./fonctions/formulaire.php');
    require_once('./fonctions/fonctionBdd.php');
    
    // Ici on test si l'id est présent dans l'url afin d'adapter notre requête plus 
    // bas dans le fichier
    if (estCeQuIlYaUnIdDansLUrl() && estCeQueLIdDansLUrlestBienUnNombre()){
        $infoUrlId = $_GET['id'];
    }

    // Si le formulaire du site est mal rempli on fait crasher le site
    if (!testerSiLeFormulaireEstRempli()){
        die('Certains champs du formulaire sont manquant');
    }

    // On récupère nos données nettoyées que l'on stock sous forme
    // de tableau
    $donneesFormulaire = [
        'name' => nettoyerLaVariable($_POST['name-input']),
        'price' => nettoyerLaVariable($_POST['price-input']),
    ];

    // Connexion à la bdd, que l'on vient stock pour pouvoir l'utiliser
    $connexionBDD = connexionBDD();
    // Insertion dans la bdd
    $messageErreur = insererUnProduit(
        $connexionBDD,
        $donneesFormulaire['name'],
        $donneesFormulaire['price']
    );

    // Crash de serveur volontaire en cas d'erreur lors de l'insertion
    if ($messageErreur !== null){
        die($messageErreur);
    }

    // Redirection à la page de formulaire
    header('Location: http://127.0.0.1:8080/13_BONUS/formulaire-edit-avec-info-prerempli/src');
    