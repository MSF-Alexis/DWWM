<img src="https://r2cdn.perplexity.ai/pplx-full-logo-primary-dark%402x.png" class="logo" width="120"/>

# Correction - Exercices Index SQL (B-tree)

## Objectif

==Correction détaillée des exercices sur la création et l'utilisation d'index B-tree pour l'optimisation des performances==

<a id="sommaire"></a>


| Numéro | Description | Lien |
| :--: | :-- | :-- |
| 2.1 | E-commerce : Optimisation des recherches produits | [👉](#2.1) |
| 2.2 | Système RH : Index sur les employés | [👉](#2.2) |
| 2.3 | Bibliothèque numérique : Recherche d'ouvrages | [👉](#2.3) |
| 2.4 | Plateforme de streaming : Optimisation des films | [👉](#2.4) |
| 2.5 | Réseau social : Index sur les publications | [👉](#2.5) |
| 2.6 | Analyse de performance avec EXPLAIN | [👉](#2.6) |

<a id="2.1"></a>

### Correction 2.1 - E-commerce : Optimisation des recherches produits

###### [Retour au sommaire](#sommaire)

**Contexte :** Boutique en ligne avec 100 000 produits. Les clients recherchent principalement par nom de produit et catégorie.

**Solution :**

```sql
-- a. Index sur le nom de produit (recherches fréquentes)
CREATE INDEX idx_nom_produit ON produits(nom);

-- b. Index sur la catégorie (filtrage courant)
CREATE INDEX idx_categorie ON produits(categorie_id);

-- c. Index composite pour recherches combinées
CREATE INDEX idx_nom_categorie ON produits(nom, categorie_id);
```

**Analyse des performances :**

**Sans index :**

```sql
SELECT * FROM produits WHERE nom LIKE 'iPhone%';
```

*Temps estimé : 3.2 secondes (full table scan)*

**Avec index :**

```sql
-- L'index idx_nom_produit est utilisé automatiquement
SELECT * FROM produits WHERE nom LIKE 'iPhone%';
```

*Temps estimé : 0.008 secondes*

**Justification :**

- **nom** : Colonne à haute cardinalité, recherches fréquentes avec `LIKE 'préfixe%'`
- **categorie_id** : Colonne de filtrage courante, améliore les jointures
- **Index composite** : Optimise les requêtes utilisant les deux colonnes simultanément

---
<a id="2.2"></a>

### Correction 2.2 - Système RH : Index sur les employés

###### [Retour au sommaire](#sommaire)

**Contexte :** Base RH avec 50 000 employés. Recherches fréquentes par email, département et date d'embauche.

**Solution :**

```sql
-- a. Index unique sur l'email (authentification)
CREATE UNIQUE INDEX idx_unique_email ON employes(email);

-- b. Index sur le département (rapports RH)
CREATE INDEX idx_departement ON employes(departement_id);

-- c. Index sur la date d'embauche (requêtes par période)
CREATE INDEX idx_date_embauche ON employes(date_embauche);

-- d. Index composite pour rapports détaillés
CREATE INDEX idx_dept_date ON employes(departement_id, date_embauche);
```

**Cas d'usage optimisé :**

```sql
-- Authentification utilisateur (utilise idx_unique_email)
SELECT id, nom, prenom FROM employes WHERE email = 'john.doe@entreprise.com';

-- Employés embauchés cette année (utilise idx_date_embauche)
SELECT COUNT(*) FROM employes 
WHERE date_embauche >= '2024-01-01' AND date_embauche < '2025-01-01';

-- Rapport par département et période (utilise idx_dept_date)
SELECT COUNT(*) FROM employes 
WHERE departement_id = 5 AND date_embauche >= '2024-01-01';
```

**Analyse critique :**

- **email unique** : Double fonction (intégrité + performance)
- **departement_id** : Clé étrangère fréquemment utilisée dans les jointures
- **Index composite** : L'ordre `(departement_id, date_embauche)` est optimal car les requêtes filtrent généralement d'abord par département

---
<a id="2.3"></a>

### Correction 2.3 - Bibliothèque numérique : Recherche d'ouvrages

###### [Retour au sommaire](#sommaire)

**Contexte :** Catalogue de 200 000 livres avec recherches par titre, auteur et ISBN.

**Solution :**

```sql
-- a. Index sur le titre (recherches partielles fréquentes)
CREATE INDEX idx_titre ON livres(titre);

-- b. Index unique sur l'ISBN (identifiant métier)
CREATE UNIQUE INDEX idx_unique_isbn ON livres(isbn);

-- c. Index sur l'auteur (recherches d'œuvres)
CREATE INDEX idx_auteur ON livres(auteur);

-- d. Index composite titre-auteur pour recherches précises
CREATE INDEX idx_titre_auteur ON livres(titre, auteur);
```

**Exemples d'optimisation :**

```sql
-- Recherche par ISBN (accès direct via idx_unique_isbn)
SELECT * FROM livres WHERE isbn = '978-2-1234-5678-9';
-- Temps : ~0.001 seconde

-- Recherche par début de titre (utilise idx_titre)
SELECT titre, auteur FROM livres WHERE titre LIKE 'Les Misér%';
-- Temps : ~0.005 secondes

-- Recherche combinée (utilise idx_titre_auteur)
SELECT * FROM livres 
WHERE titre LIKE 'Le%' AND auteur = 'Victor Hugo';
-- Temps : ~0.003 secondes
```

**Cas d'échec d'index :**

```sql
-- ❌ Ne peut pas utiliser l'index sur titre
SELECT * FROM livres WHERE titre LIKE '%Amour%';
-- Raison : Wildcard en début de motif

-- ✅ Alternative optimisée avec index full-text (hors scope B-tree)
-- Pour ce cas, il faudrait un index spécialisé
```


---
<a id="2.4"></a>

### Correction 2.4 - Plateforme de streaming : Optimisation des films

###### [Retour au sommaire](#sommaire)

**Contexte :** Base de données de streaming avec 1 million de contenus et historiques de visionnage.

**Solution :**

```sql
-- a. Index sur le genre (navigation par catégorie)
CREATE INDEX idx_genre ON films(genre);

-- b. Index sur l'année de sortie (filtres temporels)
CREATE INDEX idx_annee_sortie ON films(annee_sortie);

-- c. Index sur la note moyenne (classements)
CREATE INDEX idx_note_moyenne ON films(note_moyenne);

-- d. Index composite pour recommandations
CREATE INDEX idx_genre_note ON films(genre, note_moyenne DESC);

-- e. Index sur l'historique de visionnage
CREATE INDEX idx_user_date ON historique_visionnage(user_id, date_visionnage);
```

**Requêtes optimisées :**

```sql
-- Top films d'un genre (utilise idx_genre_note)
SELECT titre, note_moyenne 
FROM films 
WHERE genre = 'Action' 
ORDER BY note_moyenne DESC 
LIMIT 10;

-- Films récents bien notés (utilise idx_annee_sortie)
SELECT titre, annee_sortie, note_moyenne 
FROM films 
WHERE annee_sortie >= 2020 AND note_moyenne >= 8.0
ORDER BY note_moyenne DESC;

-- Historique utilisateur (utilise idx_user_date)
SELECT f.titre, hv.date_visionnage 
FROM historique_visionnage hv
JOIN films f ON hv.film_id = f.id
WHERE hv.user_id = 12345 
ORDER BY hv.date_visionnage DESC;
```

**Analyse de l'index composite :**

- **Ordre DESC sur note_moyenne** : Optimise les tri décroissants fréquents
- **Genre en premier** : Les filtres par genre sont plus sélectifs que les notes

---
<a id="2.5"></a>

### Correction 2.5 - Réseau social : Index sur les publications

###### [Retour au sommaire](#sommaire)

**Contexte :** Réseau social avec 10 millions de publications et timeline en temps réel.

**Solution :**

```sql
-- a. Index sur l'utilisateur et date (timeline personnelle)
CREATE INDEX idx_user_date ON publications(user_id, date_publication DESC);

-- b. Index sur le contenu pour recherche textuelle
CREATE INDEX idx_contenu ON publications(contenu);

-- c. Index sur les hashtags (recherche par thème)
CREATE INDEX idx_hashtags ON publications(hashtags);

-- d. Index composite pour feed public
CREATE INDEX idx_date_likes ON publications(date_publication DESC, nombre_likes DESC);
```

**Requêtes typiques optimisées :**

```sql
-- Timeline utilisateur (utilise idx_user_date)
SELECT contenu, date_publication, nombre_likes 
FROM publications 
WHERE user_id = 567 
ORDER BY date_publication DESC 
LIMIT 50;

-- Publications récentes populaires (utilise idx_date_likes)
SELECT contenu, nombre_likes 
FROM publications 
WHERE date_publication >= CURRENT_DATE - INTERVAL '7 days'
ORDER BY date_publication DESC, nombre_likes DESC 
LIMIT 100;

-- Recherche par hashtag (utilise idx_hashtags)
SELECT contenu, user_id, date_publication 
FROM publications 
WHERE hashtags LIKE '%#sql%'
ORDER BY date_publication DESC;
```

**Optimisation spéciale timeline :**

```sql
-- Index partiel pour publications récentes (économie d'espace)
CREATE INDEX idx_recent_publications 
ON publications(date_publication DESC, nombre_likes DESC)
WHERE date_publication >= CURRENT_DATE - INTERVAL '30 days';
```


---
<a id="2.6"></a>

### Correction 2.6 - Analyse de performance avec EXPLAIN

###### [Retour au sommaire](#sommaire)

**Objectif :** Analyser l'impact des index sur les plans d'exécution.

**Exercice pratique :**

```sql
-- 1. Analyse AVANT création d'index
EXPLAIN ANALYZE 
SELECT nom, email FROM employes 
WHERE departement_id = 5;

-- Résultat attendu :
-- Seq Scan on employes (cost=0.00..1234.56 rows=150 width=64)
-- Filter: (departement_id = 5)
-- Execution time: 45.123 ms
```

```sql
-- 2. Création de l'index
CREATE INDEX idx_departement ON employes(departement_id);

-- 3. Mise à jour des statistiques (important !)
ANALYZE employes;

-- 4. Analyse APRÈS création d'index
EXPLAIN ANALYZE 
SELECT nom, email FROM employes 
WHERE departement_id = 5;

-- Résultat attendu :
-- Index Scan using idx_departement on employes (cost=0.42..8.67 rows=150 width=64)
-- Index Cond: (departement_id = 5)
-- Execution time: 2.456 ms
```

**Interprétation des résultats :**


| Métrique | Avant Index | Avec Index | Amélioration |
| :-- | :-- | :-- | :-- |
| **Type de scan** | Sequential Scan | Index Scan | ✅ Accès direct |
| **Coût estimé** | 1234.56 | 8.67 | **99.3%** de réduction |
| **Temps réel** | 45.123 ms | 2.456 ms | **94.6%** plus rapide |
| **Lignes lues** | ~50 000 (toute la table) | ~150 (filtrées) | **99.7%** moins de lectures |

**Exercice avancé - Index composite :**

```sql
-- Requête complexe pour test d'index composite
EXPLAIN ANALYZE 
SELECT nom, salaire 
FROM employes 
WHERE departement_id = 5 AND salaire > 50000
ORDER BY salaire DESC;

-- Création d'index composite optimisé
CREATE INDEX idx_dept_salaire ON employes(departement_id, salaire DESC);

-- Analyse après optimisation
-- Index Scan using idx_dept_salaire on employes
-- Index Cond: ((departement_id = 5) AND (salaire > 50000))
-- Execution time: 1.234 ms (vs 78.456 ms sans index)
```


## Synthèse - Bonnes pratiques des index B-tree

### Règles de création d'index

1. **Colonnes candidates prioritaires** :
    - Colonnes de clauses WHERE fréquentes
    - Clés étrangères utilisées dans les jointures
    - Colonnes de ORDER BY répétées
    - Identifiants métier uniques (email, référence)
2. **Quand éviter les index** :
    - Colonnes rarement interrogées
    - Tables avec beaucoup d'écritures (INSERT/UPDATE)
    - Colonnes à très faible cardinalité (boolean, statut)
    - Petites tables (< 1000 lignes)
3. **Optimisation des index composites** :
    - Ordre des colonnes : **plus sélective → moins sélective**
    - Considérer les requêtes les plus fréquentes
    - L'index `(A, B)` optimise `WHERE A = x` et `WHERE A = x AND B = y`
    - Mais **pas** `WHERE B = y` seul

### Surveillance et maintenance

| Outil | Usage | Commande exemple |
| :-- | :-- | :-- |
| **EXPLAIN** | Plan d'exécution théorique | `EXPLAIN SELECT ...` |
| **EXPLAIN ANALYZE** | Plan + temps réel | `EXPLAIN ANALYZE SELECT ...` |
| **Statistiques table** | Mise à jour métadonnées | `ANALYZE table_name;` |
| **Taille index** | Surveillance espace disque | `SELECT pg_size_pretty(pg_indexes_size('table'));` |



