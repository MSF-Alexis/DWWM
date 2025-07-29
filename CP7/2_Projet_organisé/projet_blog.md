# 1 - Projet Web PHP Organisé : "Blog Personnel"

| **Élément** | **Détails** |
| :-- | :-- |
| **Titre** | Construire son premier projet web organisé : Blog Personnel |
| **Compétence RNCP** | BC02 – Développer des composants métier côté serveur |
| **Niveau** | **Débutant** |
| **Durée** | 4h guidées + 2h de finalisation personnelle |
| **Prérequis** | Contenu main_php.pdf validé (variables, fonctions, formulaires, PDO de base) |

## Objectif immédiat

À la fin de ce projet, vous aurez construit votre **premier site web dynamique organisé** avec une structure professionnelle claire. Vous maîtriserez la séparation des responsabilités et la manipulation sécurisée des données.

## 1. Comprendre l'organisation (Pourquoi séparer ?)

### Analogie simple

Imaginez votre chambre :

- **Armoire** → vêtements (comme `includes/` → fonctions)
- **Bureau** → travail (comme `public/` → interface utilisateur)
- **Tiroir secret** → documents privés (comme `config/` → configuration)

Un projet web organisé fonctionne pareil : chaque chose a sa place !

### Structure de notre projet

```
blog-personnel/
├── public/
│   └── index.php        # Interface visible par l'utilisateur
├── includes/
│   └── functions.php    # Fonctions réutilisables (CRUD)
├── config/
│   └── db.php          # Connexion base de données
├── data/
│   └── blog.sql        # Script de création des tables
└── README.md           # Documentation
```


## 2. Préparation de la base de données

### Script SQL à exécuter

Copiez-collez ce script dans phpMyAdmin ou votre outil MySQL :

```sql
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS blog_personnel;
USE blog_personnel;

-- Table des articles
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Données de test
INSERT INTO articles (titre, contenu) VALUES 
('Mon premier article', 'Bienvenue sur mon blog ! Ceci est mon premier article.'),
('Apprendre PHP', 'PHP est un langage formidable pour créer des sites web dynamiques.'),
('Organisation de projet', 'Il est crucial de bien organiser son code dès le début.');
```


## 3. Fichier de configuration (config/db.php)

Ce fichier centralise la connexion à votre base de données :

```php
<?php
function getDatabase() {
    static $pdo = null;
    
    if ($pdo === null) {
        $host = 'localhost';
        $dbname = 'blog_personnel';
        $username = 'root';
        $password = ''; // Ajustez selon votre configuration
        
        try {
            $pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $username,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
    
    return $pdo;
}
?>
```

**Pourquoi cette organisation ?**

- Une seule fonction pour toute l'application
- Facile à modifier si les paramètres changent
- Sécurisé car les identifiants sont séparés


## 4. Fonctions métier (includes/functions.php)

### Mission : Compléter les fonctions

Voici le squelette des fonctions. **Votre travail** : compléter les parties manquantes en utilisant vos connaissances PHP.

```php
<?php
require_once '../config/db.php';

/**
 * Récupère tous les articles du blog
 * VOTRE MISSION : Complétez la requête SQL et la récupération des données
 */
function getAllArticles() {
    $db = getDatabase();
    
    // TODO : Écrivez la requête SQL pour récupérer tous les articles
    // Indice : SELECT * FROM ... ORDER BY ...
    $sql = ""; // À compléter
    
    $stmt = $db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Ajoute un nouvel article
 * VOTRE MISSION : Écrivez la requête préparée d'insertion
 */
function addArticle($titre, $contenu) {
    $db = getDatabase();
    
    // TODO : Préparez et exécutez la requête d'insertion
    // Indice : INSERT INTO articles (titre, contenu) VALUES (?, ?)
    
    // Votre code ici...
    
    return true; // Retourner true si succès
}

/**
 * Supprime un article par son ID
 * VOTRE MISSION : Implémentez la suppression sécurisée
 */
function deleteArticle($id) {
    // TODO : Créez votre fonction de suppression
    // Pensez aux requêtes préparées !
}

/**
 * Fonction utilitaire : nettoie les données utilisateur
 * Cette fonction est donnée comme exemple de sécurité
 */
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
```

**Questions de réflexion pour vous guider :**

