USE `main-database`;

-- =================================================
-- Table principale : contacts
-- =================================================
DROP TABLE IF EXISTS contacts;
CREATE TABLE contacts (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telephone VARCHAR(20) DEFAULT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Index pour optimiser les recherches
    INDEX idx_nom (nom),
    INDEX idx_email (email),
    INDEX idx_date_creation (date_creation)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================
-- Jeu de données de test (conforme RNCP : "jeu d'essai complet")
-- =================================================
INSERT INTO contacts (nom, prenom, email, telephone) VALUES
('Dupont', 'Jean', 'jean.dupont@example.com', '0123456789'),
('Martin', 'Marie', 'marie.martin@example.com', '0234567890'),
('Durand', 'Pierre', 'pierre.durand@example.com', '0345678901'),
('Leclerc', 'Sophie', 'sophie.leclerc@example.com', '0456789012'),
('Moreau', 'Paul', 'paul.moreau@example.com', '0567890123');

-- =================================================
-- Création d'un utilisateur dédié avec droits limités (sécurité)
-- Conforme aux exigences RNCP : "sécurité, intégrité et confidentialité des données"
-- =================================================
-- =================================================
-- Suppression et recréation propre de l'utilisateur
-- =================================================
DROP USER IF EXISTS 'contacts_user'@'%';
DROP USER IF EXISTS 'contacts_user'@'localhost';

-- Création utilisateur Docker (accepte toutes les adresses IP)
CREATE USER 'contacts_user'@'%' IDENTIFIED BY 'SecurePass2024!';

-- Attribution des droits sur la bonne base et table
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE ON `main-database`.contacts TO 'contacts_user'@'%';

-- Application des privilèges
FLUSH PRIVILEGES;

-- =================================================
-- Vérifications de sécurité
-- =================================================
SELECT User, Host FROM mysql.user WHERE User = 'contacts_user';
SHOW GRANTS FOR 'contacts_user'@'%';

-- =================================================
-- Script de sauvegarde automatique (optionnel)
-- Conforme RNCP : "sauvegarder la base de données de test"
-- =================================================
-- Commande à exécuter en CLI pour créer une sauvegarde :
-- mysqldump -u root -p contacts_db > backup_contacts_$(date +%Y%m%d_%H%M%S).sql

-- =================================================
-- Vérifications post-création
-- =================================================
-- Vérifier la structure de la table
DESCRIBE contacts;

-- Vérifier les données de test
SELECT COUNT(*) as nb_contacts FROM contacts;

-- Vérifier les index
SHOW INDEX FROM contacts;

