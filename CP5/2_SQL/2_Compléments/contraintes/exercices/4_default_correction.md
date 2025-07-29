# Correction - Exercices Contraintes SQL
## DEFAULT

### Objectif
==Correction détaillée des exercices sur l'utilisation de DEFAULT avec approche pédagogique adaptative==

<a id="sommaire"></a>

|Numéro|Description|Lien|
|:----:|:----------|----|
|1.1|Système de commandes e-commerce|[👉](#1.1)|
|1.2|Gestion de comptes bancaires|[👉](#1.2)|
|1.3|Plateforme de gestion de tickets support|[👉](#1.3)|
|1.4|Application de réservation hôtelière|[👉](#1.4)|
|1.5|Système de gestion d'inventaire|[👉](#1.5)|
|1.6|Base de données de formations|[👉](#1.6)|

<a id="1.1"></a>

### Correction 1.1 
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
CREATE TABLE commandes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_commande VARCHAR(50) NOT NULL,
    client_id INT NOT NULL,
    statut VARCHAR(20) DEFAULT 'EN_ATTENTE',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    montant_total DECIMAL(10,2) NOT NULL
);

-- Test d'insertion avec valeurs par défaut
INSERT INTO commandes (numero_commande, client_id, montant_total) 
VALUES ('CMD001', 123, 89.99);

-- Test d'insertion avec valeurs explicites
INSERT INTO commandes (numero_commande, client_id, statut, date_creation, montant_total) 
VALUES ('CMD002', 456, 'VALIDEE', '2025-06-26 15:30:00', 156.50);

-- Vérification des résultats
SELECT * FROM commandes;
```

**Analyse du comportement (Bonus) :**

Le script d'insertion fonctionne parfaitement car :
- `statut` prend automatiquement la valeur `'EN_ATTENTE'`
- `date_creation` est automatiquement définie à l'heure actuelle
- Seules les valeurs obligatoires sans DEFAULT sont requises

**Démarche pédagogique d'analyse :**

**Questions stratégiques pour comprendre le contexte :**
- Dans quel flux métier cette commande s'inscrit-elle ?
- Quels sont les états possibles après "EN_ATTENTE" ?
- Comment cette automatisation impacte-t-elle l'expérience utilisateur ?

**Analyse métier approfondie :**
1. **Cohérence du processus** : Toute commande démarre logiquement "EN_ATTENTE"
2. **Traçabilité temporelle** : L'horodatage automatique garantit un suivi précis
3. **Simplification opérationnelle** : Réduit les erreurs de saisie manuelle

**Optimisations contextuelles :**
```sql
-- Version adaptée selon le niveau de maturité de l'équipe
CREATE TABLE commandes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_commande VARCHAR(50) NOT NULL UNIQUE,
    client_id INT NOT NULL,
    statut ENUM('EN_ATTENTE', 'VALIDEE', 'EXPEDIEE', 'LIVREE', 'ANNULEE') 
           DEFAULT 'EN_ATTENTE',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    montant_total DECIMAL(10,2) NOT NULL CHECK (montant_total >= 0)
);
```

---
<a id="1.2"></a>

### Correction 1.2
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- a. Script initial répondant au besoin
CREATE TABLE comptes_bancaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_compte VARCHAR(20) NOT NULL UNIQUE,
    nom_titulaire VARCHAR(100) NOT NULL,
    solde DECIMAL(15,2),
    statut_compte VARCHAR(20),
    date_ouverture DATE
);

-- b. Ajout des contraintes DEFAULT
ALTER TABLE comptes_bancaires 
MODIFY COLUMN solde DECIMAL(15,2) DEFAULT 0.00;

ALTER TABLE comptes_bancaires 
MODIFY COLUMN statut_compte VARCHAR(20) DEFAULT 'ACTIF';

ALTER TABLE comptes_bancaires 
MODIFY COLUMN date_ouverture DATE DEFAULT (CURRENT_DATE);

-- c. Tests de validation
INSERT INTO comptes_bancaires (numero_compte, nom_titulaire) 
VALUES ('FR1234567890123456789', 'Dupont Marie');

INSERT INTO comptes_bancaires (numero_compte, nom_titulaire, solde) 
VALUES ('FR9876543210987654321', 'Martin Jean', 1500.00);

-- Vérification
SELECT * FROM comptes_bancaires;
```

**Réponse à la question de réflexion :**

**Analyse pédagogique des avantages DEFAULT :**

**Niveau débutant - Avantages opérationnels :**
- **Simplicité** : Moins de champs à renseigner = moins d'erreurs
- **Rapidité** : Accélère le processus d'ouverture de compte
- **Cohérence** : Garantit des valeurs standard métier

**Niveau intermédiaire - Intégrité des données :**
- **Standardisation** : Valeurs cohérentes entre tous les comptes
- **Prévention d'erreurs** : Évite les valeurs NULL non souhaitées
- **Conformité réglementaire** : Respecte les exigences bancaires

**Niveau avancé - Architecture système :**
```sql
-- Stratégie avancée avec audit et conformité
CREATE TABLE comptes_bancaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_compte VARCHAR(34) NOT NULL UNIQUE, -- Format IBAN
    nom_titulaire VARCHAR(100) NOT NULL,
    solde DECIMAL(15,2) DEFAULT 0.00 CHECK (solde >= -1000.00), -- Découvert autorisé
    statut_compte ENUM('ACTIF', 'SUSPENDU', 'FERME') DEFAULT 'ACTIF',
    date_ouverture DATE DEFAULT (CURRENT_DATE),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    derniere_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Questions d'approfondissement pour l'apprenant :**
- Comment géreriez-vous l'évolution des règles métier (ex: solde initial promotionnel) ?
- Quels contrôles additionnels implémenteriez-vous selon votre contexte bancaire ?

---
<a id="1.3"></a>

### Correction 1.3
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- a. Script initial
CREATE TABLE tickets_support (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre_ticket VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    priorite VARCHAR(20),
    statut VARCHAR(20),
    date_creation DATETIME,
    assigne_a VARCHAR(100)
);

-- b. Ajout des contraintes DEFAULT
ALTER TABLE tickets_support 
MODIFY COLUMN priorite VARCHAR(20) DEFAULT 'NORMALE';

ALTER TABLE tickets_support 
MODIFY COLUMN statut VARCHAR(20) DEFAULT 'OUVERT';

ALTER TABLE tickets_support 
MODIFY COLUMN date_creation DATETIME DEFAULT CURRENT_TIMESTAMP;

-- c. Tests contextuels
INSERT INTO tickets_support (titre_ticket, description) 
VALUES ('Problème connexion VPN', 'Impossible de se connecter au VPN depuis ce matin');

INSERT INTO tickets_support (titre_ticket, description, priorite, assigne_a) 
VALUES ('Serveur en panne', 'Le serveur principal ne répond plus', 'URGENTE', 'equipe_infrastructure');

-- Analyse des résultats
SELECT id, titre_ticket, priorite, statut, date_creation, assigne_a 
FROM tickets_support;
```

**Analyse pédagogique contextuelle :**

**Méthode d'analyse par questionnement :**
- **Flux utilisateur** : Comment un client soumet-il un ticket ?
- **Priorisation** : Quels critères déterminent une priorité différente ?
- **Attribution** : À quel moment assigne-t-on un technicien ?

**Adaptation selon le niveau organisationnel :**

**Organisation basique :**
```sql
-- Approche simple pour petite équipe
priorite ENUM('BASSE', 'NORMALE', 'HAUTE') DEFAULT 'NORMALE'
statut ENUM('OUVERT', 'EN_COURS', 'RESOLU', 'FERME') DEFAULT 'OUVERT'
```

**Organisation mature :**
```sql
-- Approche avancée avec SLA et escalade
CREATE TABLE tickets_support (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_ticket VARCHAR(20) UNIQUE DEFAULT (CONCAT('TK', YEAR(CURDATE()), '-', LPAD(id, 6, '0'))),
    titre_ticket VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    priorite ENUM('P1_CRITIQUE', 'P2_HAUTE', 'P3_NORMALE', 'P4_BASSE') DEFAULT 'P3_NORMALE',
    statut ENUM('NOUVEAU', 'ASSIGNE', 'EN_COURS', 'ATTENTE_CLIENT', 'RESOLU', 'FERME') DEFAULT 'NOUVEAU',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    sla_limite DATETIME DEFAULT (DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 4 HOUR)),
    assigne_a VARCHAR(100),
    INDEX idx_statut_priorite (statut, priorite),
    INDEX idx_sla (sla_limite)
);
```

**Réflexion sur l'évolutivité :**
Comment ces DEFAULT s'adaptent-ils aux changements organisationnels (nouvelles priorités, processus modifiés) ?

---
<a id="1.4"></a>

### Correction 1.4
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- Scripts d'édition pour ajouter les contraintes DEFAULT
ALTER TABLE reservations 
MODIFY COLUMN nombre_adultes INT DEFAULT 1;

ALTER TABLE reservations 
MODIFY COLUMN statut VARCHAR(20) DEFAULT 'CONFIRMEE';

ALTER TABLE reservations 
MODIFY COLUMN date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP;

-- Tests de validation métier
INSERT INTO reservations (nom_client, numero_chambre, date_arrivee, date_depart) 
VALUES ('Dubois Marie', '101', '2025-07-15', '2025-07-18');

INSERT INTO reservations (nom_client, numero_chambre, date_arrivee, date_depart, nombre_adultes) 
VALUES ('Martin Famille', '203', '2025-08-01', '2025-08-07', 4);

-- Vérification du comportement
SELECT nom_client, numero_chambre, nombre_adultes, statut, date_reservation 
FROM reservations;
```

**Analyse contextuelle du secteur hôtelier :**

**Questions d'analyse métier :**
- Pourquoi "CONFIRMEE" plutôt que "EN_ATTENTE" ?
- Le défaut "1 adulte" correspond-il à votre clientèle type ?
- Comment gérez-vous les réservations famille vs business ?

**Adaptation selon le positionnement hôtelier :**

**Hôtel d'affaires :**
```sql
-- Optimisé pour clientèle business
ALTER TABLE reservations 
MODIFY COLUMN nombre_adultes INT DEFAULT 1;
ALTER TABLE reservations 
MODIFY COLUMN statut VARCHAR(20) DEFAULT 'CONFIRMEE';
-- Confirmation immédiate pour clients professionnels
```

**Hôtel familial :**
```sql
-- Optimisé pour clientèle familiale
ALTER TABLE reservations 
MODIFY COLUMN nombre_adultes INT DEFAULT 2;
ALTER TABLE reservations 
ADD COLUMN nombre_enfants INT DEFAULT 0;
-- Anticipation des besoins familiaux
```

**Évolution vers une approche data-driven :**
```sql
-- Version analytique pour optimisation
CREATE TABLE reservations_enhanced (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_client VARCHAR(100) NOT NULL,
    numero_chambre VARCHAR(10) NOT NULL,
    date_arrivee DATE NOT NULL,
    date_depart DATE NOT NULL,
    nombre_adultes INT DEFAULT 1 CHECK (nombre_adultes > 0),
    nombre_enfants INT DEFAULT 0 CHECK (nombre_enfants >= 0),
    statut ENUM('DEMANDE', 'CONFIRMEE', 'ARRIVEE', 'PARTIE', 'ANNULEE') DEFAULT 'CONFIRMEE',
    date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    canal_reservation ENUM('DIRECT', 'BOOKING', 'EXPEDIA', 'TELEPHONE') DEFAULT 'DIRECT',
    -- Métriques pour analyse
    duree_sejour INT GENERATED ALWAYS AS (DATEDIFF(date_depart, date_arrivee)) STORED,
    INDEX idx_dates (date_arrivee, date_depart),
    INDEX idx_canal_statut (canal_reservation, statut)
);
```

---
<a id="1.5"></a>

### Correction 1.5
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- Scripts d'édition pour ajouter les contraintes DEFAULT
ALTER TABLE produits 
MODIFY COLUMN stock_actuel INT DEFAULT 0;

ALTER TABLE produits 
MODIFY COLUMN disponible BOOLEAN DEFAULT TRUE;

ALTER TABLE produits 
MODIFY COLUMN date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP;

-- Tests de validation
INSERT INTO produits (nom, reference, prix) 
VALUES ('Ordinateur portable Dell', 'DELL-LAT-001', 899.99);

INSERT INTO produits (nom, reference, prix, stock_actuel) 
VALUES ('Souris optique Logitech', 'LOG-MX-002', 29.99, 50);

-- Vérification comportement
SELECT nom, reference, stock_actuel, disponible, date_ajout 
FROM produits;
```

**Analyse pédagogique de la gestion d'inventaire :**

**Questionnement stratégique :**
- **Stock 0 par défaut** : Cohérent avec votre processus d'approvisionnement ?
- **Disponible TRUE** : Comment gérez-vous les produits en développement ?
- **Date d'ajout automatique** : Distinction avec date de première réception ?

**Adaptation selon la maturité de l'organisation :**

**Niveau startup/PME :**
```sql
-- Approche simple et pragmatique
ALTER TABLE produits 
MODIFY COLUMN stock_actuel INT DEFAULT 0 CHECK (stock_actuel >= 0);
ALTER TABLE produits 
MODIFY COLUMN disponible BOOLEAN DEFAULT TRUE;
-- Gestion basique suffisante
```

**Niveau entreprise structurée :**
```sql
-- Approche avec gestion avancée des états
CREATE TABLE produits_advanced (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    reference VARCHAR(50) NOT NULL UNIQUE,
    prix DECIMAL(10,2) NOT NULL CHECK (prix > 0),
    stock_actuel INT DEFAULT 0 CHECK (stock_actuel >= 0),
    stock_minimum INT DEFAULT 5,
    stock_maximum INT DEFAULT 100,
    disponible_vente BOOLEAN DEFAULT FALSE, -- FALSE par défaut = validation requise
    statut_produit ENUM('DEVELOPPEMENT', 'ACTIF', 'OBSOLETE', 'ARCHIVE') DEFAULT 'DEVELOPPEMENT',
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_activation DATETIME NULL,
    fournisseur_principal VARCHAR(100),
    -- Logique métier
    disponible_calcule BOOLEAN GENERATED ALWAYS AS (
        stock_actuel > 0 AND statut_produit = 'ACTIF' AND disponible_vente = TRUE
    ) STORED,
    INDEX idx_disponibilite (disponible_calcule, statut_produit),
    INDEX idx_stock_critique (stock_actuel, stock_minimum)
);
```

**Questions d'approfondissement :**
- Comment intégrez-vous ces DEFAULT dans votre workflow d'ajout produit ?
- Quels contrôles automatiques pourriez-vous implémenter ?

---
<a id="1.6"></a>

### Correction 1.6
###### [Retour au sommaire](#sommaire)

**Solution :**

```sql
-- Scripts d'édition pour ajouter les contraintes DEFAULT
ALTER TABLE participants 
MODIFY COLUMN statut_inscription VARCHAR(20) DEFAULT 'INSCRIT';

ALTER TABLE participants 
MODIFY COLUMN actif BOOLEAN DEFAULT TRUE;

ALTER TABLE participants 
MODIFY COLUMN date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE participants 
MODIFY COLUMN niveau_satisfaction INT DEFAULT 0;

-- Tests représentatifs du workflow
INSERT INTO participants (nom_complet, email, formation_id) 
VALUES ('Dubois Sophie', 'sophie.dubois@email.com', 101);

INSERT INTO participants (nom_complet, email, formation_id, statut_inscription) 
VALUES ('Martin Pierre', 'pierre.martin@email.com', 102, 'LISTE_ATTENTE');

-- Validation des automatismes
SELECT nom_complet, statut_inscription, actif, date_inscription, niveau_satisfaction 
FROM participants;
```

**Réponse à la question bonus :**

**Analyse des risques liés aux valeurs DEFAULT :**

**Problèmes potentiels identifiés :**

1. **Évolution métier non synchronisée**
   ```sql
   -- Exemple : Changement de politique
   -- Ancien : statut DEFAULT 'INSCRIT' (gratuit)
   -- Nouveau : statut DEFAULT 'PRE_INSCRIT' (validation payement)
   ```

2. **Valeurs DEFAULT incohérentes**
   ```sql
   -- Problème : satisfaction à 0 vs échelle 1-10
   ALTER TABLE participants 
   MODIFY COLUMN niveau_satisfaction INT DEFAULT NULL;
   -- Mieux : NULL jusqu'à évaluation réelle
   ```

3. **Impact sur les migrations de données**
   ```sql
   -- Risque lors d'ajout de colonnes sur table peuplée
   ALTER TABLE participants 
   ADD COLUMN nouveau_champ VARCHAR(50) DEFAULT 'TEMP';
   -- Peut créer des millions de lignes avec valeur temporaire
   ```

**Stratégies de mitigation :**

**Approche gouvernance :**
```sql
-- Documentation des DEFAULT avec justification métier
CREATE TABLE participants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_complet VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    formation_id INT NOT NULL,
    -- DEFAULT avec logique métier explicite
    statut_inscription ENUM('PRE_INSCRIT', 'INSCRIT', 'CONFIRME', 'ANNULE') 
                      DEFAULT 'PRE_INSCRIT' 
                      COMMENT 'PRE_INSCRIT = en attente de validation/paiement',
    actif BOOLEAN DEFAULT TRUE 
          COMMENT 'TRUE = peut accéder aux ressources formation',
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    niveau_satisfaction TINYINT DEFAULT NULL 
                        COMMENT 'Echelle 1-5, NULL tant que non évalué',
    -- Auditabilité
    version_schema INT DEFAULT 1,
    date_maj TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Processus de maintien de cohérence :**

1. **Revue périodique des DEFAULT**
   ```sql
   -- Script d'audit des valeurs par défaut
   SELECT 
       COLUMN_NAME, 
       COLUMN_DEFAULT, 
       COLUMN_COMMENT
   FROM INFORMATION_SCHEMA.COLUMNS 
   WHERE TABLE_NAME = 'participants' 
     AND COLUMN_DEFAULT IS NOT NULL;
   ```

2. **Tests de non-régression**
   ```sql
   -- Validation automatique des règles métier
   SELECT 
       COUNT(*) as inscriptions_aujourd_hui,
       COUNT(CASE WHEN statut_inscription = 'INSCRIT' THEN 1 END) as auto_inscrit
   FROM participants 
   WHERE DATE(date_inscription) = CURDATE();
   ```

**Questions de réflexion avancées :**
- Comment documentez-vous l'évolution de vos règles DEFAULT ?
- Quels processus avez-vous pour valider l'impact des changements ?
- Comment gérez-vous la cohérence entre environnements (dev/test/prod) ?

## Synthèse Pédagogique

### Méthodologie d'analyse adaptative

**Démarche par questionnement :**
1. **Contexte métier** : Dans quel processus s'inscrit cette donnée ?
2. **Utilisateurs** : Qui saisit, qui consulte, qui décide ?
3. **Évolution** : Comment ces règles peuvent-elles changer ?
4. **Performance** : Quel impact sur les opérations courantes ?

### Matrice de décision DEFAULT

| Contexte | Recommandation | Exemple |
|----------|----------------|---------|
| **Valeur métier stable** | DEFAULT fixe | Statut 'ACTIF' |
| **Timestamp automatique** | CURRENT_TIMESTAMP | Date création |
| **Valeur calculable** | DEFAULT avec logique | Stock minimum |
| **Donnée évolutive** | NULL + validation | Satisfaction client |

