# 3 : Sauvegarde logique avec `mariadb-dump`

## Objectifs :

| Description |
| :-- |
| Comprendre le rôle et le fonctionnement de l'utilitaire `mariadb-dump` |
| Identifier les bonnes pratiques de sécurité (droits minimaux, fichier `~/.my.cnf`, vérification d'intégrité) |
| Réaliser des sauvegardes complètes ou partielles, manuelles ou automatisées, puis valider leur cohérence |
| Automatiser les sauvegardes à l'aide de scripts Bash et de la planification `cron` |

## Tags :

|  |  |  |
| :-- | :-- | :-- |
| CP5 | SCRIPT | SQL |

## Sommaire

- [Contexte et principes](#contexte-et-principes)
- [Prérequis techniques](#pr%C3%A9requis-techniques)
    - [Installation de l'outil](#installation-de-loutil)
        - [Vérifier la version](#v%C3%A9rifier-la-version)
- [Commandes de base](#commandes-de-base)
    - [Créer un utilisateur dédié](#cr%C3%A9er-un-utilisateur-d%C3%A9di%C3%A9)
    - [Sauvegarde simple (méthode pédagogique)](#sauvegarde-simple-m%C3%A9thode-p%C3%A9dagogique)
        - [Sauvegarde complète](#sauvegarde-compl%C3%A8te)
    - [Sauvegarde sécurisée](#sauvegarde-s%C3%A9curis%C3%A9e)
        - [Création du fichier `.my.cnf`](#cr%C3%A9ation-du-fichier-myncf)
        - [Commande sécurisée](#commande-s%C3%A9curis%C3%A9e)
- [Options avancées](#options-avanc%C3%A9es)
    - [Sauvegardes enrichies (`--routines`, `--triggers`, `--events`)](#sauvegardes-enrichies---routines---triggers---events)
        - [Exemple complet](#exemple-complet)
    - [Sauvegarde sélective (tables, clauses `WHERE`)](#sauvegarde-s%C3%A9lective-tables-clauses-where)
        - [Sauvegarde partielle par table](#sauvegarde-partielle-par-table)
        - [Sauvegarde partielle par condition](#sauvegarde-partielle-par-condition)
    - [Compression en flux](#compression-en-flux)
- [Automatisation et scripts](#automatisation-et-scripts)
    - [Script Bash professionnel](#script-bash-professionnel)
    - [Planification avec cron](#planification-avec-cron)
        - [Syntaxe cron essentielle](#syntaxe-cron-essentielle)
        - [Configuration pratique](#configuration-pratique)
- [Bonnes pratiques et sécurité](#bonnes-pratiques-et-s%C3%A9curit%C3%A9)
    - [Droits minimaux](#droits-minimaux)
    - [Gestion des mots de passe](#gestion-des-mots-de-passe)
- [Validation et tests](#validation-et-tests)
    - [Contrôles d'intégrité](#contr%C3%B4les-dint%C3%A9grit%C3%A9)
- [Ressources complémentaires](#ressources-compl%C3%A9mentaires)


## Contexte et principes

La sauvegarde logique repose sur l'exportation de la structure et des données sous forme de script SQL lisible. C'est la méthode privilégiée pour :

* migrer des bases entre serveurs ou versions différentes
* restaurer sélectivement tables, vues, routines
* disposer d'un fichier texte simple à archiver ou à placer sous gestion de versions
* réaliser des sauvegardes **complètes** ou **partielles** selon les besoins


## Prérequis techniques

| Élément | Détail | Vérification |
| :-- | :-- | :-- |
| MariaDB installé | ≥ 10.3 recommandé | `mariadb --version` |
| Droits utilisateur | `SELECT`, `LOCK TABLES`, `SHOW VIEW`, `TRIGGER` | Requête `SHOW GRANTS;` |
| Espace disque | > taille de la base exportée | `df -h` |
| Service cron | Actif sur le système | `systemctl status cron` |

### Installation de l'outil

#### Debian / Ubuntu

```bash
sudo apt update
sudo apt install mariadb-client
```

##### Vérifier la version

```bash
mariadb-dump --version
```


## Commandes de base

### Créer un utilisateur dédié

**Bonne pratique essentielle** : créer un utilisateur spécialisé pour les sauvegardes (pas `root`)

```sql
CREATE USER 'backupuser'@'localhost' IDENTIFIED BY 'MotDePasseFort!';
GRANT SELECT, LOCK TABLES, SHOW VIEW, TRIGGER ON *.* TO 'backupuser'@'localhost';
FLUSH PRIVILEGES;
```


### Sauvegarde simple (méthode pédagogique)

> ⚠️ Cette méthode affiche le mot de passe en clair ; à réserver aux environnements de test.

#### Sauvegarde complète

```bash
mariadb-dump -u backupuser -p'MotDePasseFort!' ma_base > backup_ma_base.sql
```


### Sauvegarde sécurisée

#### Création du fichier `.my.cnf`

```ini
# /home/backupuser/.my.cnf
[client]
user=backupuser
password=MotDePasseFort!
```

> Note : Ce fichier doit se trouver à la racine du dossier \$HOME

```bash
chmod 600 /home/backupuser/.my.cnf
```

> Note : Chmod permet de limiter les droits du fichier en fonction de vos besoins, ici chmod restreint l'accès à tout le monde sauf à son auteur.

#### Commande sécurisée

```bash
mariadb-dump ma_base > backup_ma_base.sql
```


## Options avancées

### Sauvegardes enrichies (`--routines`, `--triggers`, `--events`)

Inclure l'ensemble des objets SQL pour une **sauvegarde complète** :

```bash
mariadb-dump --single-transaction \
             --routines --triggers --events \
             ma_base > backup_complet.sql
```


#### Exemple complet

```bash
mariadb-dump --single-transaction --quick \
             --routines --triggers --events \
             --default-character-set=utf8mb4 \
             ma_base | gzip > backup_complet.sql.gz
```


### Sauvegarde sélective (tables, clauses `WHERE`)

#### Sauvegarde partielle par table

```bash
# Une seule table
mariadb-dump ma_base clients > backup_clients.sql

# Plusieurs tables spécifiques
mariadb-dump ma_base clients commandes > backup_clients_commandes.sql
```


#### Sauvegarde partielle par condition

```bash
mariadb-dump --where="date_creation >= '2025-01-01'" \
             ma_base commandes > commandes_2025.sql
```


### Compression en flux

```bash
mariadb-dump ma_base | gzip > backup_ma_base.sql.gz
```


## Automatisation et scripts

### Script Bash professionnel

```bash
#!/bin/bash
# Script de sauvegarde MariaDB - CP5 Formation RNCP 37674
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/mariadb"
DBS=("ecommerce" "blog" "users")
RETENTION=7

# Créer le répertoire de sauvegarde
mkdir -p "$BACKUP_DIR"

# Sauvegarder chaque base
for DB in "${DBS[@]}"; do
  echo "Sauvegarde de $DB..."
  mariadb-dump --single-transaction --routines --triggers --events "$DB" | \
  gzip > "$BACKUP_DIR/${DB}_$DATE.sql.gz"
  
  if [ $? -eq 0 ]; then
    echo "✅ Sauvegarde de $DB réussie"
  else
    echo "❌ Erreur lors de la sauvegarde de $DB"
  fi
done

# Nettoyage des anciennes sauvegardes
find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +$RETENTION -delete
echo "Nettoyage terminé"
```

**Rendre le script exécutable :**

```bash
chmod +x /usr/local/bin/backup_mariadb.sh
```


### Planification avec cron

#### Syntaxe cron essentielle

Format : `minute heure jour_mois mois jour_semaine commande`


| Valeur | Signification | Exemple |
| :-- | :-- | :-- |
| `0 2 * * *` | Tous les jours à 2h00 | Sauvegarde quotidienne |
| `0 */6 * * *` | Toutes les 6 heures | Sauvegarde fréquente |
| `0 1 * * 0` | Dimanche à 1h00 | Sauvegarde hebdomadaire |

#### Configuration pratique

```bash
# Éditer la crontab
crontab -e

# Ajouter la tâche de sauvegarde quotidienne
0 2 * * * /usr/local/bin/backup_mariadb.sh >> /var/log/mariadb_backup.log 2>&1
```

**Vérifier la configuration :**

```bash
# Voir les tâches programmées
crontab -l

# Vérifier les logs
tail -f /var/log/mariadb_backup.log
```


## Bonnes pratiques et sécurité

### Droits minimaux

**Règle d'or** : utilisateur dédié avec privilèges strictement nécessaires

```sql
-- ✅ Bon : utilisateur spécialisé
CREATE USER 'backupuser'@'localhost' IDENTIFIED BY 'MotDePasseFort!';
GRANT SELECT, LOCK TABLES, SHOW VIEW, TRIGGER ON *.* TO 'backupuser'@'localhost';

-- ❌ Mauvais : utiliser root
-- Ne jamais utiliser root pour les sauvegardes automatiques !
```


### Gestion des mots de passe

* **Toujours** stocker dans `~/.my.cnf` avec permissions `600`
* **Jamais** inscrire de mot de passe dans un script versionné ou un crontab
* **Toujours** utiliser un utilisateur dédié avec droits limités


## Validation et tests

### Contrôles d'intégrité

```bash
# Vérifier que le fichier est non vide
test -s backup_ma_base.sql && echo "✅ Sauvegarde OK" || echo "❌ Sauvegarde vide !"

# Compter les tables exportées
grep -c "CREATE TABLE" backup_ma_base.sql

# Vérifier les tâches cron
crontab -l | grep backup
```

**Règle d'or** : toujours restaurer une sauvegarde sur un serveur de test au moins une fois par mois.

## Ressources complémentaires

* Documentation officielle : https://mariadb.com/kb/en/mariadb-dump/
* Recommandations ANSSI – Sécurisation des bases de données : https://www.ssi.gouv.fr/


