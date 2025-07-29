# SQL - Index

## Objectif de la notion : Optimisation des requêtes, pour améliorer les temps de réponses de la base de données

### Introduction

Un index est un excellent moyen d'améliorer le temps de réponse d'une requête simple mais récurrente. Il permet, via une structure de données spécialisée, d'optimiser les performances même avec des milliers d'enregistrements par table.

#### Analogie

Un index, dans le domaine bibliographique, permet de lister les mots-clés importants abordés dans un ouvrage et d'indiquer les pages où le mot est mentionné. Ainsi, un lecteur qui recherche une thématique spécifique peut se baser sur cet index pour trouver rapidement les pages qui abordent le sujet. Un index n'est pas indispensable au fonctionnement, mais c'est un gain de temps considérable pour l'utilisateur qui accède facilement à l'information recherchée.

#### Définition technique

Les index sont des structures de données auxiliaires qui améliorent la vitesse de récupération des données en créant une table de correspondance triée entre les valeurs des colonnes indexées et leurs emplacements physiques dans la table, permettant à la base de données de localiser rapidement les lignes correspondantes sans parcourir l'ensemble de la table.

### Fonctionnement

**Mécanisme de base :** Sans index, le système doit lire la **table dans son intégralité**, ligne par ligne pour trouver les correspondances. Avec un index, il peut utiliser une structure optimisée pour la recherche (B-tree) et ne parcourir que quelques niveaux d'un arbre de recherche.

**Exemple :** Prenons la table `employees` avec des milliers d'enregistrements. La requête `SELECT * FROM employees WHERE nom='Dupont'` sans index nécessite un parcours complet de la table, tandis qu'avec un index sur la colonne `nom`, l'accès devient quasi-instantané.

### Types d'index

Vous en connaissez déjà deux sans le savoir : **Primary Key** et **Unique**. Les SGBD génèrent automatiquement en arrière-plan des index uniques représentant ces colonnes.

1. #### Index B-tree (par défaut)
- **Utilisation :** Requêtes d'égalité et par plages sur des données triables
- **Opérateurs supportés :** `<`, `<=`, `=`, `>=`, `>`, `BETWEEN`, `IN`
- **Cas d'usage :** Colonnes utilisées fréquemment dans les clauses WHERE, JOIN et ORDER BY
- **Complexité :** O(log n)
- **Quand l'utiliser :**
    - **Recherches par motifs :** Efficace pour les requêtes `LIKE 'préfixe%'` où le motif commence par une constante
    ```sql
    -- Efficace avec l'index B-tree
    SELECT * FROM clients WHERE nom LIKE 'Dupon%';

    -- Inefficace avec l'index B-tree  
    SELECT * FROM clients WHERE nom LIKE '%pont';
    ```
    - **Colonnes fréquemment utilisées** dans les clauses WHERE, JOIN et ORDER BY
    - **Tables volumineuses** avec plus de 1000 enregistrements
    - **Optimisation du tri :** Les index B-tree stockent les données dans un ordre trié naturel, permettant d'éviter un tri supplémentaire lors des requêtes ORDER BY sur la colonne indexée. La base de données peut directement lire les données dans l'ordre de l'index

- **Quand ne pas l'utiliser :**
    - Requêtes `LIKE '%suffixe'` ou `LIKE '%milieu%'` (wildcards en début de motif)
    - **Colonnes à faible cardinalité** avec très peu de valeurs distinctes
    - **Tables avec écritures très fréquentes** où le coût de maintenance dépasse les bénéfices
    - **Fonctions appliquées aux colonnes indexées :** `WHERE UPPER(nom) = 'DUPONT'`
    **Note :** Les index B-tree peuvent également être créés sur plusieurs colonnes simultanément (index composites), ce que nous verrons dans la section suivante.
    - **Syntaxe :** 
    ```sql
    CREATE INDEX idx_nom_de_l_index ON nom_de_table(colone_a_indexe);
    ```
**Exemple de performance :**

**Sans index :**

```sql
SELECT * FROM employees WHERE nom='Dupont'; 
```

*Temps : 2.5 secondes sur 100 000 enregistrements*

**Avec index :**

```sql
CREATE INDEX idx_nom ON employees(nom);
SELECT * FROM employees WHERE nom='Dupont';
```

*Temps : 0.003 secondes sur 100 000 enregistrements*