1. Quelle requête SQL utiliseriez-vous pour récupérer tous les articles ?
2. Comment sécuriser une insertion avec des paramètres ?
3. Pourquoi utilise-t-on `htmlspecialchars()` ?

## 5. Interface utilisateur (public/index.php)

### Structure générale donnée

```php
<?php
require_once '../includes/functions.php';

// Variables pour les messages
$message = '';
$error = '';

// Traitement du formulaire d'ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        // TODO : Récupérez et nettoyez les données du formulaire
        // TODO : Validez que les champs ne sont pas vides
        // TODO : Appelez la fonction addArticle()
        // TODO : Définissez un message de succès ou d'erreur
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // TODO : Récupérez l'ID à supprimer
        // TODO : Appelez la fonction deleteArticle()
    }
}

// Récupération des articles pour affichage
$articles = getAllArticles();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog Personnel</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .article { border: 1px solid #ddd; margin: 20px 0; padding: 15px; border-radius: 5px; }
        .form-group { margin: 10px 0; }
        input, textarea { width: 100%; padding: 8px; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 3px; }
        .message { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Mon Blog Personnel</h1>
    
    <?php if ($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <!-- Formulaire d'ajout d'article -->
    <h2>Ajouter un article</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        
        <div class="form-group">
            <label>Titre :</label>
            <input type="text" name="titre" required>
        </div>
        
        <div class="form-group">
            <label>Contenu :</label>
            <textarea name="contenu" rows="6" required></textarea>
        </div>
        
        <button type="submit">Publier l'article</button>
    </form>

    <!-- Affichage des articles -->
    <h2>Mes articles</h2>
    <?php if (empty($articles)): ?>
        <p>Aucun article pour le moment.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <h3><?= htmlspecialchars($article['titre']) ?></h3>
                <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
                <p><small>Publié le : <?= date('d/m/Y H:i', strtotime($article['date_creation'])) ?></small></p>
                
                <!-- TODO : Ajoutez un formulaire de suppression -->
                <!-- Indice : formulaire avec method="POST", input hidden pour l'action et l'ID -->
                
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
```


### Vos missions dans index.php

1. **Traitement du formulaire d'ajout** : Récupérez les données, validez-les, appelez `addArticle()`
2. **Traitement de suppression** : Créez le formulaire et le traitement pour supprimer un article
3. **Gestion des messages** : Affichez des feedbacks appropriés à l'utilisateur

## 6. Finalisation et test

### Checklist de validation

- [ ] La base de données est créée avec les données de test
- [ ] Les 3 fichiers sont dans la bonne structure de dossiers
- [ ] La connexion à la base fonctionne (pas d'erreur de connexion)
- [ ] L'affichage des articles existants fonctionne
- [ ] L'ajout d'un nouvel article fonctionne
- [ ] La suppression d'un article fonctionne
- [ ] Les données sont sécurisées (utilisation de htmlspecialchars)


### Questions d'auto-évaluation

1. Pourquoi sépare-t-on `db.php`, `functions.php` et `index.php` ?
2. Quelle est la différence entre `$_POST['titre']` et `htmlspecialchars($_POST['titre'])` ?
3. Pourquoi utilise-t-on des requêtes préparées ?

## 7. Améliorations possibles (optionnelles)

Une fois le projet de base terminé, vous pouvez ajouter :

- **Pagination** : afficher seulement 5 articles par page
- **Recherche** : chercher dans les titres d'articles
- **Validation avancée** : vérifier la longueur des textes
- **Design amélioré** : CSS plus avancé ou framework comme Bootstrap


## 8. Documentation README.md

Créez un fichier README.md à la racine :

```markdown
# Blog Personnel - Mon Premier Projet Web Organisé

## Description
Blog simple permettant d'ajouter, afficher et supprimer des articles.

## Installation
1. Créer la base de données avec le script `data/blog.sql`
2. Configurer les paramètres de connexion dans `config/db.php`
3. Lancer un serveur local : `php -S localhost:8000 -t public/`

## Structure
- `public/` : Interface utilisateur
- `includes/` : Fonctions métier
- `config/` : Configuration base de données
- `data/` : Scripts SQL

## Technologies utilisées
- PHP procédural
- MySQL/MariaDB
- HTML/CSS
```

**Félicitations !** Vous venez de créer votre premier projet web organisé selon les standards professionnels.
