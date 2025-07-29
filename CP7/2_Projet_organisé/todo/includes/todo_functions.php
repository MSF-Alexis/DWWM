<?php
require_once __DIR__ . '/../config/db.php';

/**
 * Retourne toutes les tâches (ordre anté-chronologique).
 */
function getTasks(): array
{
    $db   = getDatabase();
    $sql  = "SELECT * FROM tasks ORDER BY created_at DESC";
    $stmt = $db->query($sql);

    return $stmt->fetchAll(); // tableau associatif
}

/**
 * Ajoute une tâche. Retourne true en cas de succès.
 * À COMPLÉTER : funnel Récupération → Sanitizing → Validation → DB
 */
function addTask(string $title): bool
{
    // TODO 1 : sanitizing (trim, strip_tags, htmlspecialchars)
    // TODO 2 : validation (non vide, longueur max 100)
    // TODO 3 : requête préparée INSERT
    // TODO 4 : retourner true/false selon le résultat
}

/**
 * Marque une tâche comme terminée.
 */
function completeTask(int $id): bool
{
    // TODO : requête préparée UPDATE completed = 1 WHERE id = ?
}

/**
 * Supprime une tâche.
 */
function deleteTask(int $id): bool
{
    // TODO : requête préparée DELETE WHERE id = ?
}
