<?php

/**
 * Gestion de la connexion à la base de données
 * Utilise PDO pour une meilleure sécurité
 */

// Variable globale pour stocker la connexion
$db_connection = null;

/**
 * Fonction pour se connecter à la base de données
 * Retourne la connexion PDO ou false en cas d'erreur
 */
function connectDB()
{
    global $db_connection;

    // Si déjà connecté, retourner la connexion existante
    if ($db_connection !== null) {
        return $db_connection;
    }

    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $db_connection = new PDO($dsn, DB_USER, DB_PASS);

        // Configuration PDO pour la sécurité
        $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $db_connection;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        return false;
    }
}

/**
 * Fonction pour tester la connexion à la base
 */
function testerConnexion()
{
    $db = connectDB();
    if ($db === false) {
        return false;
    }

    try {
        $result = $db->query("SELECT 1");
        return $result !== false;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Fonction pour créer la table contacts si elle n'existe pas
 */
function creerTableContacts()
{
    $db = connectDB();
    if ($db === false) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        telephone VARCHAR(20),
        date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    try {
        $db->exec($sql);
        return true;
    } catch (PDOException $e) {
        echo "Erreur création table : " . $e->getMessage();
        return false;
    }
}
