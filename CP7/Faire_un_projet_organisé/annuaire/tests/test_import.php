<?php

/**
 * Script de test pour valider les fonctions d'import/export
 */

// Inclure les fichiers nécessaires
require_once '../config/config.php';
require_once '../includes/db.php';
require_once '../includes/crud.php';
require_once '../includes/import.php';
require_once '../includes/export.php';

echo "<h1>🧪 Tests des fonctions Import/Export</h1>\n";

// Test 1 : Connexion à la base
echo "<h2>Test 1 : Connexion à la base de données</h2>\n";
$connexion_ok = testerConnexion();
if ($connexion_ok) {
    echo "✅ Connexion réussie<br>\n";
} else {
    echo "❌ Erreur de connexion<br>\n";
    exit();
}

// Test 2 : Création de la table
echo "<h2>Test 2 : Création de la table contacts</h2>\n";
$table_ok = creerTableContacts();
if ($table_ok) {
    echo "✅ Table créée ou existe déjà<br>\n";
} else {
    echo "❌ Erreur lors de la création de la table<br>\n";
}

// Test 3 : Ajout d'un contact de test
echo "<h2>Test 3 : Ajout d'un contact de test</h2>\n";
$resultat_ajout = ajouterContact('Test', 'Utilisateur', 'test@exemple.com', '0123456789');
if ($resultat_ajout === true) {
    echo "✅ Contact de test ajouté<br>\n";
} else {
    echo "ℹ️ $resultat_ajout<br>\n";
}

// Test 4 : Lecture des contacts
echo "<h2>Test 4 : Lecture des contacts</h2>\n";
$contacts = lireTousLesContacts();
if ($contacts !== false) {
    $nombre = count($contacts);
    echo "✅ $nombre contacts trouvés<br>\n";
    if ($nombre > 0) {
        echo "Premier contact : " . $contacts[0]['nom'] . " " . $contacts[0]['prenom'] . "<br>\n";
    }
} else {
    echo "❌ Erreur lors de la lecture<br>\n";
}

// Test 5 : Création du fichier d'exemple
echo "<h2>Test 5 : Création du fichier d'exemple</h2>\n";
$resultat_exemple = creerFichierExemple();
echo "ℹ️ $resultat_exemple<br>\n";

// Test 6 : Import du fichier d'exemple
echo "<h2>Test 6 : Import du fichier d'exemple</h2>\n";
$chemin_exemple = DATA_PATH . '/exemples.csv';
if (file_exists($chemin_exemple)) {
    $resultat_import = importerCSV($chemin_exemple);
    echo "<pre>$resultat_import</pre>\n";
} else {
    echo "❌ Fichier d'exemple non trouvé<br>\n";
}

// Test 7 : Export vers CSV
echo "<h2>Test 7 : Export vers CSV</h2>\n";
$resultat_export = exporterVersCSV();
echo "ℹ️ $resultat_export<br>\n";

// Test 8 : Statistiques finales
echo "<h2>Test 8 : Statistiques finales</h2>\n";
$nombre_final = compterContacts();
echo "📊 Nombre total de contacts : $nombre_final<br>\n";

echo "<hr>\n";
echo "<p>✅ Tests terminés ! Vérifiez les résultats ci-dessus.</p>\n";
