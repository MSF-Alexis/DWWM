# Exercice applicatif : Mise en place et exécution d’un jeu de tests pour une base de données de gestion de bibliothèque

**Objectif principal :** Appliquer la méthodologie vue dans le support pour concevoir, implémenter et valider un jeu d’essai complet sur la base de données d’une bibliothèque.

## Contexte et consignes générales

Vous disposez du schéma suivant (extrait du support) :

```sql
CREATE TABLE membres (
  id INT PRIMARY KEY AUTO_INCREMENT,
  numero_carte VARCHAR(10) UNIQUE NOT NULL,
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  date_inscription DATE NOT NULL DEFAULT CURRENT_DATE,
  statut ENUM('actif','suspendu','expire') DEFAULT 'actif',
  telephone VARCHAR(15),
  CONSTRAINT chk_email_format CHECK (email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$')
);
CREATE TABLE livres (
  id INT PRIMARY KEY AUTO_INCREMENT,
  isbn VARCHAR(13) UNIQUE NOT NULL,
  titre VARCHAR(200) NOT NULL,
  auteur VARCHAR(100) NOT NULL,
  annee_publication YEAR NOT NULL,
  genre VARCHAR(50),
  nombre_exemplaires INT NOT NULL DEFAULT 1,
  exemplaires_disponibles INT NOT NULL DEFAULT 1,
  prix_achat DECIMAL(8,2) NOT NULL,
  CONSTRAINT chk_isbn_format CHECK (LENGTH(isbn) IN (10,13)),
  CONSTRAINT chk_annee_valide CHECK (annee_publication BETWEEN 1000 AND YEAR(CURDATE())),
  CONSTRAINT chk_exemplaires_positifs CHECK (nombre_exemplaires > 0),
  CONSTRAINT chk_disponibles_coherents CHECK (exemplaires_disponibles >= 0 AND exemplaires_disponibles <= nombre_exemplaires),
  CONSTRAINT chk_prix_positif CHECK (prix_achat > 0)
);
CREATE TABLE emprunts (
  id INT PRIMARY KEY AUTO_INCREMENT,
  membre_id INT NOT NULL,
  livre_id INT NOT NULL,
  date_emprunt DATE NOT NULL DEFAULT CURRENT_DATE,
  date_retour_prevue DATE NOT NULL,
  date_retour_effective DATE NULL,
  statut ENUM('en_cours','rendu','en_retard','perdu') DEFAULT 'en_cours',
  FOREIGN KEY (membre_id) REFERENCES membres(id) ON DELETE CASCADE,
  FOREIGN KEY (livre_id)  REFERENCES livres(id)   ON DELETE RESTRICT,
  CONSTRAINT chk_dates_coherentes  CHECK (date_retour_prevue > date_emprunt),
  CONSTRAINT chk_retour_effectif   CHECK (date_retour_effective IS NULL OR date_retour_effective >= date_emprunt)
);
```

Votre mission :

1. **Identifier et prioriser** les données et contraintes à tester.
2. **Créer trois jeux de données SQL** :
    - Jeu **positif** (données valides, ≥ 5 enregistrements/tables)
    - Jeu **négatif** (insertions censées échouer, ≥ 6 cas)
    - Jeu **limites** (valeurs extrêmes, ≥ 6 cas)
3. **Rédiger les scripts de validation** qui retournent PASS/FAIL pour chaque contrainte.
4. **Exécuter** les tests manuellement ou via script et **trier** vos résultats dans un tableau de synthèse.
5. **Analyser** les résultats et proposer deux recommandations d’amélioration (structure, index, contraintes, volumétrie).

## Étape 1 : Identification et priorisation des tests

| Type de test | Exemples de cibles | Priorité |
| :-- | :-- | :-- |
| **Structure et schéma** | Présence et types des colonnes, index email/isbn | Critique |
| **Intégrité référentielle** | FK emprunts→membres, emprunts→livres | Critique |
| **Contraintes CHECK / UNIQUE** | Format email, unicité isbn \& numéro_carte | Important |
| **Cohérence métier** | exemplaires_disponibles ≤ nombre_exemplaires | Important |
| **Temporalité** | date_retour_prevue > date_emprunt | Important |
| **Performance** | Recherche par email, requête de jointure volumineuse | Souhaitable |

## Étape 2 : Création des jeux de données

### 2.1 Jeu positif (extrait)

```sql
-- Membres valides
INSERT INTO membres (numero_carte, nom, prenom, email, telephone) VALUES
('BIB1001','Martin','Alice','alice.martin@ex.fr','0123456789'),
('BIB1002','Dupont','Paul','paul.dupont@ex.fr','0987654321'),
('BIB1003','Durand','Sophie','sophie.durand@ex.fr','0147852369'),
('BIB1004','Leroy','Clara','clara.leroy@ex.fr','0765432198'),
('BIB1005','Moreau','Luc','luc.moreau@ex.fr','0654321879');

-- Livres valides
INSERT INTO livres (isbn, titre, auteur, annee_publication, genre, nombre_exemplaires, exemplaires_disponibles, prix_achat) VALUES
('9782070360024','Le Petit Prince','Saint-Exupéry',1943,'Fiction',3,2,12.50),
('9782253002864','Les Misérables','Hugo',1862,'Classique',2,1,15.90),
('0307269992','1984','Orwell',1949,'Dystopie',5,5,10.00),
('9782070417681','L\'Étranger','Camus',1942,'Philosophie',4,4,8.90),
('9782070360031','Germinal','Zola',1885,'Classique',1,0,13.20);

-- Emprunts valides
INSERT INTO emprunts (membre_id, livre_id, date_emprunt, date_retour_prevue, statut) VALUES
(1,1,'2025-06-01','2025-07-01','en_cours'),
(2,2,'2025-05-15','2025-06-15','rendu'),
(3,3,'2025-06-10','2025-07-10','en_cours'),
(4,4,'2025-05-01','2025-06-01','rendu'),
(5,5,'2025-06-20','2025-07-20','en_cours');
```