2. #### Index Hash
- **Analogie :** Imaginez les casiers d'une école, chaque élève a un numéro de casier unique. Au lieu de chercher dans tous casiers un par un, vous connaissez directement le numéro.
L'index hash est comme un système de **casiers numérotés** : il transforme la valeur recherchée en un "numéro de casier" (hash) qui indique exactement où se trouvent les données dans la base.
- **Définition technique :** Un index Hash utilise une fonction de hachage pour transformer les valeurs des colonnes indexée en codes de hachage de taille fixe. Ces codes servent d'adresses directes vers les emplacements des données, permettant un accès quasi-instantané pour les recherches d'égalité stricte.
- **Mécanisme de base :** 
    - Applique une fonction de hachage à chaque valeur de la colonne
    - Génère un code unique (hash) pour chaque valeur
    - Stocke ce code comme adresse directe vers la ligne correspondante
    - Lors d'une recherche, applique la même fonction à la valeur recherchée pour trouver instantanément l'emplacement
    - Exemple :
        ```sql
            -- Table clients avec 500 000 enregistrements
            SELECT * FROM clients WHERE email = 'jean.dupont@email.com';
        ```
        - **Sans index :** le tableau est parcouru ligne par ligne jusqu'à trouvé la bonne valeur
        - **Avec index hash :** Calcul le hash de la valeur recherché et accède directement à la bonne ligne.
- **Utilisation :** Uniquement pour les comparaisons d'égalité stricte (`=`)
- **Avantage :** Très rapide pour les recherches exactes (accès direct O(1))
- **Limitations :** Ne supporte aucune requête par plage (`<`, `>`, `BETWEEN`) ni tri (`ORDER BY`)
    - Les index Hash peuvent subir des dégradations de performance en cas de collisions fréquentes, particulièrement sur des données mal distribuées (même hash, valeur différente)
