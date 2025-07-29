# Correction - Exercices Contraintes SQL
## NOT NULL

### Objectif
==Correction détaillée des exercices sur l'utilisation de NOT NULL==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Gestion de rendez-vous médicale|[👉](#1.1)|
|1.2|Magasin de sport|[👉](#1.2)|
|1.3|Agence de voyage|[👉](#1.3)|
|1.4|École de musique|[👉](#1.4)|
|1.5|Système de réservation - voyage|[👉](#1.5)|
|1.6|Application contact|[👉](#1.6)|

<a id="1.1"></a>

### Correction 1.1 
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
CREATE TABLE rendez_vous (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_patient VARCHAR(100) NOT NULL,
    prenom_patient VARCHAR(100) NOT NULL,
    date_consultation DATETIME NOT NULL,
    motif_visite TEXT,
    medecin_attribue VARCHAR(100)
);

-- Test d'insertion valide
INSERT INTO rendez_vous (nom_patient, prenom_patient, date_consultation) 
VALUES ('Dupont', 'Marie', '2025-07-15 14:30:00');

-- Test d'insertion invalide (violation NOT NULL)
INSERT INTO rendez_vous (nom_patient, date_consultation) 
VALUES ('Martin', '2025-07-16 10:00:00');
-- Erreur : Column 'prenom_patient' cannot be null
```

**Analyse :**

**Éléments obligatoires identifiés :**
- `nom_patient` et `prenom_patient` : constituent l'identité complète exigée
- `date_consultation` : consultation précise requise

**Choix de conception :**
- Séparation nom/prénom pour plus de flexibilité dans les requêtes
- `DATETIME` pour une précision horaire complète
- `motif_visite` et `medecin_attribue` restent optionnels comme spécifié

**Impact métier :** Cette contrainte garantit qu'aucun rendez-vous ne peut être créé sans les informations essentielles à l'identification du patient et à la planification.

---
<a id="1.2"></a>

### Correction 1.2
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
CREATE TABLE produits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reference_unique VARCHAR(50) NOT NULL UNIQUE,
    description_produit TEXT NOT NULL,
    prix_vente DECIMAL(10,2),
    marque VARCHAR(100)
);

-- Test d'insertion valide
INSERT INTO produits (reference_unique, description_produit) 
VALUES ('REF-TENNIS-001', 'Chaussures de tennis professionnelles');

-- Test de violation NOT NULL
INSERT INTO produits (reference_unique) 
VALUES ('REF-FOOT-002');
-- Erreur : Column 'description_produit' cannot be null
```

**Analyse:**

**Justification des choix :**
- `reference_unique` : UNIQUE + NOT NULL = identification produit fiable
- `description_produit` : TEXT pour descriptions détaillées obligatoires
- `DECIMAL(10,2)` : précision monétaire appropriée

**Réflexion métier :**
L'exigence d'une "description claire" est cruciale pour :
- La gestion des stocks
- L'identification visuelle des produits
- La communication avec les clients

**Piège à éviter :** Ne pas confondre référence unique avec clé primaire. Ici, la référence est un identifiant métier, l'ID reste la clé technique.

---
<a id="1.3"></a>

### Correction 1.3
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
CREATE TABLE reservations_voyage (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_voyageur VARCHAR(100) NOT NULL,
    numero_passeport VARCHAR(20) NOT NULL,
    options_restauration VARCHAR(100),
    commentaires_speciaux TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Test d'insertion complète
INSERT INTO reservations_voyage (nom_voyageur, numero_passeport, options_restauration) 
VALUES ('Dubois Jean-Pierre', 'FR123456789', 'Menu végétarien');

-- Test de violation (passeport manquant)
INSERT INTO reservations_voyage (nom_voyageur, options_restauration) 
VALUES ('Martin Sophie', 'Sans gluten');
-- Erreur : Column 'numero_passeport' cannot be null
```

**Analyse:**

**Contraintes obligatoires justifiées :**
- `nom_voyageur` : identification légale obligatoire
- `numero_passeport` : exigence douanière et sécuritaire

**Considérations RGPD :**
- Données sensibles (passeport) → nécessite des mesures de protection
- Justification métier claire pour la collecte
- Durée de conservation à définir

**Flexibilité opérationnelle :**
Les champs optionnels permettent une saisie progressive jusqu'à 48h avant le départ, optimisant le processus commercial.

---
<a id="1.4"></a>

### Correction 1.4
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
ALTER TABLE Eleve 
MODIFY COLUMN prenom_nom VARCHAR(80) NOT NULL;

ALTER TABLE Eleve 
MODIFY COLUMN instrument_principal VARCHAR(40) NOT NULL;

-- Test de la contrainte
INSERT INTO Eleve (id, prenom_nom, instrument_principal) 
VALUES (1, 'Dubois Marie', 'Piano');

-- Test de violation
INSERT INTO Eleve (id, prenom_nom) 
VALUES (2, 'Martin Paul');
-- Erreur : Field 'instrument_principal' doesn't have a default value
```

**Analyse du processus métier :**

**Logique :**
1. **Inscription** : identité + choix instrumental (immédiat)
2. **Audition** : évaluation du niveau (différé)
3. **Affectation** : attribution professeur (après audition)

**Justification des contraintes :**
- `prenom_nom` : identification administrative obligatoire
- `instrument_principal` : base de l'organisation pédagogique

**Alternative pour les données existantes :**
```sql
-- Si la table contient déjà des données
UPDATE Eleve SET prenom_nom = 'À définir' WHERE prenom_nom IS NULL;
UPDATE Eleve SET instrument_principal = 'Non choisi' WHERE instrument_principal IS NULL;
-- Puis appliquer les contraintes
```

---
<a id="1.5"></a>

### Correction 1.5
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
ALTER TABLE Reservation 
MODIFY COLUMN voyageur VARCHAR(100) NOT NULL;

ALTER TABLE Reservation 
MODIFY COLUMN numero_passeport VARCHAR(20) NOT NULL;

-- Vérification des données existantes (recommandé avant modification)
SELECT COUNT(*) as reservations_incompletes 
FROM Reservation 
WHERE voyageur IS NULL OR numero_passeport IS NULL;

-- Test post-modification
INSERT INTO Reservation (id, voyageur, numero_passeport) 
VALUES (1, 'Leroy Antoine', 'BE987654321');
```

**Démarche de migration sécurisée :**

**Étapes recommandées :**
1. **Audit préalable** : identifier les enregistrements incomplets
2. **Nettoyage** : corriger ou supprimer les données invalides
3. **Application** : ajouter les contraintes NOT NULL
4. **Test** : valider le comportement

**Script de nettoyage type :**
```sql
-- Identifier les problèmes
SELECT id, voyageur, numero_passeport 
FROM Reservation 
WHERE voyageur IS NULL OR numero_passeport IS NULL;

-- Options de correction
-- Option 1 : Supprimer les réservations incomplètes
DELETE FROM Reservation 
WHERE voyageur IS NULL OR numero_passeport IS NULL;

-- Option 2 : Compléter avec des valeurs par défaut
UPDATE Reservation 
SET voyageur = 'À confirmer' 
WHERE voyageur IS NULL;
```

---
<a id="1.6"></a>

### Correction 1.6
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
ALTER TABLE Contact 
MODIFY COLUMN nom_complet VARCHAR(80) NOT NULL;

ALTER TABLE Contact 
MODIFY COLUMN telephone VARCHAR(20) NOT NULL;

-- Test d'insertion valide
INSERT INTO Contact (id, nom_complet, telephone) 
VALUES (1, 'Durand Sylvie', '06.12.34.56.78');

-- Test avec données optionnelles
INSERT INTO Contact (id, nom_complet, telephone, email, anniversaire) 
VALUES (2, 'Bernard Michel', '01.23.45.67.89', 'michel@email.com', '1985-03-15');
```

**Analyse des besoins fonctionnels :**

**Contraintes métier justifiées :**
- `nom_complet` : identification de base du contact
- `telephone` : moyen de communication principal

**Optimisations possibles :**
```sql
-- Amélioration du modèle avec validation format
ALTER TABLE Contact 
ADD CONSTRAINT chk_telephone_format 
CHECK (telephone REGEXP '^[0-9+\.\-\s]+$');

-- Index pour recherche rapide
CREATE INDEX idx_nom_contact ON Contact(nom_complet);
```

## Synthèse

### Méthodologie d'analyse des besoins

**Démarche systématique :**
1. **Identifier** les données essentielles vs optionnelles
2. **Justifier** chaque contrainte par un besoin métier
3. **Anticiper** l'impact sur les utilisateurs
4. **Tester** les cas limites

### Règles fondamentales NOT NULL

| Critère | Application | Exemple |
|---------|-------------|---------|
| **Obligatoire légal** | Toujours NOT NULL | Numéro passeport |
| **Processus métier** | NOT NULL si critique | Date rendez-vous |
| **Évolutif** | Laisser optionnel | Commentaires |
| **Technique** | Selon architecture | ID auto-incrémenté |
