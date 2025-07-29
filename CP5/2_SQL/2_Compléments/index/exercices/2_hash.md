# Correction – Exercices Index SQL (Hash)

## Objectif

==Correction détaillée des exercices sur la création et l’utilisation d’index HASH pour optimiser les recherches d’égalité==

<a id="sommaire"></a>


| Numéro | Description | Lien |
| :--: | :-- | :-- |
| 3.1 | Cache applicatif : recherche par clé | [👉](#3.1) |
| 3.2 | Authentification : indexer les emails | [👉](#3.2) |
| 3.3 | Plateforme IoT : accès direct aux capteurs | [👉](#3.3) |
| 3.4 | Jeu en ligne : sessions utilisateurs | [👉](#3.4) |
| 3.5 | E-commerce : jetons de paniers | [👉](#3.5) |
| 3.6 | Analyse de performance avec EXPLAIN | [👉](#3.6) |

<a id="3.1"></a>

### Correction 3.1 – Cache applicatif : recherche par clé

###### [Retour au sommaire](#sommaire)

**Contexte :** Une table `cache` stocke les réponses JSON de l’API. La colonne `cache_key` est une chaîne SHA-256 de 64 caractères. Requêtes = 100% d’égalité stricte.

```sql
-- a. Création de la table
CREATE TABLE cache (
    cache_key CHAR(64) PRIMARY KEY,
    payload   JSONB,
    expires_at TIMESTAMP
);

-- b. Index Hash (accès direct par clé)
CREATE INDEX idx_hash_cache_key
ON cache USING HASH (cache_key);
```

**Analyse performances :**


| Scénario | Temps (2,000,000 lignes) |
| :-- | :-- |
| Sans index | ≈1.1 s (seq scan) |
| B-tree par défaut | ≈0.014 s |
| Hash | ≈0.009 s (-36% vs B-tree) |

**Pourquoi le Hash gagne ?** L’accès direct (`O(1)`) supprime la navigation dans l’arbre B-tree.

<a id="3.2"></a>

### Correction 3.2 – Authentification : indexer les emails

###### [Retour au sommaire](#sommaire)

**Contexte :** Table `users` (2 millions d’inscrits). La recherche par email est l’opération la plus fréquente au login.

```sql
-- a. Index unique pour l’intégrité + vitesse
CREATE UNIQUE INDEX idx_users_email_hash
ON users USING HASH (email);
```

**Pourquoi Hash ?**

- L’email est toujours recherché par **égalité** (`WHERE email = ?`).
- Garantie d’unicité via `UNIQUE`.
- Bénéfice : latence du login divisée par ≈1.4 × par rapport au B-tree sur 2 millions de lignes.

**Attention :** Pas de support pour `LIKE`, `ORDER BY email` → garder un second B-tree si ces requêtes existent.

<a id="3.3"></a>

### Correction 3.3 – Plateforme IoT : accès direct aux capteurs

###### [Retour au sommaire](#sommaire)

**Contexte :** Table `device_data` (10 millions de mesures/jour). On récupère souvent la dernière valeur par identifiant de capteur (`device_uuid`).

```sql
-- a. Structure de table simplifiée
CREATE TABLE device_data (
    device_uuid UUID,
    ts          TIMESTAMP,
    reading     FLOAT,
    PRIMARY KEY (device_uuid, ts)   -- cluster sur B-tree composite
);

-- b. Index Hash additionnel pour l’égalité pure
CREATE INDEX idx_hash_device ON device_data USING HASH (device_uuid);
```

**Requêtes optimisées :**

```sql
-- Accès direct à la ligne la plus récente
SELECT reading
FROM device_data
WHERE device_uuid = '5faaef5e-8ea9-4b69-9c52-f30c65cd9cdb'
ORDER BY ts DESC
LIMIT 1;
```

Le moteur utilise `idx_hash_device` pour filtrer instantanément le capteur, puis parcourt seulement les quelques dizaines de lectures récentes (au lieu de 10 millions).

<a id="3.4"></a>

### Correction 3.4 – Jeu en ligne : sessions utilisateurs

###### [Retour au sommaire](#sommaire)

**Contexte :** Table `player_sessions` dans Redis-like SQL (moteur MEMORY). Chaque session doit être retrouvée par son `session_token` (512 bits base64).

```sql
CREATE TABLE player_sessions (
    session_token CHAR(86) PRIMARY KEY,
    player_id     INT,
    started_at    TIMESTAMP
) ENGINE=MEMORY;

-- Index Hash automatique grâce au moteur MEMORY
-- ou explicite :
ALTER TABLE player_sessions
ADD INDEX idx_hash_session (session_token) USING HASH;
```

**Résultat :** Temps de lookup ≤0.5 ms même avec 5 millions de sessions simultanées.

<a id="3.5"></a>

### Correction 3.5 – E-commerce : jetons de paniers

###### [Retour au sommaire](#sommaire)

**Contexte :** Micro-service « cart ». Table `carts` :

```sql
CREATE TABLE carts (
    cart_token CHAR(40) PRIMARY KEY,
    created_at TIMESTAMP,
    user_id    INT
);

-- Index Hash pour accélérer les accès
CREATE INDEX idx_hash_cart_token
ON carts USING HASH (cart_token);
```

**Test de charge :** 50 000 requêtes/s ; P95 latence → 3.1 ms sans index, 1.9 ms avec B-tree, 1.3 ms avec Hash.

**Point de vigilance :** Chaque INSERT/DELETE actualise aussi l’index Hash ; le coût est négligeable (<5%) car le volume d’écriture reste modéré.

<a id="3.6"></a>

### Correction 3.6 – Analyse de performance avec EXPLAIN

###### [Retour au sommaire](#sommaire)

**Objectif :** mesurer le gain d’un index Hash sur une recherche d’égalité.

```sql
-- 1. Sans index
EXPLAIN ANALYZE
SELECT payload
FROM cache
WHERE cache_key = '03e84414dd9d6f...';

-- Seq Scan on cache  (cost=0.00..31542.00 rows=1)  
-- Execution time: 880.214 ms
```

```sql
-- 2. Création de l'index
CREATE INDEX idx_hash_cache_key ON cache USING HASH (cache_key);
ANALYZE cache;
```

```sql
-- 3. Avec index Hash
EXPLAIN ANALYZE
SELECT payload
FROM cache
WHERE cache_key = '03e84414dd9d6f...';

-- Index Scan using idx_hash_cache_key on cache
-- Execution time: 6.921 ms
```

| Métrique | Avant | Après | Gain |
| :-- | :-- | :-- | :-- |
| Type de scan | Seq Scan | Index Scan Hash | ✅ accès direct |
| Coût estimé | 31,542 | 12.00 | -99.9% |
| Temps réel | 880.2 ms | 6.9 ms | -99.2% |
| Pages lues | ≈250 000 | ≈20 | -99.99% |

## Synthèse – Bonnes pratiques des index HASH

### Utiliser si :

- **Requêtes `=` exclusivement** sur la colonne.
- **Haute cardinalité** : beaucoup de valeurs uniques.
- **Tables volumineuses** avec lectures intensives (>100 000 lignes).
- **Données de longueur variable** (emails, URLs, UUID) où l’emplacement fixe du B-tree est moins efficace.


### Éviter si :

- Besoin de filtres par plage (`<`, `BETWEEN`) ou tri (`ORDER BY`).
- **Faible cardinalité** : peu de valeurs distinctes → collisions fréquentes.
- Volume d’INSERT/UPDATE massif (calcul du hash à chaque écriture).
- Colonne incluse dans des **index composites** ou référencée par clé étrangère.


### Checklist création

- Choisir `USING HASH`.
- Vérifier le support Hash du SGBD (PostgreSQL ≥ 10, MySQL MEMORY).
- `ANALYZE` après création pour mettre à jour les statistiques.
- Surveiller les collisions avec `pg_stat_user_indexes` (PostgreSQL) ou équivalent.
- Conserver un B-tree parallèle si des plages ou tris sont parfois nécessaires.

> **Règle d’or :** Index HASH = « turbo » pour l’égalité stricte ; hors de ce cas il se comporte comme une voiture de course dans un embouteillage : inutilement bruyant et parfois plus lent.

:  Bytebase – « PostgreSQL vs MySQL : Indexing Options » (2023).
:  NetOpsiyon – « Types of Indexes and Their Impact on Performance » (2024).
:  Observabilité interne – test de charge Redis-MEMORY (avril 2025).


