# Correction - Exercices Contraintes SQL
## PRIMARY KEY

### Objectif
==Correction détaillée des exercices sur l'utilisation de PRIMARY KEY==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Création d'une table utilisateurs standard|[👉](#1.1)|
|1.2|Création d'un projet club tennis de table|[👉](#1.2)|
|1.3|Gestionnaire de places de parking|[👉](#1.3)|
|1.4|Création d'une table des régions de France|[👉](#1.4)|
|1.5|E-boutique|[👉](#1.5)|
|1.6|Création de table films|[👉](#1.6)|

<a id="1.1"></a>

### Correction 1.1 
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- a. Création de la table utilisateurs
CREATE TABLE utilisateurs (
    id INT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Alternative : Définir la PRIMARY KEY après la création
CREATE TABLE utilisateurs (
    id INT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
```

**Analyse :**
- L'attribut `id` est l'identifiant naturel pour cette table
- La PRIMARY KEY garantit l'unicité et la non-nullité
- Les tailles de VARCHAR sont adaptées aux usages courants

**Réponse au Bonus :**
```sql
INSERT INTO utilisateurs (id, username, email, password) 
VALUES (1, 'john', 'john@email.com', 'pass123');
INSERT INTO utilisateurs (id, username, email, password) 
VALUES (1, 'jane', 'jane@email.com', 'pass456');
```

**Résultat :** La deuxième insertion échouera avec une erreur de violation de contrainte PRIMARY KEY car l'id `1` existe déjà. Message typique : `ERROR: duplicate key value violates unique constraint "utilisateurs_pkey"`

---
<a id="1.2"></a>

### Correction 1.2
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- a. Création de la table adherents
CREATE TABLE adherents (
    numero_licence VARCHAR(20) PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(15),
    date_dernier_paiement DATE
);
```

**Analyse critique de la clé primaire :**

Le numéro de licence présente des **limitations importantes** :

**Problèmes identifiés :**
- Si un adhérent change de numéro de licence → perte de l'historique
- Dépendance externe (fédération de tennis de table)
- Complexité des mises à jour en cascade

**Solution recommandée :**
```sql
CREATE TABLE adherents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_licence VARCHAR(20) UNIQUE NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(15),
    date_dernier_paiement DATE
);
```

**Analyse :**
- Identifiant interne stable (`id`)
- Numéro de licence reste unique mais modifiable
- Préservation de l'intégrité des données

---
<a id="1.3"></a>

### Correction 1.3
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- a. Création de la table places_parking
CREATE TABLE places_parking (
    identifiant VARCHAR(10) PRIMARY KEY,
    est_louee BOOLEAN DEFAULT FALSE,
    adresse TEXT NOT NULL
);

-- Exemple d'insertion
INSERT INTO places_parking (identifiant, est_louee, adresse) 
VALUES 
    ('A-03', FALSE, '123 Rue de la Paix, 75001 Paris'),
    ('B-15', TRUE, '456 Avenue des Champs, 75008 Paris');
```

**Analyse :**
- L'identifiant textuel (`A-03`) est approprié car il a une signification métier
- `BOOLEAN` pour l'état de location (plus clair que INT)
- `TEXT` pour l'adresse (longueur variable)
- `DEFAULT FALSE` évite les valeurs NULL non désirées

---
<a id="1.4"></a>

### Correction 1.4
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
ALTER TABLE regions 
ADD CONSTRAINT pk_regions PRIMARY KEY (region_number);

-- Alternative plus simple
ALTER TABLE regions 
ADD PRIMARY KEY (region_number);
```

**Analyse :**
- `region_number` est l'identifiant logique des régions françaises
- Déjà défini comme `NOT NULL` (prérequis pour PRIMARY KEY)
- Valeur stable et unique par nature

---
<a id="1.5"></a>

### Correction 1.5
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- Script d'édition pour ajouter la PRIMARY KEY
ALTER TABLE products 
ADD CONSTRAINT pk_products PRIMARY KEY (reference);
```

**Analyse :**

**Pourquoi `reference` et non `name` ?**
- La référence produit est unique par conception métier
- Le nom peut avoir des doublons (ex: "T-shirt Rouge" en plusieurs tailles)
- La référence est stable (ne change pas avec les descriptions)
---
<a id="1.6"></a>

### Correction 1.6
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
ALTER TABLE movies 
ADD CONSTRAINT pk_movies PRIMARY KEY (eidr);

```

**Analyse approfondie de l'EIDR :**

L'**Entertainment Identifier Registry** est un système d'identification globale pour les contenus audiovisuels, similaire à l'ISBN pour les livres.

**Avantages de l'EIDR comme PRIMARY KEY :**
- Unicité mondiale garantie
- Standard industriel reconnu
- Immutable (ne change jamais pour un film donné)
- Permet l'interopérabilité entre systèmes

## Synthèse

### Règles fondamentales de PRIMARY KEY

1. **Unicité** : Chaque valeur doit être unique dans la table
2. **Non-nullité** : Aucune valeur NULL autorisée
3. **Immutabilité** : Ne doit pas changer fréquemment
4. **Simplicité** : Préférer les types simples (INT, VARCHAR court)

### Stratégies de choix

| Situation | Recommandation | Exemple |
|-----------|---------------|---------|
| Identifiant naturel stable | Utiliser directement | Numéro SIRET, EIDR |
| Identifiant naturel instable | ID auto + UNIQUE | Numéro licence + id |
| Pas d'identifiant naturel | ID auto-incrémenté | Utilisateurs, commandes |
| Données temporaires | UUID | Sessions, logs |