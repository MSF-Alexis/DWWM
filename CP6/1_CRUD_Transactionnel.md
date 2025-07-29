# Support de Cours – CRUD Transactionnel SQL (BC02.2, Point 1)

**Contexte professionnel**
Dans de nombreuses architectures microservices, chaque service doit garantir l’intégrité des données en accédant à une base unique. Par exemple, un microservice de prise de commande pour un restaurant interagit de façon transactionnelle avec la base de données pour sécuriser à la fois la prise de commandes et la mise à jour du stock, tout en restant découplé des autres microservices.

**Objectifs SMART de ce module**
À l’issue de ce module, l’apprenant sera capable de :

1. Implémenter un DAO MySQL complet (Create, Read, Update, Delete) en Node.js.
2. Gérer manuellement les transactions SQL (`BEGIN`/`COMMIT`/`ROLLBACK`) pour assurer l’atomicité et la cohérence des opérations.
3. Mettre en œuvre des tests unitaires (Jest) couvrant ≥ 90% du code DAO, y compris la gestion des cas d’erreur et de rollback.

**Tags** : SQL · Node.js · Tests unitaires · BC02.2

## Sommaire détaillé

1. **Introduction et mise en situation**
1.1. Contexte microservices et besoin d’accès transactionnel
1.2. Présentation du DAO (Data Access Object) et rôle dans l’architecture
2. **Fondamentaux des transactions SQL**
2.1. Les propriétés ACID
2.2. Niveaux d’isolation et implications
2.3. Syntaxe SQL : `BEGIN` / `COMMIT` / `ROLLBACK`
3. **Implémentation d’un DAO MariaDB en Node.js**
3.1. Configuration de la connexion avec `mariadb`
3.2. Structure du DAO : méthodes CRUD
3.3. Gestion manuelle des transactions
  3.3.1. Transaction simple pour une opération unique
  3.3.2. Transaction complexe englobant plusieurs requêtes
3.4. Bonnes pratiques TDD et Clean Code
4. **Exemples commentés et diagrammes**
4.1. Snippets Node.js pour chaque méthode CRUD
4.2. Diagramme de séquence du cycle transactionnel
4.3. Cas d’erreur et scénario de rollback
5. **Exercices guidés**
5.1. Exercice 1 – Implémenter `createUser()` et tester le commit
5.2. Exercice 2 – Simuler une erreur pour tester le rollback
5.3. Exercice 3 – Enchaîner deux opérations transactionnelles et valider l’atomicité
6. **Tests unitaires avec Jest**
6.1. Installation et configuration de Jest
6.2. Rédaction de tests pour chaque méthode CRUD
6.3. Tests de gestion d’erreur et couverture ≥ 90%
7. **Résumé et quiz rapide**
7.1. Points clés à retenir
7.2. QCM sur ACID, isolation et rollback
8. **Ressources complémentaires**
8.1. Documentation officielle PostgreSQL
8.2. Guide du package `pg`
8.3. Tutoriels Jest et exemples de tests


## 1.1 Contexte microservices et besoin d’accès transactionnel

### Pourquoi l’accès transactionnel est-il crucial ?

**Sécuriser l’intégrité des données :**
Lorsqu’un microservice réalise plusieurs opérations sur la base (par exemple, enregistrer une commande ET mettre à jour le stock), il est essentiel que ces opérations soient atomiques. Cela signifie que toutes les opérations d’un groupe doivent réussir ou, en cas d’échec, aucune ne doit être validée (principe de la transaction).

**Exemple concret professionnel :**
Dans un restaurant, le service « commandes » doit pouvoir enregistrer une nouvelle commande et décrémenter le stock des ingrédients en une seule transaction. Si une étape échoue (ingrédient introuvable, erreur réseau), il faut impérativement que l’ensemble de la séquence soit annulé pour éviter toute incohérence (ex. commande enregistrée sans retrait du stock).

**Protéger contre les erreurs métier et techniques :**
Les transactions permettent de protéger la base contre les cas d’usage où :

Plusieurs utilisateurs modifient les mêmes données en même temps (problématique de concurrence)

Une opération échoue au milieu de la chaîne (ex : arrêt serveur, coupure réseau)

Des vulnérabilités potentielles pourraient conduire à des états de base contradictoires

## 1.2 Présentation du DAO (Data Access Object) et rôle dans l’architecture
Le DAO (Data Access Object) est un patron de conception (design pattern) incontournable pour structurer proprement la gestion des accès aux données dans une application. Concrètement, il s’agit d’une couche logicielle intermédiaire responsable de l’encapsulation de toutes les opérations CRUD (Create, Read, Update, Delete) sur la base de données.

