<?php

/**
 * Fonctions CRUD pour la gestion des contacts
 * CREATE, READ, UPDATE, DELETE
 */

require_once __DIR__ . '/db.php';
/**
 * Fonction pour valider un email
 */
function validerEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Fonction pour nettoyer les données d'entrée
 */
function nettoyerDonnees($donnee)
{
    return trim(strip_tags($donnee));
}

/**
 * CREATE - Ajouter un nouveau contact
 */
function ajouterContact($nom, $prenom, $email, $telephone = '')
{
    // Nettoyer les données
    $nom = nettoyerDonnees($nom);
    $prenom = nettoyerDonnees($prenom);
    $email = nettoyerDonnees($email);
    $telephone = nettoyerDonnees($telephone);

    // Validation des données
    if (empty($nom)) {
        return "Le nom est obligatoire";
    }
    if (empty($prenom)) {
        return "Le prénom est obligatoire";
    }
    if (empty($email)) {
        return "L'email est obligatoire";
    }
    if (!validerEmail($email)) {
        return "L'email n'est pas valide";
    }

    // Connexion à la base
    $db = connectDB();
    if ($db === false) {
        return "Erreur de connexion à la base de données";
    }

    try {
        $sql = "INSERT INTO contacts (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $resultat = $stmt->execute([$nom, $prenom, $email, $telephone]);

        if ($resultat) {
            return true; // Succès
        } else {
            return "Erreur lors de l'ajout du contact";
        }
    } catch (PDOException $e) {
        // Gestion de l'erreur d'email en double
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            return "Cet email existe déjà";
        }
        return "Erreur : " . $e->getMessage();
    }
}

/**
 * READ - Lire tous les contacts
 */
function lireTousLesContacts()
{
    $db = connectDB();
    if ($db === false) {
        return false;
    }

    try {
        $sql = "SELECT * FROM contacts ORDER BY nom ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Erreur lecture : " . $e->getMessage();
        return false;
    }
}

/**
 * READ - Lire un contact par son ID
 */
function lireContactParId($id)
{
    $db = connectDB();
    if ($db === false) {
        return false;
    }

    try {
        $sql = "SELECT * FROM contacts WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        echo "Erreur lecture : " . $e->getMessage();
        return false;
    }
}

/**
 * UPDATE - Modifier un contact
 */
function modifierContact($id, $nom, $prenom, $email, $telephone = '')
{
    // Nettoyer les données
    $nom = nettoyerDonnees($nom);
    $prenom = nettoyerDonnees($prenom);
    $email = nettoyerDonnees($email);
    $telephone = nettoyerDonnees($telephone);

    // Validation des données
    if (empty($nom)) {
        return "Le nom est obligatoire";
    }
    if (empty($prenom)) {
        return "Le prénom est obligatoire";
    }
    if (empty($email)) {
        return "L'email est obligatoire";
    }
    if (!validerEmail($email)) {
        return "L'email n'est pas valide";
    }

    // Connexion à la base
    $db = connectDB();
    if ($db === false) {
        return "Erreur de connexion à la base de données";
    }

    try {
        $sql = "UPDATE contacts SET nom = ?, prenom = ?, email = ?, telephone = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $resultat = $stmt->execute([$nom, $prenom, $email, $telephone, $id]);

        if ($resultat && $stmt->rowCount() > 0) {
            return true; // Succès
        } else {
            return "Aucune modification effectuée";
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            return "Cet email existe déjà";
        }
        return "Erreur : " . $e->getMessage();
    }
}

/**
 * DELETE - Supprimer un contact
 */
function supprimerContact($id)
{
    $db = connectDB();
    if ($db === false) {
        return "Erreur de connexion à la base de données";
    }

    try {
        $sql = "DELETE FROM contacts WHERE id = ?";
        $stmt = $db->prepare($sql);
        $resultat = $stmt->execute([$id]);

        if ($resultat && $stmt->rowCount() > 0) {
            return true; // Succès
        } else {
            return "Contact non trouvé";
        }
    } catch (PDOException $e) {
        return "Erreur : " . $e->getMessage();
    }
}

/**
 * Fonction pour rechercher des contacts
 */
function rechercherContacts($recherche)
{
    $db = connectDB();
    if ($db === false) {
        return false;
    }

    try {
        $terme = "%" . $recherche . "%";
        $sql = "SELECT * FROM contacts 
                WHERE nom LIKE ? OR prenom LIKE ? OR email LIKE ? 
                ORDER BY nom ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$terme, $terme, $terme]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Erreur recherche : " . $e->getMessage();
        return false;
    }
}

/**
 * Fonction pour compter le nombre total de contacts
 */
function compterContacts()
{
    $db = connectDB();
    if ($db === false) {
        return 0;
    }

    try {
        $stmt = $db->query("SELECT COUNT(*) as total FROM contacts");
        $resultat = $stmt->fetch();
        return $resultat['total'];
    } catch (PDOException $e) {
        return 0;
    }
}
