# Exercice applicatif : Mise en place et exécution d’un jeu de tests pour une base de données de gestion de bibliothèque

**Objectif principal :**
Appliquer la méthodologie vue dans le support pour concevoir, implémenter et valider un jeu d’essai complet sur la base de données d’une bibliothèque.

## Contexte et consignes générales

Vous disposez du schéma suivant :

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
  CONSTRAINT chk_email_format CHECK (
    email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$'
  )
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
  CONSTRAINT chk_annee_valide CHECK (
    annee_publication BETWEEN 1000 AND YEAR(CURDATE())
  ),
  CONSTRAINT chk_exemplaires_positifs CHECK (nombre_exemplaires > 0),
  CONSTRAINT chk_disponibles_coherents CHECK (
    exemplaires_disponibles >= 0 
    AND exemplaires_disponibles <= nombre_exemplaires
  ),
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
  CONSTRAINT chk_dates_coherentes CHECK (
    date_retour_prevue > date_emprunt
  ),
  CONSTRAINT chk_retour_effectif CHECK (
    date_retour_effective IS NULL 
    OR date_retour_effective >= date_emprunt
  )
);
```


## Mission

1. **Identifier et prioriser** les données et contraintes à tester.
2. **Créer trois jeux de données SQL** :
    - Jeu **positif** (données valides, ≥ 5 enregistrements/table)
    - Jeu **négatif** (insertions censées échouer, ≥ 6 cas)
    - Jeu **limites** (valeurs extrêmes, ≥ 6 cas)
3. **Rédiger les scripts de validation** qui retournent PASS/FAIL pour chaque contrainte.
4. **Exécuter** les tests et **organiser** vos résultats dans un tableau de synthèse.
5. **Analyser** les résultats et proposer deux recommandations d’amélioration (structure, index, contraintes, volumétrie).

## Étape 1 : Identification et priorisation des tests

| Type de test | Exemples de cibles | Priorité |
| :-- | :-- | :-- |
| Structure et schéma | Présence et types des colonnes, index email/isbn | Critique |
| Intégrité référentielle | FK emprunts→membres, emprunts→livres | Critique |
| Contraintes CHECK / UNIQUE | Format email, unicité isbn \& numéro_carte | Important |
| Cohérence métier | exemplaires_disponibles ≤ nombre_exemplaires | Important |
| Temporalité | date_retour_prevue > date_emprunt | Important |
| Performance | Recherche par email, jointure volumineuse | Souhaitable |

## Étape 2 : Création des jeux de données

### 2.1 Jeu positif

*(Insérer ≥ 5 enregistrements valides par table)*

```sql
-- Membres valides
INSERT INTO membres (numero_carte, nom, prenom, email, telephone) VALUES
  (...), (...), ...;

-- Livres valides
INSERT INTO livres (isbn, titre, auteur, annee_publication, genre,
                    nombre_exemplaires, exemplaires_disponibles, prix_achat)
VALUES
  (...), (...), ...;

-- Emprunts valides
INSERT INTO emprunts (membre_id, livre_id, date_emprunt,
                     date_retour_prevue, statut)
VALUES
  (...), (...), ...;
```


### 2.2 Jeu négatif

*(Insérer ≥ 6 cas censés échouer)*

```sql
-- N-01 Violation UNIQUE numero_carte
INSERT INTO membres (...) VALUES (...);  -- échec attendu

-- N-02 Email invalide
INSERT INTO membres (...) VALUES (...);  -- échec attendu

-- N-03 ISBN hors format
INSERT INTO livres (...) VALUES (...);  -- échec attendu

-- N-04 Prix négatif
INSERT INTO livres (...) VALUES (...);  -- échec attendu

-- N-05 FK emprunt vers membre inexistant
INSERT INTO emprunts (...) VALUES (...);  -- échec attendu

-- N-06 date_retour_prevue antérieure à date_emprunt
INSERT INTO emprunts (...) VALUES (...);  -- échec attendu
```


### 2.3 Jeu limites

*(Insérer ≥ 6 cas de valeurs extrêmes acceptées)*

```sql
-- L-01 Email longueur maximale
INSERT INTO membres (...) VALUES (...);  -- PASS attendu

-- L-02 ISBN longueur 10
INSERT INTO livres (...) VALUES (...);  -- PASS attendu

-- L-03 exemplaires_disponibles = 0
INSERT INTO livres (...) VALUES (...);  -- PASS attendu

-- L-04 prix maximal DECIMAL(8,2)
INSERT INTO livres (...) VALUES (...);  -- PASS attendu

-- L-05 année_publication = 1000
INSERT INTO livres (...) VALUES (...);  -- PASS attendu

-- L-06 statut emprunt = 'perdu'
INSERT INTO emprunts (...) VALUES (...);  -- PASS attendu
```


## Étape 3 : Scripts de validation PASS/FAIL

```sql
-- Test unicité numero_carte
SELECT 'Unicité carte' AS test,
       CASE WHEN COUNT(*) = COUNT(DISTINCT numero_carte)
            THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM membres;

-- Test format email
SELECT 'Format email' AS test,
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM membres
WHERE email NOT REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$';

-- Test FK emprunts→membres
SELECT 'FK emprunts→membres' AS test,
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM emprunts e
LEFT JOIN membres m ON e.membre_id = m.id
WHERE m.id IS NULL;

-- Test CHECK exemplaires
SELECT 'Disponibles≤Total' AS test,
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM livres
WHERE exemplaires_disponibles > nombre_exemplaires;

-- Test date_retour_prevue
SELECT 'Dates cohérentes' AS test,
       CASE WHEN COUNT(*) = 0 THEN 'PASS' ELSE 'FAIL' END AS resultat
FROM emprunts
WHERE date_retour_prevue <= date_emprunt;
```


## Étape 4 : Tableau de synthèse des résultats

| ID | Test | Jeu | Résultat attendu | Résultat obtenu | Statut |
| :-- | :-- | :-- | :-- | :-- | :-- |
| P-01 | Unicité numero_carte | Pos | PASS | … | … |
| N-01 | Violation numero_carte | Neg | Échec | … | … |
| L-01 | Email longueur maximale | Lim | PASS | … | … |
| … | … | … | … | … | … |

## Étape 5 : Analyse et recommandations

1. **Index composite** (`auteur`, `titre`) pour accélérer les recherches textuelles.
2. **Partitionnement** de la table **emprunts** pour mieux gérer la volumétrie historique.

**Livrables attendus :**

- Scripts SQL de chaque jeu de données
- Fichier SQL de validation PASS/FAIL
- Tableau de synthèse des résultats (Markdown ou CSV)
- Deux recommandations d’optimisation

Bonne mise en pratique !


