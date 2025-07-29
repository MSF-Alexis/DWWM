<?php
/**
 * Configuration globale de l'application
 * Contient les paramètres de base de données et les constantes
 */

// Paramètres de la base de données
define('DB_HOST', 'annuaire-mariadb-dev-1');
define('DB_NAME', 'main-database');
define('DB_USER', 'contacts_user');
define('DB_PASS', 'SecurePass2024!');
define('DB_CHARSET', 'utf8mb4');

// Constantes de l'application
define('APP_NAME', 'Gestionnaire de Contacts');
define('APP_VERSION', '1.0.0');

// Chemins
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes/');
define('TEMPLATES_PATH', ROOT_PATH . '/templates/');
define('DATA_PATH', ROOT_PATH . '/data/');

// Configuration des erreurs (en développement)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
