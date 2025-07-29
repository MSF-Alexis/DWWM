## 2 – Types de sauvegardes sous MariaDB : logique vs physique, complète vs partielle

### Objectifs pédagogiques

- Distinguer les différents types de sauvegardes existants dans MariaDB.
- Comprendre les avantages et limites de chaque approche.
- Savoir choisir le type de sauvegarde adapté à un contexte donné.


### 1. Les grandes familles de sauvegardes

#### **A. Sauvegarde logique**

- **Définition** : Exportation des données et de la structure de la base sous forme de scripts SQL.
- **Utilitaires courants** : `mariadb-dump`, `mysqldump`.
- **Caractéristiques** :
    - Lisible et modifiable (fichiers texte).
    - Portable entre versions et serveurs MariaDB/MySQL.
    - Permet la restauration sélective (table, schéma, etc.).
- **Limites** :
    - Plus lente sur les bases volumineuses.
    - Ne sauvegarde pas certains paramètres internes (logs binaires, fichiers de configuration).


#### **B. Sauvegarde physique**

- **Définition** : Copie directe des fichiers de données du serveur MariaDB (dossiers, fichiers binaires).
- **Utilitaires courants** : `mariadb-backup`, copie manuelle des fichiers.
- **Caractéristiques** :
    - Très rapide, adaptée aux bases importantes.
    - Conserve la structure exacte du serveur (y compris index, logs).
    - Restauration complète du serveur possible.
- **Limites** :
    - Moins flexible pour la restauration sélective.
    - Risque d’incohérence si la base est active lors de la copie sans utilitaire adapté.


### 2. Sauvegarde complète vs partielle

| Type de sauvegarde | Description | Avantages | Inconvénients |
| :-- | :-- | :-- | :-- |
| Complète | Sauvegarde de l’ensemble des données et schémas | Simple à gérer, restauration rapide | Fichiers volumineux, temps long |
| Partielle (ou sélective) | Sauvegarde d’une partie (table, schéma, etc.) | Gain de temps et d’espace, ciblée | Restauration plus complexe |

### 3. Scénarios d’utilisation

- **Sauvegarde logique complète** : migration de base, archivage, changement de version.
- **Sauvegarde logique partielle** : export/import de tables spécifiques, transfert de données entre projets.
- **Sauvegarde physique complète** : plan de reprise après sinistre, sauvegarde nocturne de production.
- **Sauvegarde physique partielle** : rarement utilisée, sauf cas très spécifiques (ex : fichiers de logs).


### 4. Critères de choix

- **Taille de la base** : privilégier le physique pour les bases volumineuses.
- **Fréquence des sauvegardes** : logique pour des sauvegardes fréquentes et ciblées.
- **Besoin de restauration sélective** : logique préférable.
- **Performance et temps d’arrêt** : physique pour minimiser l’indisponibilité.
- **Compatibilité entre serveurs** : logique pour la portabilité.


### 5. Définitions et concepts clés

- **Consistance** : état cohérent des données lors de la sauvegarde.
- **Hot backup** : sauvegarde réalisée alors que la base est en service.
- **Cold backup** : sauvegarde réalisée lorsque la base est arrêtée.
- **Incremental backup** : ne sauvegarde que les modifications depuis la dernière sauvegarde complète.


### 6. Quiz de validation

1. Quelle est la différence principale entre une sauvegarde logique et une sauvegarde physique ?
2. Dans quel cas privilégier une sauvegarde partielle ?
3. Quels sont les risques d’une copie physique sans utilitaire dédié sur une base active ?
4. Expliquez le concept de “hot backup”.

### 7. Ressources complémentaires

- Documentation officielle MariaDB sur les types de sauvegardes.
- Fiches mémo : tableau comparatif des méthodes de sauvegarde.
- Guides ANSSI sur la gestion de la résilience des bases de données.

