# Correction - Exercices Contraintes SQL
## UNIQUE

### Objectif
==Correction détaillée des exercices sur l'utilisation de UNIQUE==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Système de gestion d'employés|[👉](#1.1)|
|1.2|Plateforme de réservation d'événements|[👉](#1.2)|
|1.3|Gestion d'inventaire d'une librairie|[👉](#1.3)|
|1.4|Système de billetterie de cinéma|[👉](#1.4)|
|1.5|Application de réseaux sociaux|[👉](#1.5)|
|1.6|Base de données véhicules|[👉](#1.6)|

<a id="1.1"></a>

### Correction 1.1 
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
CREATE TABLE employes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    numero_badge VARCHAR(20)
);

-- Test d'insertion valide
INSERT INTO employes (nom, prenom, email, numero_badge) 
VALUES ('Dupont', 'Jean', 'jean.dupont@entreprise.com', 'EMP001');

-- Test d'insertion avec email unique
INSERT INTO employes (nom, prenom, email, numero_badge) 
VALUES ('Martin', 'Marie', 'marie.martin@entreprise.com', 'EMP002');

-- Test de violation UNIQUE
INSERT INTO employes (nom, prenom, email, numero_badge) 
VALUES ('Durand', 'Paul', 'jean.dupont@entreprise.com', 'EMP003');
-- Erreur : Duplicate entry 'jean.dupont@entreprise.com' for key 'email'
```

**Analyse :**

**Réponse au bonus :**
La deuxième insertion échoue avec une erreur de contrainte UNIQUE. Le système empêche l'ajout d'un deuxième employé avec le même email, garantissant l'unicité de cette donnée critique.

**Justification métier :**
- **Communication** : chaque employé doit avoir une adresse email distincte
- **Authentification** : l'email sert souvent d'identifiant de connexion
- **Traçabilité** : évite les confusions dans les échanges professionnels

**Optimisations suggérées :**
```sql
-- Version améliorée avec validation format email
CREATE TABLE employes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    numero_badge VARCHAR(20) UNIQUE,
    CHECK (email LIKE '%@%.%')
);
```

---
<a id="1.2"></a>

### Correction 1.2
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- a. Script initial
CREATE TABLE evenements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_evenement VARCHAR(255) NOT NULL,
    code_evenement VARCHAR(50) NOT NULL,
    date_evenement DATE NOT NULL,
    lieu VARCHAR(255) NOT NULL
);

-- b. Ajout de la contrainte UNIQUE
ALTER TABLE evenements 
ADD CONSTRAINT uk_code_evenement UNIQUE (code_evenement);

-- c. Tests
INSERT INTO evenements (nom_evenement, code_evenement, date_evenement, lieu) 
VALUES ('Concert Jazz Festival', 'JAZZ2025', '2025-08-15', 'Salle Pleyel');

INSERT INTO evenements (nom_evenement, code_evenement, date_evenement, lieu) 
VALUES ('Festival Rock', 'ROCK2025', '2025-09-20', 'Stade de France');

-- Test de violation
INSERT INTO evenements (nom_evenement, code_evenement, date_evenement, lieu) 
VALUES ('Jazz Night', 'JAZZ2025', '2025-10-05', 'Casino de Paris');
-- Erreur : Duplicate entry 'JAZZ2025' for key 'uk_code_evenement'
```

**Analyse de la question de réflexion :**

**Avantages du code événement unique :**

1. **Lisibilité** : Code métier parlant (JAZZ2025 vs ID technique 1547)
2. **Communication** : Facilite les échanges avec les clients
3. **Intégration** : Compatible avec les systèmes externes
4. **Marketing** : Utilisable dans les campagnes promotionnelles

**Exemple concret :**
```sql
-- Recherche intuitive pour l'utilisateur
SELECT * FROM evenements WHERE code_evenement = 'JAZZ2025';
-- vs recherche par ID technique moins parlante
SELECT * FROM evenements WHERE id = 1547;
```

**Stratégie de nommage recommandée :**
- Format : `TYPE + ANNÉE + SÉQUENCE`
- Exemples : JAZZ2025, ROCK2025, THEATER2025-001

---
<a id="1.3"></a>

### Correction 1.3
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- a. Script initial
CREATE TABLE livres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    isbn VARCHAR(17) NOT NULL,
    prix DECIMAL(10,2),
    stock_disponible INT DEFAULT 0
);

-- b. Ajout de la contrainte UNIQUE
ALTER TABLE livres 
ADD CONSTRAINT uk_isbn UNIQUE (isbn);

-- c. Tests
INSERT INTO livres (titre, auteur, isbn, prix, stock_disponible) 
VALUES ('Le Petit Prince', 'Antoine de Saint-Exupéry', '978-2-07-040818-8', 7.50, 15);

INSERT INTO livres (titre, auteur, isbn, prix, stock_disponible) 
VALUES ('1984', 'George Orwell', '978-2-07-036822-5', 8.90, 8);

-- Test de violation
INSERT INTO livres (titre, auteur, isbn, prix, stock_disponible) 
VALUES ('Le Petit Prince (Edition Collector)', 'Antoine de Saint-Exupéry', '978-2-07-040818-8', 15.00, 3);
-- Erreur : Duplicate entry '978-2-07-040818-8' for key 'uk_isbn'
```

**Analyse métier :**

**Logique de l'ISBN unique :**
- **Standard international** : ISBN = identifiant unique mondial du livre
- **Gestion stock** : plusieurs exemplaires = même ISBN, stock cumulé
- **Commandes fournisseurs** : référencement unique et fiable

**Gestion des éditions multiples :**
```sql
-- Approche recommandée pour les variantes
INSERT INTO livres (titre, auteur, isbn, prix, stock_disponible) 
VALUES ('Le Petit Prince - Edition Collector', 'Antoine de Saint-Exupéry', '978-2-07-051234-9', 15.00, 3);
-- Chaque édition a son propre ISBN
```

**Contrôles de qualité suggérés :**
```sql
-- Validation format ISBN-13
ALTER TABLE livres 
ADD CONSTRAINT chk_isbn_format 
CHECK (isbn REGEXP '^978-[0-9]{1}-[0-9]{2}-[0-9]{6}-[0-9]{1}$');
```

---
<a id="1.4"></a>

### Correction 1.4
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- Script d'édition pour ajouter la contrainte UNIQUE
ALTER TABLE seances 
ADD CONSTRAINT uk_numero_billet UNIQUE (numero_billet);

-- Tests de validation
INSERT INTO seances (id, film, salle, heure_debut, numero_billet) 
VALUES (1, 'Avatar 3', 'Salle A', '20:30:00', 'CINE-2025-001');

INSERT INTO seances (id, film, salle, heure_debut, numero_billet) 
VALUES (2, 'Spider-Man', 'Salle B', '18:00:00', 'CINE-2025-002');

-- Test de violation
INSERT INTO seances (id, film, salle, heure_debut, numero_billet) 
VALUES (3, 'Dune 3', 'Salle C', '22:00:00', 'CINE-2025-001');
-- Erreur : Duplicate entry 'CINE-2025-001' for key 'uk_numero_billet'
```

**Analyse du système de billetterie :**

**Architecture de contrôle :**
1. **Génération** : Numéro billet unique par séance
2. **Validation** : Contrainte UNIQUE empêche les doublons
3. **Traçabilité** : Format standardisé pour audit

**Stratégie de génération des numéros :**
```sql
-- Exemple de fonction de génération
-- Format : CINE-ANNÉE-NUMÉRO_SÉQUENTIEL
-- Implémentation applicative recommandée pour garantir la séquence
```

**Sécurité opérationnelle :**
- Évite les doubles réservations accidentelles
- Facilite le contrôle d'accès en salle
- Permet la traçabilité des ventes

---
<a id="1.5"></a>

### Correction 1.5
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- Script d'édition pour ajouter la contrainte UNIQUE
ALTER TABLE utilisateurs 
ADD CONSTRAINT uk_nom_utilisateur UNIQUE (nom_utilisateur);

-- Tests de validation
INSERT INTO utilisateurs (id, nom_utilisateur, nom_complet, date_inscription, bio) 
VALUES (1, 'marie_dev', 'Marie Dubois', '2025-06-26', 'Développeuse passionnée de technologies web');

INSERT INTO utilisateurs (id, nom_utilisateur, nom_complet, date_inscription, bio) 
VALUES (2, 'jean_photo', 'Jean Martin', '2025-06-26', 'Photographe professionnel');

-- Test de violation
INSERT INTO utilisateurs (id, nom_utilisateur, nom_complet, date_inscription, bio) 
VALUES (3, 'marie_dev', 'Marie Dupont', '2025-06-26', 'Autre Marie avec le même nom d\'utilisateur');
-- Erreur : Duplicate entry 'marie_dev' for key 'uk_nom_utilisateur'
```

**Analyse de l'identité numérique :**

**Enjeux de l'unicité du nom d'utilisateur :**
1. **Identification** : Référence unique pour mentions, messages
2. **URL personnalisée** : `plateforme.com/profile/marie_dev`
3. **Authentification** : Login unique et mémorisable
4. **Réputation** : Construction d'une identité cohérente

**Bonnes pratiques recommandées :**
```sql
-- Amélioration avec contraintes additionnelles
ALTER TABLE utilisateurs 
ADD CONSTRAINT chk_nom_utilisateur_format 
CHECK (nom_utilisateur REGEXP '^[a-zA-Z0-9_]{3,30}$');

-- Index pour recherche rapide
CREATE INDEX idx_nom_utilisateur ON utilisateurs(nom_utilisateur);
```

**Gestion des conflits d'inscription :**
- Vérification en temps réel côté client
- Suggestions alternatives automatiques
- Messages d'erreur informatifs pour l'utilisateur

---
<a id="1.6"></a>

### Correction 1.6
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- Script d'édition pour ajouter les contraintes UNIQUE
ALTER TABLE vehicules 
ADD CONSTRAINT uk_plaque_immatriculation UNIQUE (plaque_immatriculation);

ALTER TABLE vehicules 
ADD CONSTRAINT uk_vin UNIQUE (vin);

-- Tests de validation
INSERT INTO vehicules (id, marque, modele, plaque_immatriculation, vin, annee) 
VALUES (1, 'Renault', 'Clio', 'AB-123-CD', 'VF1CB2A0567123456', 2023);

INSERT INTO vehicules (id, marque, modele, plaque_immatriculation, vin, annee) 
VALUES (2, 'Peugeot', '308', 'EF-456-GH', 'VF3C1HMZ567789012', 2024);

-- Test de violation plaque
INSERT INTO vehicules (id, marque, modele, plaque_immatriculation, vin, annee) 
VALUES (3, 'Citroën', 'C3', 'AB-123-CD', 'VF7S1HM2567123789', 2022);
-- Erreur : Duplicate entry 'AB-123-CD' for key 'uk_plaque_immatriculation'

-- Test de violation VIN
INSERT INTO vehicules (id, marque, modele, plaque_immatriculation, vin, annee) 
VALUES (4, 'Renault', 'Megane', 'IJ-789-KL', 'VF1CB2A0567123456', 2023);
-- Erreur : Duplicate entry 'VF1CB2A0567123456' for key 'uk_vin'
```

**Réponse à la question bonus :**

**Deux champs nécessitant une contrainte UNIQUE :**

1. **Plaque d'immatriculation (`plaque_immatriculation`)**
   - **Justification légale** : Identifiant officiel unique par véhicule
   - **Usage opérationnel** : Contrôles routiers, amendes, assurance
   - **Réglementation** : Obligation légale d'unicité nationale

2. **Numéro VIN (`vin`)**
   - **Justification technique** : Identifiant constructeur unique mondial
   - **Traçabilité industrielle** : Suivi depuis la fabrication
   - **Sécurité** : Lutte contre le vol et le trafic de véhicules

**Analyse comparative :**

| Critère | Plaque d'immatriculation | VIN |
|---------|-------------------------|-----|
| **Portée** | Nationale | Mondiale |
| **Changement** | Possible (déménagement) | Jamais |
| **Visibilité** | Externe | Technique |
| **Usage** | Identification routière | Identification industrielle |

**Implémentation robuste :**
```sql
-- Validation format plaque française
ALTER TABLE vehicules 
ADD CONSTRAINT chk_plaque_format 
CHECK (plaque_immatriculation REGEXP '^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$');

-- Validation format VIN (17 caractères)
ALTER TABLE vehicules 
ADD CONSTRAINT chk_vin_format 
CHECK (CHAR_LENGTH(vin) = 17 AND vin REGEXP '^[A-HJ-NPR-Z0-9]{17}$');
```

## Synthèse

### Méthodologie d'analyse des contraintes UNIQUE

**Démarche systématique :**
1. **Identifier** les données à valeur métier unique
2. **Distinguer** unicité technique vs métier
3. **Anticiper** les cas d'usage et contraintes
4. **Implémenter** avec validation et tests

### Règles fondamentales UNIQUE

| Type de donnée | Application UNIQUE | Exemple |
|----------------|-------------------|---------|
| **Identifiant métier** | Toujours | Code événement, ISBN |
| **Contact** | Recommandé | Email, nom d'utilisateur |
| **Référence légale** | Obligatoire | Plaque immatriculation, VIN |
| **Données techniques** | Selon contexte | Numéro de série |
