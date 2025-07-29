<?php
require_once __DIR__ . '/../includes/todo_functions.php';

$messages = [];
$errors   = [];

/* ---------- Traitement des formulaires ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    /* Ajout */
    if ($action === 'add') {
        // TODO : récupérer $_POST['title'], appeler addTask(), renseigner $messages ou $errors
    }

    /* Terminer */
    if ($action === 'complete') {
        // TODO : récupérer l’id, appeler completeTask()
    }

    /* Suppression */
    if ($action === 'delete') {
        // TODO : récupérer l’id, appeler deleteTask()
    }
}

/* ---------- Récupération des tâches ---------- */
$tasks = getTasks();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma To-Do List</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; }
        .done { text-decoration: line-through; color: #888; }
        .msg { color: green; }
        .err { color: red; }
    </style>
</head>
<body>
    <h1>Ma To-Do List</h1>

    <!-- Feedback utilisateur -->
    <?php foreach ($messages as $m): ?><p class="msg"><?= $m ?></p><?php endforeach; ?>
    <?php foreach ($errors   as $e): ?><p class="err"><?= $e ?></p><?php endforeach; ?>

    <!-- Formulaire d’ajout -->
    <form method="post">
        <input type="hidden" name="action" value="add">
        <input type="text"   name="title"  placeholder="Nouvelle tâche" required>
        <button>Ajouter</button>
    </form>

    <!-- Liste des tâches -->
    <ul>
        <?php foreach ($tasks as $t): ?>
            <li class="<?= $t['completed'] ? 'done' : '' ?>">
                <?= htmlspecialchars($t['title']) ?>

                <!-- Bouton Terminer -->
                <?php if (!$t['completed']): ?>
                    <form method="post" style="display:inline">
                        <input type="hidden" name="action" value="complete">
                        <input type="hidden" name="id" value="<?= $t['id'] ?>">
                        <button>✓</button>
                    </form>
                <?php endif; ?>

                <!-- Bouton Supprimer -->
                <form method="post" style="display:inline">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $t['id'] ?>">
                    <button>🗑</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
