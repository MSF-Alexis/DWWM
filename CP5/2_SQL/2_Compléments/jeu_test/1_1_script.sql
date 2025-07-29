-- ==============================================
-- SCRIPT SQL COMPLET - JEUX D'ESSAI E-COMMERCE
-- Conforme aux contraintes du document de formation
-- ==============================================

-- Création de la base de données avec encodage UTF8
CREATE DATABASE IF NOT EXISTS ecommerce_artisanal 
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ecommerce_artisanal;

-- Suppression des tables existantes (ordre inverse pour éviter les contraintes FK)
DROP TABLE IF EXISTS avis;
DROP TABLE IF EXISTS commande_produit;
DROP TABLE IF EXISTS commandes;
DROP TABLE IF EXISTS produits;
DROP TABLE IF EXISTS utilisateurs;

-- ==============================================
-- CRÉATION DES TABLES AVEC CONTRAINTES
-- ==============================================

-- Table utilisateurs avec contraintes complètes
CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- Contraintes pour limiter les dates (test des limites)
    CONSTRAINT chk_date_creation_min CHECK (date_creation >= '1900-01-01'),
    CONSTRAINT chk_date_creation_max CHECK (date_creation <= '2099-12-31')
);

-- Table produits avec contraintes métier
CREATE TABLE produits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(200) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    description TEXT,
    stock INT NOT NULL DEFAULT 0,
    image_url VARCHAR(500),
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    -- Contraintes métier essentielles
    CONSTRAINT chk_prix_positif CHECK (prix > 0),
    CONSTRAINT chk_stock_positif CHECK (stock >= 0),
    CONSTRAINT chk_prix_max CHECK (prix <= 99999999.99)
);

