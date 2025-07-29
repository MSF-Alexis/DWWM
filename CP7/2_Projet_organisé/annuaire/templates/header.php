<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titre_page) ? $titre_page : APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .btn {
            margin: 2px;
        }

        .table th {
            background-color: #e9ecef;
        }

        .footer {
            margin-top: 50px;
            padding: 20px 0;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                📋 <?php echo APP_NAME; ?>
            </a>
            <span class="navbar-text text-light">
                Version <?php echo APP_VERSION; ?>
            </span>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-4">
        <?php
        // Affichage des messages de succès
        if (isset($_SESSION['message_succes'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo '✅ ' . $_SESSION['message_succes'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            echo '</div>';
            unset($_SESSION['message_succes']);
        }

        // Affichage des messages d'erreur
        if (isset($_SESSION['message_erreur'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '❌ ' . $_SESSION['message_erreur'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            echo '</div>';
            unset($_SESSION['message_erreur']);
        }
        ?>