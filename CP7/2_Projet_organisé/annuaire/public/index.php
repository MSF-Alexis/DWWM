<?php

/**
 * Point d'entrée principal de l'application
 * Gère toutes les actions : affichage, ajout, modification, suppression, import, export
 */

// Inclure tous les fichiers nécessaires
require_once '../config/config.php';
require_once '../includes/db.php';
require_once '../includes/crud.php';
require_once '../includes/import.php';
require_once '../includes/export.php';

// Initialiser la base de données
creerTableContacts();

// Récupérer l'action demandée
$action = isset($_GET['action']) ? $_GET['action'] : 'liste';

// Traitement des actions
switch ($action) {

    case 'ajouter':
        // Afficher le formulaire d'ajout ou traiter l'ajout
        if ($_POST) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];

            $resultat = ajouterContact($nom, $prenom, $email, $telephone);
            if ($resultat === true) {
                $_SESSION['message_succes'] = "Contact ajouté avec succès";
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['message_erreur'] = $resultat;
            }
        }
        break;

    case 'modifier':
        // Afficher le formulaire de modification ou traiter la modification
        $id = isset($_GET['id']) ? $_GET['id'] : 0;

        if ($_POST) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];

            $resultat = modifierContact($id, $nom, $prenom, $email, $telephone);
            if ($resultat === true) {
                $_SESSION['message_succes'] = "Contact modifié avec succès";
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['message_erreur'] = $resultat;
            }
        }
        break;

    case 'supprimer':
        // Supprimer un contact
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $resultat = supprimerContact($id);

        if ($resultat === true) {
            $_SESSION['message_succes'] = "Contact supprimé avec succès";
        } else {
            $_SESSION['message_erreur'] = $resultat;
        }
        header('Location: index.php');
        exit();
        break;

    case 'importer':
        // Traiter l'import CSV
        if (isset($_FILES['fichier_csv'])) {
            $resultat = traiterFichierUploade($_FILES['fichier_csv']);
            $_SESSION['message_succes'] = $resultat;
            header('Location: index.php');
            exit();
        }
        break;

    case 'exporter':
        // Exporter vers CSV
        telechargerCSV();
        break;

    case 'creer_exemple':
        // Créer un fichier d'exemple
        $resultat = creerFichierExemple();
        $_SESSION['message_succes'] = $resultat;
        header('Location: index.php');
        exit();
        break;
}

// Récupérer les données pour l'affichage
$contacts = lireTousLesContacts();
$nombre_contacts = compterContacts();

// Si on est en mode modification, récupérer le contact
$contact_a_modifier = null;
if ($action === 'modifier' && isset($_GET['id'])) {
    $contact_a_modifier = lireContactParId($_GET['id']);
}

// Définir le titre de la page
$titre_page = APP_NAME;

// Inclure l'en-tête
include '../templates/header.php';
?>

<!-- Contenu principal -->
<div class="row">
    <div class="col-md-4">
        <!-- Formulaire d'ajout/modification -->
        <div class="card">
            <div class="card-header">
                <h5><?php echo $action === 'modifier' ? 'Modifier le contact' : 'Ajouter un contact'; ?></h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?action=<?php echo $action === 'modifier' ? 'modifier&id=' . $_GET['id'] : 'ajouter'; ?>">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" class="form-control" id="nom" name="nom"
                            value="<?php echo $contact_a_modifier ? htmlspecialchars($contact_a_modifier['nom']) : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom *</label>
                        <input type="text" class="form-control" id="prenom" name="prenom"
                            value="<?php echo $contact_a_modifier ? htmlspecialchars($contact_a_modifier['prenom']) : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo $contact_a_modifier ? htmlspecialchars($contact_a_modifier['email']) : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone"
                            value="<?php echo $contact_a_modifier ? htmlspecialchars($contact_a_modifier['telephone']) : ''; ?>">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $action === 'modifier' ? '✏️ Modifier' : '➕ Ajouter'; ?>
                        </button>
                        <?php if ($action === 'modifier'): ?>
                            <a href="index.php" class="btn btn-secondary">Annuler</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Outils Import/Export -->
        <div class="card">
            <div class="card-header">
                <h5>📂 Import/Export</h5>
            </div>
            <div class="card-body">
                <!-- Import CSV -->
                <form method="POST" action="index.php?action=importer" enctype="multipart/form-data" class="mb-3">
                    <div class="mb-2">
                        <label for="fichier_csv" class="form-label">Importer un CSV</label>
                        <input type="file" class="form-control" id="fichier_csv" name="fichier_csv" accept=".csv" required>
                        <small class="text-muted">Format attendu : nom, prenom, email, telephone</small>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">📥 Importer</button>
                </form>

                <!-- Export CSV -->
                <div class="d-grid gap-2">
                    <a href="index.php?action=exporter" class="btn btn-info btn-sm">📤 Exporter CSV</a>
                    <a href="index.php?action=creer_exemple" class="btn btn-warning btn-sm">📋 Créer fichier exemple</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Liste des contacts -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>📋 Liste des contacts (<?php echo $nombre_contacts; ?>)</h5>
            </div>
            <div class="card-body">
                <?php if ($contacts && count($contacts) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Date création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($contact['nom']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['prenom']); ?></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>">
                                                <?php echo htmlspecialchars($contact['email']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($contact['telephone']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($contact['date_creation'])); ?></td>
                                        <td>
                                            <a href="index.php?action=modifier&id=<?php echo $contact['id']; ?>"
                                                class="btn btn-sm btn-outline-primary" title="Modifier">
                                                ✏️
                                            </a>
                                            <a href="index.php?action=supprimer&id=<?php echo $contact['id']; ?>"
                                                class="btn btn-sm btn-outline-danger" title="Supprimer"
                                                onclick="return confirmerSuppression('<?php echo htmlspecialchars($contact['nom']); ?>', '<?php echo htmlspecialchars($contact['prenom']); ?>')">
                                                🗑️
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted">Aucun contact trouvé</p>
                        <p>Commencez par ajouter un contact ou importer un fichier CSV</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Inclure le pied de page
include '../templates/footer.php';
?>