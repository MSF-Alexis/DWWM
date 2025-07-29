# Correction – Exercices Index SQL (Unique)

## Objectif

==Correction détaillée des exercices sur l'utilisation d'index uniques vs contraintes uniques avec focus sur les cas où l'index unique apporte des avantages spécifiques==

<a id="sommaire"></a>


| Numéro | Description | Lien |
| :--: | :-- | :-- |
| 4.1 | Blog : Gestion des slugs avec historique | [👉](#4.1) |
| 4.2 | E-commerce : SKU actifs uniquement | [👉](#4.2) |
| 4.3 | Système de notifications : Tokens valides | [👉](#4.3) |
| 4.4 | Plateforme de réservation : Créneaux disponibles | [👉](#4.4) |
| 4.5 | Application mobile : Sessions actives | [👉](#4.5) |
| 4.6 | Optimisation avec colonnes incluses | [👉](#4.6) |

<a id="4.1"></a>

### Correction 4.1 - Blog : Gestion des slugs avec historique

###### [Retour au sommaire](#sommaire)

**Contexte :** Un blog avec un système de versions d'articles. Chaque article peut avoir plusieurs versions, mais seulement une version peut être **publiée** à la fois. Le slug doit être unique pour les articles publiés.

**Problème avec une contrainte unique :**

```sql
-- ❌ Ceci ne fonctionne pas car on veut plusieurs versions par slug
ALTER TABLE articles ADD CONSTRAINT uk_slug UNIQUE (slug);
```

**Solution avec index unique filtré :**

```sql
-- ✅ Index unique seulement sur les articles publiés
CREATE UNIQUE INDEX idx_unique_slug_published 
ON articles (slug) 
WHERE statut = 'publie';
```

**Exemple concret :**

```sql
-- Table articles
CREATE TABLE articles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    slug VARCHAR(255) NOT NULL,
    titre VARCHAR(500) NOT NULL,
    contenu TEXT,
    statut ENUM('brouillon', 'publie', 'archive') DEFAULT 'brouillon',
    version INT DEFAULT 1,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ces insertions fonctionnent parfaitement
INSERT INTO articles (slug, titre, statut, version) VALUES 
('mon-premier-article', 'Mon Premier Article', 'brouillon', 1),
('mon-premier-article', 'Mon Premier Article', 'brouillon', 2),
('mon-premier-article', 'Mon Premier Article', 'publie', 3);

-- Mais celle-ci échouera (2 articles publiés avec même slug)
INSERT INTO articles (slug, titre, statut, version) VALUES 
('mon-premier-article', 'Mon Premier Article Modifié', 'publie', 4);
-- Erreur : duplicate key value violates unique constraint
```

**Avantage de l'index unique :**

- **Flexibilité** : Permet plusieurs brouillons du même slug
- **Performance** : Index plus petit car il ne contient que les articles publiés
- **Logique métier** : Respecte la règle "un seul article publié par slug"

---
<a id="4.2"></a>

### Correction 4.2 - E-commerce : SKU actifs uniquement

###### [Retour au sommaire](#sommaire)

**Contexte :** Catalogue produits où les SKU (références) doivent être uniques, mais seulement pour les produits **actifs**. Les produits supprimés peuvent garder leur SKU pour l'historique.

**Solution avec index unique conditionnel :**

```sql
-- Table produits
CREATE TABLE produits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sku VARCHAR(50) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2),
    actif BOOLEAN DEFAULT TRUE,
    date_suppression TIMESTAMP NULL
);

-- Index unique seulement sur les produits actifs
CREATE UNIQUE INDEX idx_unique_sku_actif 
ON produits (sku) 
WHERE actif = TRUE;
```

**Cas d'usage pratique :**

```sql
-- Insertion de produits actifs
INSERT INTO produits (sku, nom, prix) VALUES 
('PHONE-001', 'iPhone 15', 999.99),
('PHONE-002', 'Samsung Galaxy S24', 899.99);

-- Suppression logique d'un produit
UPDATE produits SET actif = FALSE, date_suppression = NOW() 
WHERE sku = 'PHONE-001';

-- Maintenant on peut réutiliser le SKU pour un nouveau produit
INSERT INTO produits (sku, nom, prix) VALUES 
('PHONE-001', 'iPhone 16', 1099.99);
-- ✅ Fonctionne ! L'ancien PHONE-001 est inactif
```

**Pourquoi pas une contrainte unique classique ?**

- **Contrainte classique** = bloquerait la réutilisation des SKU même pour les produits supprimés
- **Index unique filtré** = permet la réutilisation intelligente des références

**Performance :**

- Index 3x plus petit (seulement les produits actifs)
- Recherches plus rapides sur le catalogue actif

---
<a id="4.3"></a>

### Correction 4.3 - Système de notifications : Tokens valides

###### [Retour au sommaire](#sommaire)

**Contexte :** Tokens de notification push. Un token doit être unique par utilisateur **actif**, mais les tokens expirés peuvent être dupliqués (réutilisation possible).

**Solution :**

```sql
CREATE TABLE notification_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expire_at TIMESTAMP NOT NULL,
    actif BOOLEAN DEFAULT TRUE
);

-- Index unique sur les tokens non expirés
CREATE UNIQUE INDEX idx_unique_token_valide 
ON notification_tokens (user_id, token) 
WHERE expire_at > NOW() AND actif = TRUE;
```

**Cas concret :**

```sql
-- Token actuel de l'utilisateur 123
INSERT INTO notification_tokens (user_id, token, expire_at) VALUES 
(123, 'abc123def456', NOW() + INTERVAL 30 DAY);

-- Le token expire automatiquement après 30 jours
-- L'utilisateur peut maintenant avoir un nouveau token identique
INSERT INTO notification_tokens (user_id, token, expire_at) VALUES 
(123, 'abc123def456', NOW() + INTERVAL 30 DAY);
-- ✅ Autorisé car l'ancien token est expiré
```

**Avantage vs contrainte unique :**

- **Gestion automatique** des expirations
- **Réutilisation intelligente** des tokens
- **Index plus petit** (seulement les tokens valides)

---
<a id="4.4"></a>

### Correction 4.4 - Plateforme de réservation : Créneaux disponibles

###### [Retour au sommaire](#sommaire)

**Contexte :** Système de réservation de salles. Un créneau ne peut être réservé qu'une seule fois, mais les réservations annulées libèrent le créneau.

**Solution :**

```sql
CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    salle_id INT NOT NULL,
    date_heure DATETIME NOT NULL,
    duree_minutes INT NOT NULL,
    user_id INT NOT NULL,
    statut ENUM('confirmee', 'annulee', 'terminee') DEFAULT 'confirmee'
);

-- Unicité seulement pour les réservations confirmées
CREATE UNIQUE INDEX idx_unique_creneau_confirme 
ON reservations (salle_id, date_heure, duree_minutes) 
WHERE statut = 'confirmee';
```

**Exemple d'utilisation :**

```sql
-- Réservation initiale
INSERT INTO reservations (salle_id, date_heure, duree_minutes, user_id) VALUES 
(1, '2024-12-15 14:00:00', 120, 456);

-- Tentative de double réservation
INSERT INTO reservations (salle_id, date_heure, duree_minutes, user_id) VALUES 
(1, '2024-12-15 14:00:00', 120, 789);
-- ❌ Erreur : créneau déjà réservé

-- Annulation de la première réservation
UPDATE reservations SET statut = 'annulee' WHERE id = 1;

-- Nouvelle réservation maintenant possible
INSERT INTO reservations (salle_id, date_heure, duree_minutes, user_id) VALUES 
(1, '2024-12-15 14:00:00', 120, 789);
-- ✅ Fonctionne ! Le créneau est libéré
```


---
<a id="4.5"></a>

### Correction 4.5 - Application mobile : Sessions actives

###### [Retour au sommaire](#sommaire)

**Contexte :** Un utilisateur ne peut avoir qu'**une seule session active** à la fois, mais peut avoir plusieurs sessions expirées dans l'historique.

**Solution :**

```sql
CREATE TABLE user_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    session_token CHAR(64) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    active BOOLEAN DEFAULT TRUE
);

-- Un seul session active par utilisateur
CREATE UNIQUE INDEX idx_unique_active_session 
ON user_sessions (user_id) 
WHERE active = TRUE AND expires_at > NOW();
```

**Workflow typique :**

```sql
-- Première connexion
INSERT INTO user_sessions (user_id, session_token, expires_at) VALUES 
(100, 'abc123...', NOW() + INTERVAL 7 DAY);

-- Connexion depuis un autre appareil
INSERT INTO user_sessions (user_id, session_token, expires_at) VALUES 
(100, 'def456...', NOW() + INTERVAL 7 DAY);
-- ❌ Erreur : session déjà active

-- Déconnexion manuelle (expire la session actuelle)
UPDATE user_sessions SET active = FALSE WHERE user_id = 100 AND active = TRUE;

-- Nouvelle connexion maintenant possible
INSERT INTO user_sessions (user_id, session_token, expires_at) VALUES 
(100, 'ghi789...', NOW() + INTERVAL 7 DAY);
-- ✅ Fonctionne !
```


---
<a id="4.6"></a>

### Correction 4.6 - Optimisation avec colonnes incluses

###### [Retour au sommaire](#sommaire)

**Contexte :** Table `utilisateurs` avec contrainte unique sur `email`, mais les requêtes récupèrent souvent aussi `nom` et `prenom`.

**Problème avec contrainte unique :**

```sql
-- Contrainte unique classique
ALTER TABLE utilisateurs ADD CONSTRAINT uk_email UNIQUE (email);

-- Cette requête nécessite un Key Lookup supplémentaire
SELECT nom, prenom, email FROM utilisateurs WHERE email = 'user@example.com';
-- Plan : Index Seek + Key Lookup (performance dégradée)
```

**Solution avec index unique et colonnes incluses :**

```sql
-- Suppression de la contrainte
ALTER TABLE utilisateurs DROP CONSTRAINT uk_email;

-- Index unique avec colonnes incluses (SQL Server/PostgreSQL)
CREATE UNIQUE INDEX idx_unique_email_with_names 
ON utilisateurs (email) 
INCLUDE (nom, prenom);
```

**Analyse de performance :**


| Approche | Plan d'exécution | Temps (1M utilisateurs) |
| :-- | :-- | :-- |
| **Contrainte unique** | Index Seek + Key Lookup | ~15 ms |
| **Index unique + INCLUDE** | Index Seek seul | ~2 ms |

**Exemple concret :**

```sql
-- Cette requête est maintenant "couverte" par l'index
SELECT nom, prenom, email 
FROM utilisateurs 
WHERE email = 'jean.dupont@email.com';
-- ✅ Toutes les données sont dans l'index, pas de lookup supplémentaire
```

**Limitation des contraintes :**

- **Pas de colonnes incluses** dans les contraintes UNIQUE
- **Index limité** aux colonnes de la contrainte uniquement
- **Performance sous-optimale** pour les requêtes complexes


## Synthèse - Quand choisir l'index unique

### ✅ Utiliser un index unique quand :

1. **Unicité conditionnelle** : "Unique seulement si..." (actif, publié, valide)
2. **Colonnes incluses nécessaires** : Optimiser des requêtes qui récupèrent plusieurs colonnes
3. **Index filtré/partiel** : Réduire la taille de l'index sur un sous-ensemble de données
4. **Flexibilité future** : Besoin d'options avancées non disponibles avec les contraintes

### ⚠️ Utiliser une contrainte unique quand :

1. **Règle métier simple** : Unicité absolue sans condition
2. **Référencement par clé étrangère** : Seules les contraintes peuvent être référencées
3. **Standard ANSI** : Maximum de portabilité entre SGBD
4. **Simplicité** : Pas besoin de fonctionnalités avancées

### 🎯 Règle pratique pour débutants :

**"Si vous hésitez, commencez par une contrainte UNIQUE. Si vous avez besoin de flexibilité (WHERE, INCLUDE), passez à un index unique."**