### 2.2 Jeu négatif (extrait)

```sql
-- N-01 Violation UNIQUE numéro_carte
INSERT INTO membres (numero_carte, nom, prenom, email) VALUES
('BIB1001','Test','Dup','dup@ex.fr');  -- doit échouer

-- N-02 Email invalide
INSERT INTO membres (numero_carte, nom, prenom, email) VALUES
('BIB1010','Test','Email','invalid_email');  -- doit échouer

-- N-03 ISBN hors format
INSERT INTO livres (isbn, titre, auteur, annee_publication, prix_achat) VALUES
('12345','Test','Auteur',2020,5.00);  -- doit échouer

-- N-04 Prix négatif
INSERT INTO livres (isbn, titre, auteur, annee_publication, prix_achat) VALUES
('9782070360055','TestNeg','Auteur',2020,-1.00);  -- doit échouer

-- N-05 FK emprunt vers membre inexistant
INSERT INTO emprunts (membre_id, livre_id, date_emprunt, date_retour_prevue) VALUES
(999,1,'2025-06-01','2025-07-01');  -- doit échouer

-- N-06 date_retour_prevue antérieure à date_emprunt
INSERT INTO emprunts (membre_id, livre_id, date_emprunt, date_retour_prevue) VALUES
(1,1,'2025-07-01','2025-06-01');  -- doit échouer
```


### 2.3 Jeu limites (extrait)

```sql
-- L-01 Email longueur 100 caractères
INSERT INTO membres (numero_carte, nom, prenom, email) VALUES
('BIB1020','LongNom','LongPrenom',
 CONCAT(REPEAT('a',90),'@ex.fr'));  -- doit PASS

-- L-02 ISBN 10 caractères
INSERT INTO livres (isbn, titre, auteur, annee_publication, prix_achat) VALUES
('0307269992','TestISBN10','Auteur',2000,9.99);  -- doit PASS

-- L-03 exemplaires_disponibles = 0
INSERT INTO livres (isbn, titre, auteur, annee_publication, nombre_exemplaires, exemplaires_disponibles, prix_achat) VALUES
('9782070360093','Indisponible','Auteur',2020,1,0,5.00); -- doit PASS

-- L-04 prix max DECIMAL(8,2)
INSERT INTO livres (isbn, titre, auteur, annee_publication, prix_achat) VALUES
('9782070360109','Cher','Auteur',2020,999999.99); -- doit PASS

-- L-05 annee_publication = 1000
INSERT INTO livres (isbn, titre, auteur, annee_publication, prix_achat) VALUES
('9782070360079','Ancien','Auteur',1000,10.00); -- doit PASS

-- L-06 statut emprunt ‘perdu’
INSERT INTO emprunts (membre_id, livre_id, date_emprunt, date_retour_prevue, statut) VALUES
(1,2,'2025-06-10','2025-07-10','perdu'); -- doit PASS
```


## Étape 3 : Scripts de validation PASS/FAIL (exemples)

```sql
-- Test unicité numéro_carte
SELECT 'Unicité carte' AS test,
 CASE WHEN COUNT(*)=COUNT(DISTINCT numero_carte) THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM membres;

-- Test format email
SELECT 'Format email' AS test,
 CASE WHEN COUNT(*)=0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM membres WHERE email NOT REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$';

-- Test FK emprunts→membres
SELECT 'FK emprunts→membres' AS test,
 CASE WHEN COUNT(*)=0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM emprunts e LEFT JOIN membres m ON e.membre_id=m.id WHERE m.id IS NULL;

-- Test CHECK exemplaires
SELECT 'Disponibles≤Total' AS test,
 CASE WHEN COUNT(*)=0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM livres WHERE exemplaires_disponibles>nombre_exemplaires;

-- Test date_retour_prevue
SELECT 'Dates cohérentes' AS test,
 CASE WHEN COUNT(*)=0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM emprunts WHERE date_retour_prevue<=date_emprunt;
```


## Étape 4 : Synthèse des résultats

Créez un tableau récapitulatif :


| ID | Test | Jeu | Résultat attendu | Résultat obtenu | Statut |
| :-- | :-- | :-- | :-- | :-- | :-- |
| P-01 | Unicité numéro_carte | Pos | PASS | … | … |
| N-01 | Violation numéro_carte | Neg | Échec | … | … |
| L-01 | Email 100 caractères | Lim | PASS | … | … |
| … | … | … | … | … | … |

## Étape 5 : Analyse et recommandations

1. **Index supplémentaire** : Création d’index composite (`auteur`, `titre`) pour accélérer les recherches textuelles.
2. **Partitionnement** : Sur la table **emprunts** pour gérer la volumétrie historique.

**Livrables attendus** :

- Scripts SQL de chaque jeu de données
- Fichier SQL de validation PASS/FAIL
- Tableau de synthèse des résultats (format Markdown ou CSV)
- Deux recommandations d’optimisation

Bonne mise en pratique !