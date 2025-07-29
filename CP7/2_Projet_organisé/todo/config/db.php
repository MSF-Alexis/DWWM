<?php
/**
 * getDatabase() : retourne (toujours) une connexion PDO prête à l’emploi.
 * Aucune modification requise sauf vos identifiants.
 */
function getDatabase(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $host     = 'localhost';
        $dbname   = 'todolist';
        $user     = 'root';
        $password = '';       // ← adaptez ici

        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $user,
            $password,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    return $pdo;
}
