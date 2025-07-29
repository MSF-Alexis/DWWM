<?php

/**
 * Fonctions d'import CSV vers la base de données
 */

require_once __DIR__ . '/crud.php';

/**
 * Fonction pour importer un fichier CSV
 */
function importerCSV($cheminFichier)
{
    // Vérifier que le fichier existe
    if (!file_exists($cheminFichier)) {
        return "Le fichier n'existe pas";
    }

    // Ouvrir le fichier CSV
    $fichier = fopen($cheminFichier, 'r');
    if (!$fichier) {
        return "Impossible d'ouvrir le fichier";
    }

    // Variables pour les statistiques
    $nombreImportes = 0;
    $nombreErreurs = 0;
    $numeroLigne = 0;
    $messagesErreurs = array();

    // Lire la première ligne (en-têtes) et l'ignorer
    $premiereeLigne = fgetcsv($fichier, separator: ";");
    $numeroLigne++;

    // Lire chaque ligne du fichier
    while (($donnees = fgetcsv($fichier, separator: ";")) !== false) {
        $numeroLigne++;
        // Vérifier qu'on a au moins 3 colonnes
        if (count($donnees) < 3) {
            $nombreErreurs++;
            $messagesErreurs[] = "Ligne $numeroLigne : Données insuffisantes";
            continue;
        }

        // Récupérer les données
        $nom = trim($donnees[0]);
        $prenom = trim($donnees[1]);
        $email = trim($donnees[2]);
        $telephone = isset($donnees[3]) ? trim($donnees[3]) : '';

        // Ignorer les lignes vides
        if (empty($nom) && empty($prenom) && empty($email)) {
            continue;
        }

        // Essayer d'ajouter le contact
        $resultat = ajouterContact($nom, $prenom, $email, $telephone);

        if ($resultat === true) {
            $nombreImportes++;
        } else {
            $nombreErreurs++;
            $messagesErreurs[] = "Ligne $numeroLigne : $resultat";
        }
    }

    // Fermer le fichier
    fclose($fichier);

    // Préparer le message de résultat
    $message = "Import terminé :\n";
    $message .= "- $nombreImportes contacts importés\n";
    $message .= "- $nombreErreurs erreurs\n";

    if (!empty($messagesErreurs)) {
        $message .= "\nDétail des erreurs :\n" . implode("\n", $messagesErreurs);
    }

    return $message;
}

/**
 * Fonction pour traiter un fichier uploadé
 */
function traiterFichierUploade($fichierUploade)
{
    // Vérifier qu'il n'y a pas d'erreur d'upload
    if ($fichierUploade['error'] !== UPLOAD_ERR_OK) {
        return "Erreur lors de l'upload du fichier";
    }

    // Vérifier l'extension du fichier
    $nomFichier = $fichierUploade['name'];
    $extension = pathinfo($nomFichier, PATHINFO_EXTENSION);

    if (strtolower($extension) !== 'csv') {
        return "Seuls les fichiers CSV sont acceptés";
    }

    // Vérifier la taille du fichier (max 2MB)
    if ($fichierUploade['size'] > 2 * 1024 * 1024) {
        return "Le fichier est trop volumineux (maximum 2MB)";
    }

    // Importer le fichier temporaire
    return importerCSV($fichierUploade['tmp_name']);
}

/**
 * Fonction pour créer un fichier CSV d'exemple
 */
function creerFichierExemple($cheminFichier = null)
{
    if ($cheminFichier === null) {
        $cheminFichier = DATA_PATH . '/exemples.csv';
    }

    // Créer le dossier data s'il n'existe pas
    $dossier = dirname($cheminFichier);
    if (!is_dir($dossier)) {
        mkdir($dossier, 0755, true);
    }

    // Ouvrir le fichier en écriture
    $fichier = fopen($cheminFichier, 'w');
    if (!$fichier) {
        return "Impossible de créer le fichier d'exemple";
    }

    // Écrire les en-têtes
    fputcsv($fichier, array('nom', 'prenom', 'email', 'telephone'));

    // Écrire quelques exemples
    $exemples = array(
        array('Dupont', 'Jean', 'jean.dupont@email.com', '0123456789'),
        array('Martin', 'Marie', 'marie.martin@email.com', '0987654321'),
        array('Durand', 'Pierre', 'pierre.durand@email.com', '0147258369'),
        array('Bernard', 'Sophie', 'sophie.bernard@email.com', '0963852741'),
        array('Petit', 'Luc', 'luc.petit@email.com', '')
    );

    foreach ($exemples as $exemple) {
        fputcsv($fichier, $exemple);
    }

    // Fermer le fichier
    fclose($fichier);

    return "Fichier d'exemple créé : " . basename($cheminFichier);
}
