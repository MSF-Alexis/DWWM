# La contrainte CASCADE en SQL

<a id="sommaire"></a>

## Sommaire interactif
- [Introduction](#introduction)
- [Qu'est-ce que la contrainte CASCADE ?](what-is-cascade)
    - [Définition](#cascade-definition)
    - [Types d'actions CASCADE](#cascade-action-type)
- [Autres actions possibles sur les clés étrangères](#cascade-other-actions)
    - [Actions alternatives à CASCADE](#alternative-cascade-action-type)
- [Comment ajouter une contrainte cascade ?](#how-add-cascade)
    - [Lors de la création de la table](#add-cascade-on-creation)
    - [Sur une table existante](#add-cascade-on-edit)
- [Comment modifier une contrainte cascade ?](#how-edit-cascade)
    - [Étapes pour modifier une contrainte existante](#step-edit-existing-cascade)
    - [Exemple complet de modification](#edit-existing-cascade-example)
- [Comment supprimer une contrainte cascade ?](#how-delete-cascade)
    - [Suppression simple](#simple-cascade-delete)
    - [Vérifier le nom de la contrainte](#check-constraint-name)
- [Cas pratiques](#practical-cases)
    - [Cas 1](#case-1)
    - [Cas 2](#case-2)
    - [Cas 3](#case-3)
- [Avantages et inconvénients](#pros-and-cons)
    - [Avantages de CASCADE](#pros)
    - [Inconvénients et précautions](#cons)
- [Bonne pratiques](#good-practices)
    - [Planification et conception](#plan-and-design)
    - [Sécurité et maintenance](#security-and-maintenance)
    - [Exemples de bonne pratiques](#good-practices-example)
- [Points clés à retenir](#key-points)

<a href="" id="introduction"></a>

## Introduction
[Retour au sommaire](#sommaire)
La contrainte CASCADE est un mécanisme fondamental des bases de données relationnelles qui permet de maintenir automatiquement la cohérence des données lors des opérations de modification ou de suppression. Elle agit sur les relations entre tables définies par les clés étrangères.

---
<a href="" id="what-is-cascade"></a>

## Qu'est-ce que la contrainte CASCADE ?
[Retour au sommaire](#sommaire)

<a href="" id="cascade-definition"></a>

### Définition

La contrainte CASCADE définit le comportement automatique à adopter lorsqu'un enregistrement parent (table référencée) est modifié ou supprimé, alors qu'il existe des enregistrements enfants (table avec clé étrangère) qui le référencent.
<a href="" id="cascade-action-type"></a>

### Types d'actions CASCADE

Il existe deux types principaux d'actions CASCADE :

- **ON DELETE CASCADE** : Supprime automatiquement les enregistrements enfants quand l'enregistrement parent est supprimé
- **ON UPDATE CASCADE** : Met à jour automatiquement la clé étrangère des enregistrements enfants quand la clé primaire de l'enregistrement parent est modifiée

---
<a href="" id="cascade-other-actions"></a>

## Autres actions possibles sur les clés étrangères
[Retour au sommaire](#sommaire)
<a href="" id="alternative-cascade-action-type"></a>

### Actions alternatives à CASCADE

| Action | Description | Comportement |
|--------|-------------|--------------|
| **RESTRICT** | Empêche l'opération | Bloque la suppression/modification si des enregistrements enfants existent |
| **SET NULL** | Définit la valeur à NULL | Met la clé étrangère à NULL dans les enregistrements enfants |
| **SET DEFAULT** | Définit la valeur par défaut | Met la clé étrangère à sa valeur par défaut dans les enregistrements enfants |
| **NO ACTION** | Aucune action (par défaut) | Comportement similaire à RESTRICT selon le SGBD |

---
<a href="" id="how-add-cascade"></a>

## Comment ajouter une contrainte CASCADE
[Retour au sommaire](#sommaire)
<a href="" id="add-cascade-on-creation"></a>

### Lors de la création de table

```sql
CREATE TABLE categories (
    id INT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE produits (
    id INT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    categorie_id INT,
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
```
<a href="" id="add-cascade-on-edit"></a>

### Sur une table existante

```sql
-- Ajouter une contrainte CASCADE à une table existante
ALTER TABLE produits 
ADD CONSTRAINT fk_produit_categorie 
FOREIGN KEY (categorie_id) REFERENCES categories(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
```

---
<a href="" id="how-edit-cascade"></a>

## Comment modifier une contrainte CASCADE
[Retour au sommaire](#sommaire)
<a href="" id="step-edit-existing-cascade"></a>

### Étapes pour modifier une contrainte existante

1. **Supprimer l'ancienne contrainte**
```sql
ALTER TABLE produits DROP FOREIGN KEY fk_produit_categorie;
```

2. **Ajouter la nouvelle contrainte avec les options souhaitées**
```sql
ALTER TABLE produits 
ADD CONSTRAINT fk_produit_categorie 
FOREIGN KEY (categorie_id) REFERENCES categories(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE;
```
<a href="" id="edit-existing-cascade-example"></a>

### Exemple complet de modification

```sql
-- Situation initiale : contrainte RESTRICT
ALTER TABLE commandes DROP FOREIGN KEY fk_commande_client;

-- Nouvelle contrainte : CASCADE
ALTER TABLE commandes 
ADD CONSTRAINT fk_commande_client 
FOREIGN KEY (client_id) REFERENCES clients(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
```

---
<a href="" id="how-delete-cascade"></a>

## Comment supprimer une contrainte CASCADE
[Retour au sommaire](#sommaire)
<a href="" id="simple-cascade-delete"></a>

### Suppression simple

```sql
ALTER TABLE produits DROP FOREIGN KEY fk_produit_categorie;
```
<a href="" id="check-constraint-name"></a>

### Vérifier le nom de la contrainte

Si vous ne connaissez pas le nom exact :

```sql
-- MySQL
SHOW CREATE TABLE produits;

-- PostgreSQL
SELECT constraint_name 
FROM information_schema.table_constraints 
WHERE table_name = 'produits' AND constraint_type = 'FOREIGN KEY';
```

---
<a href="" id="practical-cases"></a>

## Cas d'utilisation pratiques
[Retour au sommaire](#sommaire)
<a href="" id="case-1"></a>

### Cas 1 : Système de blog

**Contexte** : Un blog avec des auteurs et des articles. Quand un auteur est supprimé, tous ses articles doivent être supprimés.

```sql
-- Création des tables
CREATE TABLE auteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(200) NOT NULL,
    contenu TEXT,
    auteur_id INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (auteur_id) REFERENCES auteurs(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
```

**Insertion de données de test :**

```sql
-- Ajout d'auteurs
INSERT INTO auteurs (nom, email) VALUES 
('Jean Dupont', 'jean.dupont@email.com'),
('Marie Martin', 'marie.martin@email.com');

-- Ajout d'articles
INSERT INTO articles (titre, contenu, auteur_id) VALUES 
('Introduction à SQL', 'Contenu de l\'article...', 1),
('Les bases de données', 'Contenu de l\'article...', 1),
('Optimisation des requêtes', 'Contenu de l\'article...', 2);
```

**Test de la contrainte CASCADE :**

```sql
-- Vérification avant suppression
SELECT a.nom, COUNT(ar.id) as nb_articles
FROM auteurs a
LEFT JOIN articles ar ON a.id = ar.auteur_id
GROUP BY a.id, a.nom;

-- Résultat :
-- Jean Dupont    | 2
-- Marie Martin   | 1

-- Suppression de l'auteur Jean Dupont
DELETE FROM auteurs WHERE id = 1;

-- Vérification après suppression
SELECT * FROM articles;
-- Seul l'article de Marie Martin reste (id 3)
```
<a href="" id="case-2"></a>

### Cas 2 : Système de commandes e-commerce

**Contexte** : Un système où la suppression d'un client supprime toutes ses commandes, mais la suppression d'un produit met à NULL la référence dans les lignes de commande.

```sql
-- Création des tables
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL
);

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    FOREIGN KEY (client_id) REFERENCES clients(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE lignes_commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
```

**Insertion de données de test :**

```sql
-- Clients
INSERT INTO clients (nom, email) VALUES 
('Pierre Durand', 'pierre.durand@email.com'),
('Sophie Lemoine', 'sophie.lemoine@email.com');

-- Produits
INSERT INTO produits (nom, prix) VALUES 
('Ordinateur portable', 899.99),
('Souris sans fil', 29.99),
('Clavier mécanique', 149.99);

-- Commandes
INSERT INTO commandes (client_id, total) VALUES 
(1, 929.98),  -- Pierre : ordinateur + souris
(2, 149.99);  -- Sophie : clavier

-- Lignes de commande
INSERT INTO lignes_commande (commande_id, produit_id, quantite, prix_unitaire) VALUES 
(1, 1, 1, 899.99),  -- Commande 1 : ordinateur
(1, 2, 1, 29.99),   -- Commande 1 : souris
(2, 3, 1, 149.99);  -- Commande 2 : clavier
```

**Test des contraintes :**

```sql
-- Test 1 : Suppression d'un produit (SET NULL)
DELETE FROM produits WHERE id = 2;  -- Suppression de la souris

SELECT lc.*, p.nom as nom_produit 
FROM lignes_commande lc 
LEFT JOIN produits p ON lc.produit_id = p.id;

-- Résultat : la ligne avec la souris a produit_id = NULL

-- Test 2 : Suppression d'un client (CASCADE)
DELETE FROM clients WHERE id = 1;   -- Suppression de Pierre

SELECT * FROM commandes;
-- Résultat : seule la commande de Sophie reste

SELECT * FROM lignes_commande;
-- Résultat : seule la ligne de commande de Sophie reste
```
<a href="" id="case-3"></a>

### Cas 3 : Système hiérarchique (employés/managers)

**Contexte** : Table d'employés avec une référence hiérarchique. Quand un manager quitte l'entreprise, ses employés perdent leur référence manager.

```sql
CREATE TABLE employes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    poste VARCHAR(100) NOT NULL,
    manager_id INT,
    salaire DECIMAL(10,2),
    FOREIGN KEY (manager_id) REFERENCES employes(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
```

**Insertion de données de test :**

```sql
-- Insertion des managers d'abord
INSERT INTO employes (nom, poste, manager_id, salaire) VALUES 
('Alice Bernard', 'Directrice', NULL, 8000.00),
('Bob Charol', 'Chef d\'équipe', 1, 5000.00),
('Claire Dubois', 'Chef d\'équipe', 1, 5200.00);

-- Insertion des employés
INSERT INTO employes (nom, poste, manager_id, salaire) VALUES 
('David Martin', 'Développeur', 2, 3500.00),
('Eve Moreau', 'Développeur', 2, 3600.00),
('Frank Petit', 'Designer', 3, 3400.00);
```

**Test de la contrainte :**

```sql
-- Vérification de la hiérarchie
SELECT e.nom, e.poste, m.nom as manager_nom
FROM employes e
LEFT JOIN employes m ON e.manager_id = m.id
ORDER BY e.id;

-- Suppression d'un chef d'équipe
DELETE FROM employes WHERE id = 2;  -- Bob Charol

-- Vérification après suppression
SELECT e.nom, e.poste, m.nom as manager_nom
FROM employes e
LEFT JOIN employes m ON e.manager_id = m.id
ORDER BY e.id;

-- David et Eve n'ont plus de manager (manager_id = NULL)
```

---
<a href="" id="pros-and-cons"></a>

## Avantages et inconvénients
[Retour au sommaire](#sommaire)
<a href="" id="pros"></a>

### Avantages de CASCADE

- **Cohérence automatique** : Maintient l'intégrité référentielle sans intervention manuelle
- **Simplification du code** : Évite d'écrire des scripts de nettoyage complexes
- **Performance** : Les opérations en cascade sont optimisées par le SGBD
- **Sécurité** : Évite les références orphelines
<a href="" id="cons"></a>

### Inconvénients et précautions

- **Suppressions en chaîne** : Risque de supprimer plus de données que prévu
- **Performance** : Les cascades importantes peuvent être lentes
- **Récupération difficile** : Les données supprimées en cascade sont perdues
- **Debugging complexe** : Difficile de tracer l'origine des suppressions

---
<a href="" id="good-practices"></a>

## Bonnes pratiques
<a href="" id="plan-and-design"></a>

### Planification et conception

- **Analysez les relations métier** avant de choisir le type de cascade
- **Documentez les règles** de cascade dans votre schéma de base
- **Testez les scenarios** de suppression sur des données de test
<a href="" id="security-and-maintenance"></a>

### Sécurité et maintenance

- **Sauvegardez** avant les opérations de suppression importantes
- **Utilisez des transactions** pour pouvoir annuler en cas d'erreur
- **Loggez les opérations** CASCADE pour traçabilité
<a href="" id="good-practices-example"></a>

### Exemples de bonnes pratiques

```sql
-- Transaction sécurisée pour une suppression importante
START TRANSACTION;

-- Vérification avant suppression
SELECT COUNT(*) FROM articles WHERE auteur_id = 1;

-- Suppression avec CASCADE
DELETE FROM auteurs WHERE id = 1;

-- Vérification du résultat
SELECT COUNT(*) FROM articles WHERE auteur_id = 1;

-- Si tout est correct : COMMIT, sinon : ROLLBACK
COMMIT;
-- ou ROLLBACK;
```

---
<a href="" id="key-points"></a>

## Points clés à retenir
[Retour au sommaire](#sommaire)"
- **CASCADE automatise** la maintenance de l'intégrité référentielle
- **ON DELETE CASCADE** supprime les enregistrements enfants
- **ON UPDATE CASCADE** met à jour les clés étrangères des enfants
- **Alternatives** : RESTRICT, SET NULL, SET DEFAULT offrent d'autres comportements
- **Modification** nécessite de supprimer puis recréer la contrainte
- **Test et documentation** sont essentiels avant mise en production
- **Transactions** recommandées pour les opérations sensibles

La maîtrise des contraintes CASCADE est essentielle pour maintenir des bases de données relationnelles cohérentes et fiables.