-- Table commandes avec contraintes d'intégrité
CREATE TABLE commandes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    date_commande TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    montant_total DECIMAL(10,2) NOT NULL,
    statut VARCHAR(50) NOT NULL DEFAULT 'en_attente',
    -- Contraintes métier
    CONSTRAINT chk_montant_positif CHECK (montant_total > 0),
    CONSTRAINT chk_statut_valide CHECK (statut IN ('en_attente', 'confirmee', 'expediee', 'livree', 'annulee')),
    -- Clé étrangère avec cascade
    CONSTRAINT fk_commandes_utilisateur 
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) 
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table de liaison commande_produit (relation many-to-many)
CREATE TABLE commande_produit (
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    -- Clé primaire composite
    PRIMARY KEY (commande_id, produit_id),
    -- Contraintes métier
    CONSTRAINT chk_quantite_positive CHECK (quantite > 0),
    CONSTRAINT chk_prix_unitaire_positif CHECK (prix_unitaire > 0),
    -- Clés étrangères
    CONSTRAINT fk_commande_produit_commande 
        FOREIGN KEY (commande_id) REFERENCES commandes(id) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_commande_produit_produit 
        FOREIGN KEY (produit_id) REFERENCES produits(id) 
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table avis avec contraintes de validation
CREATE TABLE avis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    produit_id INT NOT NULL,
    note INT NOT NULL,
    commentaire TEXT,
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    -- Contrainte pour la note (1-5)
    CONSTRAINT chk_note_valide CHECK (note >= 1 AND note <= 5),
    -- Contrainte d'unicité : un utilisateur ne peut laisser qu'un avis par produit
    UNIQUE KEY unique_avis_utilisateur_produit (utilisateur_id, produit_id),
    -- Clés étrangères
    CONSTRAINT fk_avis_utilisateur 
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_avis_produit 
        FOREIGN KEY (produit_id) REFERENCES produits(id) 
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- ==============================================
-- JEUX D'ESSAI : DONNÉES VALIDES
-- ==============================================

-- Insertion d'utilisateurs valides
INSERT INTO utilisateurs (email, nom, prenom, mot_de_passe) VALUES 
('alice.martin@email.com', 'Martin', 'Alice', '$2y$10$hash_valide_alice'),
('bob.dupont@gmail.com', 'Dupont', 'Bob', '$2y$10$hash_valide_bob'),
('carol.durand@outlook.fr', 'Durand', 'Carol', '$2y$10$hash_valide_carol'),
('david.moreau@yahoo.fr', 'Moreau', 'David', '$2y$10$hash_valide_david');

-- Insertion de produits valides
INSERT INTO produits (nom, prix, description, stock) VALUES 
('Vase artisanal en céramique', 29.99, 'Vase fait main unique', 5),
('Sculpture bois flotté', 89.50, 'Création originale en bois flotté', 2),
('Collier perles naturelles', 15.75, 'Bijou artisanal authentique', 12),
('Tableau peinture huile', 150.00, 'Œuvre originale sur toile', 1),
('Bougie parfumée lavande', 8.50, 'Bougie artisanale 100% naturelle', 25);

-- Insertion de commandes valides
INSERT INTO commandes (utilisateur_id, montant_total, statut) VALUES 
(1, 45.74, 'confirmee'),
(2, 89.50, 'expediee'),
(1, 15.75, 'livree'),
(3, 158.50, 'confirmee');

-- Insertion dans la table de liaison commande_produit
INSERT INTO commande_produit (commande_id, produit_id, quantite, prix_unitaire) VALUES 
(1, 1, 1, 29.99),
(1, 3, 1, 15.75),
(2, 2, 1, 89.50),
(3, 3, 1, 15.75),
(4, 4, 1, 150.00),
(4, 5, 1, 8.50);

-- Insertion d'avis valides
INSERT INTO avis (utilisateur_id, produit_id, note, commentaire) VALUES 
(1, 1, 5, 'Magnifique vase, très bonne qualité !'),
(2, 2, 4, 'Belle sculpture, livraison rapide'),
(1, 3, 5, 'Collier très élégant, ma femme adore'),
(3, 5, 3, 'Parfum agréable mais un peu léger');

-- ==============================================
-- JEUX D'ESSAI : TESTS D'ERREURS VOLONTAIRES
-- ==============================================

-- Test 1: Violation de contrainte de clé primaire
-- Cette requête devrait échouer (ID déjà existant)
-- INSERT INTO utilisateurs (id, email, nom, prenom, mot_de_passe) VALUES 
-- (1, 'test@email.com', 'Test', 'User', 'password');

-- Test 2: Violation de contrainte d'intégrité référentielle
-- Cette requête devrait échouer (utilisateur inexistant)
-- INSERT INTO commandes (utilisateur_id, montant_total, statut) VALUES 
-- (999, 100.00, 'confirmee');

-- Test 3: Violation de contrainte métier - Prix négatif
-- Cette requête devrait échouer
-- INSERT INTO produits (nom, prix, description, stock) VALUES 
-- ('Produit test', -10.50, 'Description test', 1);

-- Test 4: Violation de contrainte métier - Stock négatif
-- Cette requête devrait échouer
-- INSERT INTO produits (nom, prix, description, stock) VALUES 
-- ('Autre produit', 25.00, 'Description', -5);

-- Test 5: Violation de contrainte d'unicité email
-- Cette requête devrait échouer (email déjà utilisé)
-- INSERT INTO utilisateurs (email, nom, prenom, mot_de_passe) VALUES 
-- ('alice.martin@email.com', 'Autre', 'Nom', 'password');

-- Test 6: Violation de contrainte métier - Note invalide
-- Cette requête devrait échouer (note hors limite)
-- INSERT INTO avis (utilisateur_id, produit_id, note, commentaire) VALUES 
-- (1, 2, 6, 'Note trop élevée');

-- Test 7: Violation de contrainte de statut commande
-- Cette requête devrait échouer (statut invalide)
-- INSERT INTO commandes (utilisateur_id, montant_total, statut) VALUES 
-- (1, 50.00, 'statut_inexistant');

-- ==============================================
-- JEUX D'ESSAI : TESTS DE LIMITES
-- ==============================================

-- Test de limite : Email à la taille maximale (255 caractères)
INSERT INTO utilisateurs (email, nom, prenom, mot_de_passe) VALUES 
('utilisateur_avec_un_email_extremement_long_qui_approche_la_limite_maximale_autorisee_de_255_caracteres_pour_tester_si_notre_base_de_donnees_gere_correctement_cette_situation_limite_sans_generer_erreur_truncation@domaine-tres-long.com', 'Test', 'Limite', 'password');

-- Test de limite : Prix maximum
INSERT INTO produits (nom, prix, description, stock) VALUES 
('Produit très cher', 99999999.99, 'Test prix maximum', 1);

-- Test de limite : Stock maximum (dans les limites INT)
INSERT INTO produits (nom, prix, description, stock) VALUES 
('Produit stock max', 25.00, 'Test stock', 999999);

-- Test de limite : Date future très éloignée
INSERT INTO utilisateurs (email, nom, prenom, mot_de_passe, date_creation) VALUES 
('futur@email.com', 'Futur', 'User', 'password', '2099-12-31 23:59:59');

-- Test de limite : Date passée ancienne
INSERT INTO utilisateurs (email, nom, prenom, mot_de_passe, date_creation) VALUES 
('ancien@email.com', 'Ancien', 'User', 'password', '1900-01-01 00:00:00');

-- ==============================================
-- SCRIPTS DE VALIDATION DES CONTRAINTES
-- ==============================================

-- Vérification 1: Contrainte prix positif
SELECT 'Test contrainte prix' AS test_nom,
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM produits WHERE prix <= 0;

-- Vérification 2: Contrainte stock positif
SELECT 'Test contrainte stock' AS test_nom,
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM produits WHERE stock < 0;

-- Vérification 3: Contrainte note entre 1 et 5
SELECT 'Test contrainte note' AS test_nom,
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM avis WHERE note < 1 OR note > 5;

-- Vérification 4: Intégrité référentielle commandes
SELECT 'Test intégrité commandes' AS test_nom,
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM commandes c 
LEFT JOIN utilisateurs u ON c.utilisateur_id = u.id 
WHERE u.id IS NULL;

-- Vérification 5: Unicité email utilisateurs
SELECT 'Test unicité email' AS test_nom,
       CASE WHEN COUNT(*) = COUNT(DISTINCT email) THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM utilisateurs;

-- ==============================================
-- REQUÊTES DE PERFORMANCE ET STATISTIQUES
-- ==============================================

-- Statistiques générales
SELECT 
    'Utilisateurs' AS table_nom, COUNT(*) AS nb_enregistrements
FROM utilisateurs
UNION ALL
SELECT 
    'Produits' AS table_nom, COUNT(*) AS nb_enregistrements
FROM produits
UNION ALL
SELECT 
    'Commandes' AS table_nom, COUNT(*) AS nb_enregistrements
FROM commandes
UNION ALL
SELECT 
    'Avis' AS table_nom, COUNT(*) AS nb_enregistrements
FROM avis;

-- Test de performance : Requête complexe avec jointures
SELECT 
    u.nom,
    u.prenom,
    COUNT(DISTINCT c.id) AS nb_commandes,
    COALESCE(SUM(c.montant_total), 0) AS total_achats,
    COUNT(DISTINCT a.id) AS nb_avis,
    COALESCE(AVG(a.note), 0) AS moyenne_notes
FROM utilisateurs u
LEFT JOIN commandes c ON u.id = c.utilisateur_id
LEFT JOIN avis a ON u.id = a.utilisateur_id
GROUP BY u.id, u.nom, u.prenom
ORDER BY total_achats DESC;

-- ==============================================
-- NETTOYAGE OPTIONNEL (décommenter si nécessaire)
-- ==============================================

-- Pour nettoyer toutes les données de test :
-- DELETE FROM avis;
-- DELETE FROM commande_produit;
-- DELETE FROM commandes;
-- DELETE FROM produits;
-- DELETE FROM utilisateurs;

-- Pour supprimer complètement la base :
-- DROP DATABASE IF EXISTS ecommerce_artisanal;