**Rôle principal :**
Fournir une interface homogène et sécurisée entre l’application métier (services, contrôleurs, routes API) et la base de données, tout en masquant la complexité des requêtes SQL et la gestion des connexions.

**Pourquoi ce pattern ?**

Séparer clairement la logique métier (ce que fait l’application) de la logique d’accès aux données (comment on lit/écrit les données)

Faciliter les tests unitaires et l’évolution de l’architecture (ex : changement de base de données ou de SGBD)

Renforcer la sécurité et la robustesse du code (prévention des injections, gestion centralisée des transactions et des erreurs)


### Positionnement du DAO dans l’architecture microservices

Dans une application Node.js structurée en microservices, le DAO occupe un rôle fondamental :

1. Isolation des responsabilités :
    - Les contrôleurs (ou services métier) n’interagissent jamais directement avec la base de données, mais passent par le DAO.
    - Cela favorise la réutilisabilité du code et limite la duplication des requêtes.
2. Gestion centralisée des transactions :
    - Le DAO orchestre le démarrage (BEGIN), la validation (COMMIT) ou le rollback (ROLLBACK) des transactions.
    - Cela garantit l’atomicité des opérations, même lorsque plusieurs services métiers utilisent la même base.
3. Compatibilité multi-bases et évolutivité :
    - Si une migration de SGBD (ex : de MariaDB à PostgreSQL) intervient, il suffit de modifier le DAO sans toucher à la logique métier.
4. Facilitation des tests et de la maintenance :
    - Les tests unitaires peuvent viser le DAO de façon isolée, en simulant la base avec des mocks ou des bases de tests dédiées.


## 2.1 Les propriétés ACID

Dans toute transaction SQL, les quatre propriétés ACID garantissent la fiabilité et la cohérence des données.

**Atomicité**
Chaque transaction est traitée comme une unité indivisible : soit toutes ses opérations aboutissent, soit aucune n’est appliquée. En cas d’erreur ou d’exception, un ROLLBACK annule l’ensemble des modifications effectuées pendant la transaction, évitant ainsi tout état intermédiaire incohérent.

**Cohérence (Consistency)**
La base de données passe d’un état valide à un autre état valide. Toute transaction doit respecter les contraintes d’intégrité (clés primaires, clés étrangères, contraintes de unicité, règles métier). Si une opération viole une contrainte, la transaction est rejetée et la cohérence est préservée via rollback.

**Isolation**
Les transactions concurrentes s’exécutent sans interférer entre elles. Les niveaux d’isolation (READ UNCOMMITTED, READ COMMITTED, REPEATABLE READ, SERIALIZABLE) définissent le degré de visibilité des modifications non validées par les autres transactions, évitant ainsi phénomènes indésirables :
- Dirty reads (lecture de données non validées)
- Non-repeatable reads (données modifiées par une autre transaction entre deux lectures)
- Phantom reads (nouvelles lignes insérées par une autre transaction)

**Durabilité (Durability)**
Une fois qu’une transaction est validée (COMMIT), ses modifications sont enregistrées de manière permanente. Même en cas de panne système ou de coupure de courant, les données validées sont récupérables à partir des journaux de transactions ou des fichiers de log.

## 2.2 Niveaux d’isolation et implications

Dans un contexte transactionnel, le niveau d’isolation détermine la visibilité des modifications non validées par d’autres transactions et la protection contre certains phénomènes indésirables. MariaDB/MySQL propose quatre niveaux standard :
1. READ UNCOMMITTED
    - Description : Une transaction peut lire des données non validées émises par une autre transaction (dirty reads).
    - Avantages : Très haute concurrence, latence minimale.
    - Inconvénients : Risque de lire des données qui seront annulées, cohérence non garantie.
    - Usage : Scénarios non critiques où la performance prime sur la cohérence stricte (ex. statistiques, logs).
2. READ COMMITTED
    - Description : Une transaction ne voit que les modifications validées par d’autres transactions. Les lectures sales sont évitées, mais elle peut subir des non-repeatable reads (données modifiées entre deux lectures).
    - Avantages : Bon compromis entre cohérence et performance.
    - Inconvénients : Impossible de garantir qu’une même requête lue deux fois retourne le même résultat si une autre transaction a validé entre-temps.
    - Usage : Applications OLTP classiques où l’on veut éviter les dirty reads sans trop pénaliser la concurrence.