- **Syntaxe :** 
```sql
        -- Syntaxe générale
    CREATE INDEX nom_index ON table_nom USING HASH (colonne);

    -- Exemple concret PostgreSQL
    CREATE INDEX idx_hash_email ON clients USING HASH (email);
```
- **Complexité théorique :** O(1) - accès direct en temps constant
- **Performance réelle :** 10% à 22% plus rapide que B-tree pour les recherches d'égalité
- **Cas optimal :** Recherches exactes sur de grandes tables (millions d'enregistrements)
- **Quand l'utiliser :**
    - Recherches d'égalité uniquement : Requêtes avec l'opérateur = exclusivement
    - Colonnes avec identifiants uniques : Email, UUID, codes de référence, numéros de téléphone
    - Applications haute performance : Cache, gestion de sessions, authentification
    - Tables volumineuses : Plus de 100 000 enregistrements où l'accès direct fait la différence
    - Données de taille variable : Contrairement aux B-tree, les index Hash supportent des valeurs de taille arbitraire
- **Quand ne pas l'utiliser :**
    - Aucune requête de plage : Ne supportent pas <, >, BETWEEN, LIKE
    ```sql
        -- Inefficace avec index Hash
        SELECT * FROM clients WHERE age > 25;
        SELECT * FROM clients WHERE nom LIKE 'Dupon%';
    ```
    - Pas de tri : Ne peuvent pas être utilisés pour ORDER BY
    - Index mono-colonne : Pas de support pour les index composites
    - Gestion des collisions : Performance dégradée en cas de nombreuses collisions
        - *Parfois, deux valeurs différentes peuvent produire le même code de hachage (collision). C'est comme si deux élèves différents avaient le même numéro de casier ! Le système doit alors gérer cette situation, ce qui peut ralentir légèrement les performances.*
    - Compatibilité limitée : Support variable selon les SGBD et moteurs de stockage
        - PostgreSQL : Support complet depuis la version 10 avec crash-safety
        - MySQL : Principalement avec le moteur MEMORY
        - SQL Server : Pas de support natif des index Hash traditionnels

**Exemple de performance :**

**Sans index :**

```sql
SELECT * FROM users WHERE user_id = 123456;
```

*Temps : 1.2 secondes sur 1 000 000 enregistrements*

**Avec index (B-tree):**

```sql
CREATE INDEX idx_btree_user_id ON users (user_id);
SELECT * FROM users WHERE user_id = 123456;
```
*Temps : 0.008 secondes*
**Avec index (Hash):**

```sql
CREATE INDEX idx_hash_user_id ON users USING HASH (user_id);
SELECT * FROM users WHERE user_id = 123456;
```
*Temps : 0.006 secondes*

3. #### Index Unique
- **Analogie :** Imaginez le registre d'adhésion d'un club exclusif où **chaque membre doit avoir un numéro d'adhérent unique**. Le responsable vérifie systématiquement qu'aucun nouveau membre n'utilise un numéro déjà attribué. De plus, ce registre est organisé de manière à retrouver rapidement un membre par son numéro.
C'est exactement le rôle d'un index unique : **garantir qu'aucune valeur ne se répète tout en accélérant les recherches**. Il combine ainsi les fonctions de contrôle d'intégrité et d'optimisation des performances.


- **Définition technique :** Un index unique est une **structure de données spécialisée** qui garantit l'unicité des valeurs dans une ou plusieurs colonnes tout en optimisant les performances de recherche. Contrairement aux index ordinaires, l'index unique **refuse toute tentative d'insertion de valeurs dupliquées**, agissant comme un gardien de l'intégrité des données.


- **Syntaxe :**
    ```sql
    CREATE UNIQUE INDEX nom_index ON nom_table (colonne);
    ```

- **Exemples :**
    ```sql
    -- Index unique simple
    CREATE UNIQUE INDEX idx_unique_email ON utilisateurs (email);

    -- Index unique multi-colonnes
    CREATE UNIQUE INDEX idx_unique_nom_prenom ON clients (nom, prenom);
    ```


- **Quand l'utiliser**
    - **Colonnes d'identification métier** : Adresses email, numéros de téléphone, codes de référence
    - **Identifiants uniques** : Numéros de commande, références produits, tokens de session
    - **Contraintes métier** : Un seul directeur par département, combinaisons uniques de données
    - **Exemples d'usage optimal :**
    ```sql
    -- Authentification utilisateur
    CREATE UNIQUE INDEX idx_unique_email ON utilisateurs (email);

    -- Références de commandes e-commerce
    CREATE UNIQUE INDEX idx_unique_commande ON commandes (numero_commande);

    -- Identifiants de produits
    CREATE UNIQUE INDEX idx_unique_sku ON produits (sku);
    ```

- **Quand ne pas l'utiliser :**
    - **Colonnes avec doublons légitimes** : Noms de famille, villes de résidence
    - **Tables avec écritures très fréquentes** où le coût de vérification d'unicité impacte les performances
    - **Données temporaires** qui peuvent contenir des doublons temporaires


- **Avantages et inconvénients**
    - **Avantages :**
        - **Double fonction** : Intégrité des données + optimisation des performances
        - **Prévention des erreurs** : Impossible d'insérer des doublons accidentellement
        - **Performance en lecture** : Accès rapide comme les index B-tree standards
    - **Inconvénients :**
        - **Contrainte rigide** : Peut bloquer des imports de données contenant des doublons
        - **Performance en écriture** : Vérification d'unicité légèrement plus coûteuse
        - **Gestion des erreurs** : Nécessite une gestion d'exception dans le code applicatif


**Différence simple : Index Unique vs Contrainte Unique**

**Pour simplifier :**

- **Contrainte Unique** (`ALTER TABLE ... ADD CONSTRAINT UNIQUE`) :
- Exprime clairement une **règle métier** d'unicité
- Peut être référencée par des **clés étrangères**
- Crée automatiquement un index unique en arrière-plan

**Index Unique** (`CREATE UNIQUE INDEX`) :
- **Outil technique** d'optimisation
- Utilisé pour des cas spécifiques et des optimisations avancées
- Ne peut pas être référencé par des clés étrangères

**Conseil pratique :** Utilisez les **contraintes UNIQUE** pour définir vos règles métier, elles créeront automatiquement l'index unique nécessaire.

```sql
--  Approche recommandée
ALTER TABLE utilisateurs ADD CONSTRAINT uk_email UNIQUE (email);

--  Approche technique spécialisée
CREATE UNIQUE INDEX idx_unique_email ON utilisateurs (email);
```


**Exemple de performance**
**Recherche dans une table de 500 000 utilisateurs :**
- **Sans index :**

```sql
SELECT * FROM utilisateurs WHERE email = 'user@exemple.com';
```

*Temps : 0.8 secondes (scan complet de table)*

- **Avec index unique :**

```sql
CREATE UNIQUE INDEX idx_unique_email ON utilisateurs (email);
SELECT * FROM utilisateurs WHERE email = 'user@exemple.com';
```

*Temps : 0.004 secondes + garantie d'unicité*