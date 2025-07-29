<?php

/**
 * Fonctions d'export de la base de données vers CSV
 */

require_once __DIR__ . '/crud.php';

/**
 * Fonction pour exporter tous les contacts vers un fichier CSV
 */
function exporterVersCSV($cheminFichier = null)
{
    // Si aucun chemin spécifié, créer un nom de fichier
    if ($cheminFichier === null) {
        $cheminFichier = DATA_PATH . '/export_contacts_' . date('Y-m-d_H-i-s') . '.csv';
    }

    // Récupérer tous les contacts
    $contacts = lireTousLesContacts();
    if ($contacts === false) {
        return "Erreur lors de la lecture des contacts";
    }

    // Créer le dossier s'il n'existe pas
    $dossier = dirname($cheminFichier);
    if (!is_dir($dossier)) {
        mkdir($dossier, 0755, true);
    }

    // Ouvrir le fichier en écriture
    $fichier = fopen($cheminFichier, 'w');
    if (!$fichier) {
        return "Impossible de créer le fichier d'export";
    }

    // Écrire les en-têtes
    fputcsv($fichier, array('nom', 'prenom', 'email', 'telephone', 'date_creation'));

    // Écrire les données
    $nombreExportes = 0;
    foreach ($contacts as $contact) {
        $ligne = array(
            $contact['nom'],
            $contact['prenom'],
            $contact['email'],
            $contact['telephone'],
            $contact['date_creation']
        );

        if (fputcsv($fichier, $ligne)) {
            $nombreExportes++;
        }
    }

    // Fermer le fichier
    fclose($fichier);

    return "Export réussi : $nombreExportes contacts exportés vers " . basename($cheminFichier);
}

/**
 * Fonction pour télécharger directement un CSV
 */
function telechargerCSV($nomFichier = null)
{
    if ($nomFichier === null) {
        $nomFichier = 'contacts_export_' . date('Y-m-d_H-i-s') . '.csv';
    }

    // Récupérer tous les contacts
    $contacts = lireTousLesContacts();
    if ($contacts === false) {
        echo "Erreur lors de la lecture des contacts";
        return;
    }

    // En-têtes pour le téléchargement
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $nomFichier . '"');
    header('Cache-Control: no-cache');

    // Ouvrir la sortie
    $sortie = fopen('php://output', 'w');

    // Ajouter le BOM UTF-8 pour Excel
    fprintf($sortie, chr(0xEF) . chr(0xBB) . chr(0xBF));

    // Écrire les en-têtes
    fputcsv($sortie, array('Nom', 'Prénom', 'Email', 'Téléphone', 'Date de création'), ';');

    // Écrire les données
    foreach ($contacts as $contact) {
        $ligne = array(
            $contact['nom'],
            $contact['prenom'],
            $contact['email'],
            $contact['telephone'],
            date('d/m/Y H:i', strtotime($contact['date_creation']))
        );
        fputcsv($sortie, $ligne, ';');
    }

    // Fermer la sortie
    fclose($sortie);

    // Arrêter l'exécution du script
    exit();
}