3. REPEATABLE READ (niveau par défaut en MySQL/MariaDB)
    - Description : Toutes les lectures dans une transaction renvoient toujours l’état de la base tel qu’il existait au début de la transaction. Évite dirty reads et non-repeatable reads.
    - Avantages : Lecture cohérente tout au long de la transaction.
    - Inconvénients : Peut subir des phantom reads : insertion de nouvelles lignes correspondant à la même condition entre deux lectures.
    - Usage : Transactions de lecture/écriture courantes où la cohérence est prioritaire sans blocage excessif.
4. SERIALIZABLE
    - Description : Le niveau le plus strict : chaque transaction s’exécute comme si elle était seule dans la base. MySQL/- MariaDB met en œuvre cet isolement via des verrous de lecture (gap locks) pour empêcher dirty, non-repeatable et phantom reads.
    - Avantages : Cohérence totale, reproduit un ordre séquentiel d’exécution des transactions.
    - Inconvénients : Très forte contention, risque de blocages et de délais d’attente élevés.
    - Usage : Opérations critiques nécessitant une intégrité absolue (ex. transfert de fonds, clôture de bilan).
Implications pratiques pour votre DAO transactionnel
- Choisir REPEATABLE READ par défaut permet de garantir la cohérence interne de votre DAO sans sacrifier la concurrence.
- Pour des opérations très sensibles (par exemple, transferts inter-comptes), passer à SERIALIZABLE pour sécuriser l’atomicité totale au coût d’une latence accrue.
- Éviter READ UNCOMMITTED dans les microservices métier où l’exactitude des données est primordiale.
- Utiliser READ COMMITTED si votre application effectue de nombreuses lectures simples et peut tolérer une éventuelle divergence temporaire.

## 2.3 Syntaxe SQL : BEGIN / COMMIT / ROLLBACK

La gestion manuelle des transactions en SQL repose sur trois commandes essentielles qui permettent de contrôler précisément le cycle de vie des opérations sur la base de données. Ces commandes garantissent l'intégrité des données en regroupant plusieurs requêtes en une seule unité atomique.
Démarrage d'une transaction : BEGIN

**Syntaxe :**

```sql
BEGIN;
-- ou alternativement
START TRANSACTION;
```

La commande BEGIN (ou START TRANSACTION) marque le début d'une transaction explicite. À partir de ce point, toutes les modifications apportées à la base de données sont temporaires et réversibles jusqu'à ce qu'elles soient explicitement validées ou annulées.

**Comportement :**
- Toutes les requêtes SQL suivantes (INSERT, UPDATE, DELETE) sont mise en attente
- Les modifications ne sont visibles que dans la session courante
- D'autres sessions ne voient pas les changements tant que la transaction n'est pas validée
- La base de données maintient un journal des modifications pour permettre un rollback si nécessaire

### Validation d'une transaction : **COMMIT**

Syntaxe :

```sql
COMMIT;
```
La commande **COMMIT** rend permanentes toutes les modifications effectuées depuis le début de la transaction.

**Comportement :**
- Les modifications deviennent définitives et visibles pour tous les utilisateurs
- Les verrous placés sur les données sont libérés
- L'espace utilisé pour le journal de transaction est libéré
- Il n'est plus possible d'annuler les modifications après un COMMIT

### Annulation d'une transaction : **ROLLBACK**

**Syntaxe :**

```sql
ROLLBACK;
```
La commande **ROLLBACK** annule toutes les modifications effectuées depuis le début de la transaction, restaurant la base de données dans son état initial.

**Comportement :**
- Toutes les modifications (INSERT, UPDATE, DELETE) sont annulées
- Les verrous placés sur les données sont libérés
- La base de données revient exactement à l'état précédent le BEGIN
- Aucune trace des modifications tentées ne subsiste

### Exemple pratique complet

```sql
-- Démarrage de la transaction
BEGIN;

-- Tentative d'insertion d'un nouvel utilisateur
INSERT INTO users (name, email) VALUES ('Jean Dupont', 'jean.dupont@example.com');

-- Tentative de mise à jour du stock
UPDATE products SET stock = stock - 1 WHERE id = 5;

-- Vérification des conditions métier
-- Si tout est correct :
COMMIT;

-- Si une erreur est détectée :
-- ROLLBACK;
```

### Gestion automatique des transactions

En cas de :
- Erreur SQL : MariaDB/MySQL déclenche automatiquement un ROLLBACK
- Perte de connexion : La transaction est automatiquement annulée
- Fermeture inattendue : Le serveur effectue un ROLLBACK au redémarrage

Pour la suite du support nous allons sur le fichier **Implémentation_DAO_MariaDB_Node_js.md**
