# Contraintes d'Intégrité SQL

## Objectifs
|Numéro|Description|
|:----:|-----------|
|1| Définir et appliquer les contraintes : clé primaire, clé étrangère, unicité, non-nullité et vérification|
|2| Maîtriser les contraintes composites pour des règles métier complexes|
|3|Assurer la cohérence et la qualité des données stockées|

<a id="sommaire"></a>

## Somaire interactif
- [Qu'est-ce qu'une contrainte d'intégrité](#definition)
- [Type de contraintes](#contrainte-type)
    - [PRIMARY KEY - PK](#pk-type)
    - [NOT NULL](#not-null-type)
    - [UNIQUE](#unique-type)
    - [DEFAULT](#default-type)
    - [CHECK](#check-type)
    - [FOREIGN KEY - FK](#foreign-key-type)
    - [AUTO_INCREMENT / SERIAL](#auto-increment-type)
- [Contraintes compisites](#cle-composite)
    - [PRIMARY KEY](#primary-key-composite)
    - [UNIQUE](#unique-composite)
    - [CHECK](#check-composite)
    - [FOREIGN KEY](#foreign-key-composite)
- [Actions Cascade](#foreign-key-cascade)
    - [Exemple 1](#cascade-ex-1)
    - [Exemple 2](#cascade-ex-2)
- [Application des contraintes](#application-contrainte)
    - [Lors de la création de la table](#application-contrainte-creation)
        - [PRIMARY KEY - Composite](#application-contrainte-creation-primary-key-composite)
        - [UNIQUE - Composite](#application-contrainte-creation-unique-composite)
    - [Lors de la modification de la table](#application-contrainte-modification)
        - [PRIMARY KEY - Composite](#application-contrainte-modification-primary-key-composite)
        - [UNIQUE - Composite](#application-contrainte-modification-unique-composite)
        - [CHECK - Composite](#application-contrainte-modification-check-composite)
    - [Suppression des contraintes](#contrainte-suppression)
        - [Méthodologie de suppression sécurisée](#application-contrainte-suppression-methodologie)
            - [Analyse préalable](#application-contrainte-suppression-methodologie-analyse)
            - [Syntaxe de suppression](#application-contrainte-suppression-methodologie-syntaxe)
            - [Supprimer une clé primaire](#application-contrainte-suppression-methodologie-syntaxe-pk)
            - [Supprimer une clé étrangère](#application-contrainte-suppression-methodologie-syntaxe-fk)
            - [Supprimer une contrainte unique](#application-contrainte-suppression-methodologie-syntaxe-unique)
            - [Supprimer une contrainte check](#application-contrainte-suppression-methodologie-syntaxe-check)
            - [Supprimer une contrainte not null](#application-contrainte-suppression-methodologie-syntaxe-not-null)
            - [Supprimer une contrainte default](#application-contrainte-suppression-methodologie-syntaxe-default)
            - [Cas pratique](#application-contrainte-cas-pratique)
        - [Suppression de contrainte composite](#application-contrainte-suppression-syntaxe-composite)
            - [Supprimer une clé primaire composite](#application-contrainte-suppression-syntaxe-composite-pk)
            - [Supprimer une contrainte unique composite](#application-contrainte-suppression-syntaxe-composite-unique)
        - [Stratégie de suppression de contrainte en production](#strategies-suppression-contrainte-production)
        - [Diagnostic des contraintes avant suppression](#diagnostic-contrainte-avant-suppression)
        - [Gestion d'erreurs courantes](#gestion-erreurs-courantes)
- [Bonne pratiques](#bonnes-pratiques)
- [Cas d'erreurs typiques avec les contraintes composites](#erreur-typique-contrainte-composite)
- [Points clés à retenir](#points-cles)
---
<a id="definition"></a>

## Qu'est-ce qu'une contrainte d'intégrité ?
[Retour au sommaire](#sommaire)

> **Définition** : Une contrainte d'intégrité est une règle appliquée sur un ou plusieurs attributs d'une table pour contraindre les enregistrements à suivre un format spécifique ou limiter le nombre de relations qu'un enregistrement peut avoir.

---
<a id="contrainte-type"></a>

## Types de contraintes

<a id="pk-type"></a>

### PRIMARY KEY
[Retour au sommaire](#sommaire)

**Description** : Définit l'identifiant unique de chaque enregistrement dans une table. Garantit l'unicité et interdit les valeurs NULL. Une seule clé primaire par table est autorisée.

**Cas d'utilisation** : Identifiant d'un utilisateur, numéro de commande

**Syntaxe simple** :
```sql
CONSTRAINT pk_user PRIMARY KEY (user_id)
```

**Syntaxe composite** :
```sql
-- Clé primaire composite sur plusieurs colonnes
CONSTRAINT pk_reservation PRIMARY KEY (hotel_id, date_reservation, numero_chambre)
```
<a id="not-null-type"></a>

### NOT NULL
[Retour au sommaire](#sommaire)

**Description** : Empêche qu'un attribut contienne une valeur NULL (vide). Garantit qu'une donnée obligatoire soit toujours renseignée.

**Cas d'utilisation** : Le prix d'un produit sur un site e-commerce, nom d'utilisateur obligatoire

**Syntaxe** :
```sql
nom VARCHAR(50) NOT NULL
```
<a id="unique-type"></a>

### UNIQUE
[Retour au sommaire](#sommaire)

**Description** : Garantit que tous les enregistrements ont des valeurs distinctes pour cet attribut. Autorise une seule valeur NULL par colonne.

**Cas d'utilisation** : Numéro de téléphone, adresse email, numéro de sécurité sociale

**Syntaxe simple** :
```sql
CONSTRAINT uk_email UNIQUE (email)
```

**Syntaxe composite** :
```sql
-- Contrainte d'unicité composite : empêche les doublons sur la combinaison
CONSTRAINT uk_employe_projet UNIQUE (employe_id, projet_id, date_debut)
```
<a id="default-type"></a>

### DEFAULT
[Retour au sommaire](#sommaire)

**Description** : Définit une valeur par défaut automatiquement attribuée lors de l'insertion d'un enregistrement si aucune valeur n'est spécifiée.

**Cas d'utilisation** : Pays par défaut lors de l'inscription, statut "actif" par défaut, date de création automatique

**Syntaxe** :
```sql
pays VARCHAR(50) DEFAULT 'France'
```
<a id="check-type"></a>

### CHECK
[Retour au sommaire](#sommaire)

**Description** : Définit une condition que doit respecter la valeur d'un attribut. Permet de valider des règles métier directement dans la base.

**Cas d'utilisation** : Vérifier qu'un âge soit positif, qu'une date de naissance soit antérieure à aujourd'hui, qu'un prix soit supérieur à 0

**Syntaxe simple** :
```sql
CONSTRAINT chk_age CHECK (age >= 0 AND age <= 120)
```

**Syntaxe composite** :
```sql
-- Contrainte CHECK sur plusieurs colonnes
CONSTRAINT chk_dates_coherentes 
CHECK (date_fin IS NULL OR date_fin >= date_debut)
```
<a id="foreign-type"></a>

### FOREIGN KEY
[Retour au sommaire](#sommaire)

**Description** : Crée une relation entre deux tables en garantissant que la valeur existe dans la table référencée (intégrité référentielle). Permet de définir des actions en cascade (CASCADE, RESTRICT, SET NULL).

**Cas d'utilisation** : Lier une commande à un utilisateur existant, associer un produit à une catégorie, empêcher la suppression d'un client ayant des commandes

**Syntaxe simple** :
```sql
CONSTRAINT fk_commande_user 
FOREIGN KEY (user_id) REFERENCES users(id) 
ON DELETE CASCADE
```

**Syntaxe composite** :
```sql
-- Clé étrangère composite référençant une clé primaire composite
CONSTRAINT fk_paiement_reservation 
FOREIGN KEY (hotel_id, date_reservation, numero_chambre) 
REFERENCES reservations(hotel_id, date_reservation, numero_chambre)
ON DELETE RESTRICT
```
<a id="auto-increment-type"></a>

### AUTO_INCREMENT / SERIAL
[Retour au sommaire](#sommaire)

**Description** : Génère automatiquement une valeur numérique croissante pour chaque nouvel enregistrement. Utilisé typiquement pour les clés primaires.

**Cas d'utilisation** : Identifiant automatique d'utilisateur, numéro de commande séquentiel

**Syntaxe** :
```sql
-- MySQL
id INT AUTO_INCREMENT PRIMARY KEY
```

---
<a id="cle-composite">

## Focus : Contraintes Composites
[Retour au sommaire](#sommaire)

### Qu'est-ce qu'une contrainte composite ?

> **Définition** : Une contrainte composite s'applique à plusieurs colonnes simultanément, créant des règles métier plus complexes et précises.

### Cas d'usage des contraintes composites
<a id="primary-key-composite">

#### 1. Clé primaire composite
[Retour au sommaire](#sommaire)
**Contexte** : Table de réservation d'hôtel où l'unicité dépend de plusieurs critères
```sql
CREATE TABLE reservations (
    hotel_id INT NOT NULL,
    date_reservation DATE NOT NULL,
    numero_chambre INT NOT NULL,
    nom_client VARCHAR(100) NOT NULL,
    CONSTRAINT pk_reservation 
        PRIMARY KEY (hotel_id, date_reservation, numero_chambre)
);
```
<a id="unique-composite">

#### 2. Contrainte UNIQUE composite
[Retour au sommaire](#sommaire)
**Contexte** : Table d'affectation employé-projet où un employé ne peut être affecté qu'une fois par projet
```sql
CREATE TABLE affectations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employe_id INT NOT NULL,
    projet_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE,
    CONSTRAINT uk_employe_projet UNIQUE (employe_id, projet_id)
);
```
<a id="check-composite">

#### 3. Contrainte CHECK composite
[Retour au sommaire](#sommaire)
**Contexte** : Validation de cohérence entre plusieurs dates
```sql
CREATE TABLE contrats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE,
    salaire DECIMAL(10,2) NOT NULL,
    CONSTRAINT chk_dates_coherentes 
        CHECK (date_fin IS NULL OR date_fin > date_debut),
    CONSTRAINT chk_salaire_dates 
        CHECK (salaire > 0 AND date_debut >= '2020-01-01')
);
```
<a id="foreign-key-composite">

#### 4. Clé étrangère composite
[Retour au sommaire](#sommaire)
**Contexte** : Référencer une clé primaire composite
```sql
CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    date_reservation DATE NOT NULL,
    numero_chambre INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_paiement_reservation 
        FOREIGN KEY (hotel_id, date_reservation, numero_chambre) 
        REFERENCES reservations(hotel_id, date_reservation, numero_chambre)
        ON DELETE CASCADE
);
```

---
<a id="foreign-key-cascade">

## Actions CASCADE pour les clés étrangères
[Retour au sommaire](#sommaire)
| Action | Description | Exemple |
|--------|-------------|---------|
| **CASCADE** | Propage automatiquement la modification/suppression vers les enregistrements liés | Si on supprime un utilisateur, ses commandes sont aussi supprimées |
| **RESTRICT** | Empêche la modification/suppression si des enregistrements liés existent | Impossible de supprimer un utilisateur ayant des commandes |
| **SET NULL** | Met la clé étrangère à NULL si l'enregistrement parent est supprimé | Si on supprime une catégorie, les produits associés ont leur catégorie mise à NULL |
| **SET DEFAULT** | Met la clé étrangère à sa valeur par défaut si l'enregistrement parent est supprimé | Si on supprime une catégorie, les produits sont associés à une catégorie par défaut |

---

## Exemples pratiques complets
<a id="cascade-ex-1">

### Exemple 1 : E-commerce avec contraintes simples
[Retour au sommaire](#sommaire)

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    age INT CHECK (age >= 0 AND age <= 120),
    pays VARCHAR(50) DEFAULT 'France',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL CHECK (montant > 0),
    statut VARCHAR(20) DEFAULT 'en_attente',
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_commande_user 
        FOREIGN KEY (user_id) 
        REFERENCES users(id) 
        ON DELETE RESTRICT 
        ON UPDATE CASCADE
);
```
<a id="cascade-ex-2">

### Exemple 2 : Système de réservation avec contraintes composites
[Retour au sommaire](#sommaire)
```sql
-- Table des hôtels
CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    ville VARCHAR(50) NOT NULL,
    etoiles INT CHECK (etoiles BETWEEN 1 AND 5)
);

-- Table des chambres avec clé composite
CREATE TABLE chambres (
    hotel_id INT NOT NULL,
    numero INT NOT NULL,
    type_chambre VARCHAR(50) NOT NULL,
    prix_nuit DECIMAL(8,2) NOT NULL CHECK (prix_nuit > 0),
    CONSTRAINT pk_chambre PRIMARY KEY (hotel_id, numero),
    CONSTRAINT fk_chambre_hotel 
        FOREIGN KEY (hotel_id) REFERENCES hotels(id)
        ON DELETE CASCADE
);

-- Table des réservations avec contraintes composites multiples
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    numero_chambre INT NOT NULL,
    nom_client VARCHAR(100) NOT NULL,
    email_client VARCHAR(255) NOT NULL,
    date_arrivee DATE NOT NULL,
    date_depart DATE NOT NULL,
    nombre_adultes INT NOT NULL DEFAULT 1,
    nombre_enfants INT NOT NULL DEFAULT 0,
    CONSTRAINT uk_reservation_unique 
        UNIQUE (hotel_id, numero_chambre, date_arrivee),
    CONSTRAINT chk_dates_logiques 
        CHECK (date_depart > date_arrivee),
    CONSTRAINT chk_occupants 
        CHECK (nombre_adultes > 0 AND nombre_adultes <= 4 
               AND nombre_enfants >= 0 AND nombre_enfants <= 3),
    CONSTRAINT fk_reservation_chambre 
        FOREIGN KEY (hotel_id, numero_chambre) 
        REFERENCES chambres(hotel_id, numero)
        ON DELETE CASCADE
);
```

---
<a id="application-contrainte"></a>

## Application des contraintes
[Retour au sommaire](#sommaire)

<a id="application-contrainte-creation"></a>

### Lors de la création de table
<a id="application-contrainte-creation-primary-key-composite"></a>

#### PRIMARY KEY composite
```sql
CREATE TABLE produit_fournisseur (
    fournisseur_id INT NOT NULL,
    produit_id INT NOT NULL,
    prix_achat DECIMAL(10,2) NOT NULL,
    CONSTRAINT pk_produit_fournisseur 
        PRIMARY KEY (fournisseur_id, produit_id)
);
```
<a id="application-contrainte-creation-unique-composite"></a>

#### UNIQUE composite
```sql
CREATE TABLE inscriptions_cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    cours_id INT NOT NULL,
    semestre VARCHAR(10) NOT NULL,
    annee INT NOT NULL,
    CONSTRAINT uk_inscription_unique 
        UNIQUE (etudiant_id, cours_id, semestre, annee)
);
```
<a id="application-contrainte-modification"></a>

### Lors de la modification de table
<a id="application-contrainte-modification-primary-key-composite"></a>

#### Ajouter une contrainte PRIMARY KEY composite
[Retour au sommaire](#sommaire)

```sql
ALTER TABLE produit_fournisseur 
ADD CONSTRAINT pk_produit_fournisseur 
PRIMARY KEY (fournisseur_id, produit_id);
```
<a id="application-contrainte-modification-unique-composite"></a>

#### Ajouter une contrainte UNIQUE composite
[Retour au sommaire](#sommaire)
```sql
ALTER TABLE inscriptions_cours 
ADD CONSTRAINT uk_inscription_unique 
UNIQUE (etudiant_id, cours_id, semestre, annee);
```
<a id="application-contrainte-modification-check-composite"></a>

#### Ajouter une contrainte CHECK composite
[Retour au sommaire](#sommaire)
```sql
ALTER TABLE reservations 
ADD CONSTRAINT chk_dates_coherentes 
CHECK (date_depart > date_arrivee AND date_arrivee >= CURDATE());
```
<a id="application-contrainte-modification-foreign-key-composite"></a>

#### Ajouter une clé étrangère composite
```sql
ALTER TABLE paiements 
ADD CONSTRAINT fk_paiement_reservation 
FOREIGN KEY (hotel_id, numero_chambre, date_reservation) 
REFERENCES reservations(hotel_id, numero_chambre, date_arrivee);
```
> Mauvaise pratique car la donnée est doublée sur deux tables.

---
<a id="contrainte-suppression"></a>

## Suppression des contraintes
[Retour au sommaire](#sommaire)

### Pourquoi supprimer une contrainte ?

Avant d'aborder les techniques, posons-nous cette question fondamentale : **Dans quels contextes professionnels pourriez-vous être amenés à supprimer des contraintes ?**

**Situations courantes :**
- Évolution des règles métier de l'entreprise
- Migration ou refactoring de base de données
- Correction d'erreurs de conception initiale
- Optimisation des performances
- Maintenance et mise à jour du schéma

<a id="application-contrainte-suppression-methodologie"></a>

### Méthodologie de suppression sécurisée
[Retour au sommaire](#sommaire)
<a id="application-contrainte-suppression-methodologie-analyse"></a>

#### 1. Analyse préalable
**Questions à se poser avant toute suppression :**
- Cette contrainte est-elle encore nécessaire d'un point de vue métier ?
- Quelles sont les dépendances avec d'autres tables ?
- Y a-t-il des applications qui s'appuient sur cette contrainte ?

<a id="application-contrainte-suppression-methodologie-syntaxe"></a>

#### 2. Syntaxes de suppression

<a id="application-contrainte-suppression-methodologie-syntaxe-pk"></a>

##### Supprimer une contrainte PRIMARY KEY
```sql
-- Syntaxe générale
ALTER TABLE nom_table DROP PRIMARY KEY;

-- Exemple pratique
ALTER TABLE users DROP PRIMARY KEY;
```
<a id="application-contrainte-suppression-methodologie-syntaxe-fk"></a>

##### Supprimer une contrainte FOREIGN KEY
```sql
-- Syntaxe avec nom de contrainte
ALTER TABLE nom_table DROP FOREIGN KEY nom_contrainte;

-- Exemple pratique
ALTER TABLE commandes DROP FOREIGN KEY fk_commande_user;
```
<a id="application-contrainte-suppression-methodologie-syntaxe-unique"></a>

##### Supprimer une contrainte UNIQUE
```sql
-- Syntaxe avec nom de contrainte
ALTER TABLE nom_table DROP INDEX nom_contrainte;

-- Exemple pratique
ALTER TABLE users DROP INDEX uk_email;

-- Pour une contrainte UNIQUE composite
ALTER TABLE inscriptions_cours DROP INDEX uk_inscription_unique;
```
<a id="application-contrainte-suppression-methodologie-syntaxe-check"></a>

##### Supprimer une contrainte CHECK
```sql
-- Syntaxe avec nom de contrainte
ALTER TABLE nom_table DROP CHECK nom_contrainte;

-- Exemple pratique
ALTER TABLE users DROP CHECK chk_age;

-- Pour une contrainte CHECK composite
ALTER TABLE contrats DROP CHECK chk_dates_coherentes;
```
<a id="application-contrainte-suppression-methodologie-syntaxe-not-null"></a>

##### Supprimer une contrainte NOT NULL
```sql
-- Modification du type de colonne pour autoriser NULL
ALTER TABLE nom_table MODIFY COLUMN nom_colonne TYPE_COLONNE NULL;

-- Exemple pratique
ALTER TABLE users MODIFY COLUMN nom VARCHAR(100) NULL;
```
<a id="application-contrainte-suppression-methodologie-syntaxe-default"></a>

##### Supprimer une valeur DEFAULT
```sql
-- Syntaxe générale
ALTER TABLE nom_table ALTER COLUMN nom_colonne DROP DEFAULT;

-- Exemple pratique
ALTER TABLE users ALTER COLUMN pays DROP DEFAULT;
```
<a id="application-contrainte-cas-pratique"></a>

### Cas pratique : Refactoring d'une table de réservations
[Retour au sommaire](#sommaire)

**Contexte métier :** Votre entreprise d'hôtellerie change sa politique et souhaite permettre les réservations avec des dates identiques pour la même chambre (système de créneaux horaires).

**Étapes de suppression :**

```sql
-- 1. Identifier la contrainte à supprimer
SHOW CREATE TABLE reservations;

-- 2. Supprimer la contrainte d'unicité composite
ALTER TABLE reservations DROP INDEX uk_reservation_unique;

-- 3. Vérifier que la suppression a bien eu lieu
DESCRIBE reservations;

-- 4. Optionnel : Ajouter une nouvelle contrainte adaptée
ALTER TABLE reservations 
ADD CONSTRAINT uk_reservation_horaire 
UNIQUE (hotel_id, numero_chambre, date_arrivee, heure_arrivee);
```
<a id="application-contrainte-suppression-syntaxe-composite"></a>

### Suppression de contraintes composites : Points d'attention
[Retour au sommaire](#sommaire)
<a id="application-contrainte-suppression-syntaxe-composite-pk"></a>

#### Contrainte PRIMARY KEY composite
```sql
-- Attention : supprimer une clé primaire composite peut impacter les clés étrangères
-- Vérifiez d'abord les tables qui y font référence

-- 1. Identifier les dépendances
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE REFERENCED_TABLE_NAME = 'reservations';

-- 2. Supprimer d'abord les clés étrangères dépendantes
ALTER TABLE paiements DROP FOREIGN KEY fk_paiement_reservation;

-- 3. Puis supprimer la clé primaire composite
ALTER TABLE reservations DROP PRIMARY KEY;
```
<a id="application-contrainte-suppression-syntaxe-composite-unique"></a>

#### Contrainte UNIQUE composite
[Retour au sommaire](#sommaire)
```sql
-- Plus simple car pas de dépendances directes
ALTER TABLE affectations DROP INDEX uk_employe_projet;
```
<a id="strategies-suppression-contrainte-production"></a>

### Stratégies de suppression en production
[Retour au sommaire](#sommaire)

#### Approche progressive pour minimiser les risques

**Phase 1 : Analyse et documentation**
```sql
-- Sauvegarder le schéma actuel
SHOW CREATE TABLE ma_table;

-- Documenter les contraintes existantes
SELECT 
    CONSTRAINT_NAME, 
    CONSTRAINT_TYPE, 
    TABLE_NAME
FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
WHERE TABLE_NAME = 'ma_table';
```

**Phase 2 : Test en environnement de développement**
```sql
-- Créer une copie de la table pour tester
CREATE TABLE ma_table_test LIKE ma_table;
INSERT INTO ma_table_test SELECT * FROM ma_table;

-- Tester la suppression sur la copie
ALTER TABLE ma_table_test DROP CONSTRAINT nom_contrainte;
```

**Phase 3 : Déploiement en production**
```sql
-- Script de rollback préparé au préalable
-- ALTER TABLE ma_table ADD CONSTRAINT ...

-- Suppression effective
ALTER TABLE ma_table DROP CONSTRAINT nom_contrainte;
```
<a id="diagnostic-contrainte-avant-suppression">

### Diagnostic des contraintes avant suppression
[Retour au sommaire](#sommaire)
#### Lister toutes les contraintes d'une table
```sql
-- MySQL
SELECT 
    CONSTRAINT_NAME,
    CONSTRAINT_TYPE,
    COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'nom_table'
UNION
SELECT 
    CONSTRAINT_NAME,
    'CHECK' as CONSTRAINT_TYPE,
    COLUMN_NAME
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS cc
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS tc ON cc.CONSTRAINT_NAME = tc.CONSTRAINT_NAME
WHERE tc.TABLE_NAME = 'nom_table';
```

#### Vérifier l'impact d'une suppression
```sql
-- Identifier les tables enfants (clés étrangères)
SELECT 
    TABLE_NAME as 'Table Enfant',
    COLUMN_NAME as 'Colonne FK',
    CONSTRAINT_NAME as 'Nom Contrainte',
    REFERENCED_COLUMN_NAME as 'Colonne Référencée'
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE REFERENCED_TABLE_NAME = 'ma_table_parent';
```
<a id="gestion-erreurs-courantes"></a>

### Gestion d'erreurs courantes
[Retour au sommaire](#sommaire)
#### Erreur : Impossible de supprimer une clé primaire référencée
```sql
-- Erreur typique
-- ERROR 1217 (23000): Cannot delete or update a parent row: a foreign key constraint fails

-- Solution : Supprimer d'abord les clés étrangères
ALTER TABLE table_enfant DROP FOREIGN KEY fk_vers_parent;
-- Puis supprimer la clé primaire
ALTER TABLE table_parent DROP PRIMARY KEY;
```

#### Erreur : Contrainte inexistante
```sql
-- Erreur typique
-- ERROR 1091 (42000): Can't DROP 'constraint_name'; check that column/key exists

-- Solution : Vérifier le nom exact de la contrainte
SHOW CREATE TABLE ma_table;
```

---
<a id="bonne-pratiques"></a>

## Bonnes pratiques
[Retour au sommaire](#sommaire)

### Nommer les contraintes
Facilite la maintenance et le débogage en cas d'erreur. Utilisez des préfixes clairs :
- `pk_` pour PRIMARY KEY
- `fk_` pour FOREIGN KEY
- `uk_` pour UNIQUE
- `chk_` pour CHECK

### Combiner les contraintes
Une colonne peut avoir plusieurs contraintes simultanément. Veillez à la cohérence entre elles, particulièrement avec les contraintes composites.

### Ordre des colonnes dans les contraintes composites
L'ordre des colonnes dans une contrainte composite est important pour les performances et la logique métier. Placez les colonnes les plus sélectives en premier.

### Documenter les règles métier
Expliquez pourquoi certaines contraintes existent, surtout pour les contraintes composites qui reflètent des règles métier complexes.

### Tester les contraintes
Vérifiez qu'elles bloquent bien les données invalides avec des tests d'insertion appropriés, notamment pour les cas limites des contraintes composites.

### Prévoir les cas d'exception
Certaines règles métier peuvent évoluer avec le temps. Anticipez les modifications futures, particulièrement pour les contraintes composites qui sont plus complexes à modifier.

---
<a id="erreur-typique-contrainte-composite"></a>

## Cas d'erreurs typiques avec les contraintes composites
[Retour au sommaire](#sommaire)

### Erreur de violation de clé primaire composite
```sql
-- Cette insertion échouera si la combinaison existe déjà
INSERT INTO reservations (hotel_id, numero_chambre, date_arrivee, nom_client, email_client, date_depart)
VALUES (1, 101, '2024-06-25', 'Dupont', 'dupont@email.com', '2024-06-27');
```

### Erreur de cohérence CHECK composite
```sql
-- Cette insertion échouera car date_depart <= date_arrivee
INSERT INTO reservations (hotel_id, numero_chambre, date_arrivee, nom_client, email_client, date_depart)
VALUES (1, 102, '2024-06-25', 'Martin', 'martin@email.com', '2024-06-24');
```

---
<a id="points-cles"></a>

## Points clés à retenir
[Retour au sommaire](#sommaire)

- Les contraintes garantissent la **qualité** et la **cohérence** des données
- Les **contraintes composites** permettent de modéliser des règles métier complexes
- L'**ordre des colonnes** dans les contraintes composites est crucial
- Elles doivent être **planifiées** dès la conception de la base de données
- Une **documentation claire** facilite la maintenance et la compréhension
- Les **tests** sont essentiels pour valider le comportement attendu
- La **nomenclature** des contraintes améliore la lisibilité du schéma
- Les contraintes composites offrent plus de **flexibilité** mais demandent plus de **réflexion** dans leur conception

---

**Questions de réflexion pour approfondir votre compréhension :**

1. Dans quels contextes métier les contraintes composites sont-elles indispensables ?
2. Comment équilibrer la complexité des contraintes avec la performance de la base de données ?
3. Quelles sont les implications de maintenance lors de l'évolution des contraintes composites ?
