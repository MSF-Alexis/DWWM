# 4 : Sauvegarde physique avec `mariadb-backup`

## Objectifs

| Description |
| :-- |
| Comprendre les différences et cas d’usage des sauvegardes physiques et logiques |
| Exécuter une sauvegarde physique complète et incrémentale, puis préparer et restaurer ces sauvegardes |
| Automatiser et sécuriser l’ensemble du processus selon le référentiel RNCP 37674 (CP5) |

## Tags

|  |  |  |
| :--: | :--: | :--: |
| CP5 | SQL | SCRIPT |

## Sommaire

- [1. Pourquoi une sauvegarde physique ?](#1-pourquoi-une-sauvegarde-physique-)
- [2. Prérequis et mise en place](#2-pr%C3%A9requis-et-mise-en-place)
    - [2.1. Installation de l’outil](#21-installation-de-mariadb-backup)
    - [2.2. Création d’un utilisateur dédié](#22-cr%C3%A9ation-dun-utilisateur-d%C3%A9di%C3%A9)
- [3. Sauvegarde physique complète](#3-sauvegarde-physique-compl%C3%A8te)
    - [3.1. Commande pas-à-pas](#31-commande-pas-%C3%A0-pas)
    - [3.2. Analyse du dossier de sauvegarde](#32-analyse-du-dossier-de-sauvegarde)
- [4. Sauvegarde physique incrémentale](#4-sauvegarde-physique-incr%C3%A9mentale)
    - [4.1. Principe et organisation](#41-principe-et-organisation)
    - [4.2. Sauvegarde complète (full)](#42-sauvegarde-compl%C3%A8te-full)
    - [4.3. Sauvegarde incrémentale](#43-sauvegarde-incr%C3%A9mentale)
- [5. Préparation et restauration sur le serveur](#5-pr%C3%A9paration-et-restauration-sur-le-serveur)
    - [5.1. Préparer (`--prepare`)](#51-pr%C3%A9parer-%E2%80%93prepare)
    - [5.2. Restaurer (`--copy-back`)](#52-restaurer-%E2%80%93copy-back)
- [6. Restauration physique dans Docker](#6-restauration-physique-dans-docker)
- [7. Automatiser la sauvegarde](#7-automatiser-la-sauvegarde)
    - [7.1. Script Bash commenté](#71-scriptbash-comment%C3%A9)
    - [7.2. Planification cron](#72-planification-cron)
- [8. Bonnes pratiques et sécurité](#8-bonnes-pratiques-et-s%C3%A9curit%C3%A9)
- [9. Validation et tests](#9-validation-et-tests)
- [10. Ressources complémentaires](#10-ressources-compl%C3%A9mentaires)


## 1. Pourquoi une sauvegarde physique ?

La sauvegarde physique copie **bit à bit** les fichiers de MariaDB (InnoDB, journaux, répertoires système). Elle est recommandée lorsque :

- La base dépasse plusieurs dizaines de Go (dump logique trop lent)
- Le **RTO** (temps de remise en service) doit rester très court
- Le **RPO** (données perdues) doit être quasi nul grâce aux incrémentales


## 2. Prérequis et mise en place

| État à vérifier | Commande | Pourquoi |
| :-- | :-- | :-- |
| MariaDB ≥ 10.2 | `mariadb --version` | Assure la disponibilité de `mariadb-backup` |
| `mariadb-backup` installé | `mariadb-backup --version` | Vérifier le binaire |
| Espace disque ≥ 2× données | `df -h` | Sauvegarde full double la taille des données |
| Service cron actif | `systemctl status cron` | Pour l’automatisation |

### 2.1. Installation de l’outil

**Debian/Ubuntu**

```bash
sudo apt update
sudo apt install mariadb-backup
```

**CentOS/RHEL**

```bash
sudo yum install mariadb-backup
```


### 2.2. Création d’un utilisateur dédié

```sql
CREATE USER 'backupuser'@'localhost' IDENTIFIED BY 'MotDePasseFort!';
GRANT RELOAD, PROCESS, LOCK TABLES, BINLOG MONITOR ON *.* TO 'backupuser'@'localhost';
FLUSH PRIVILEGES;
```

Pour éviter d’exposer le mot de passe :

```ini
# /home/backupuser/.my.cnf
[client]
user=backupuser
password=MotDePasseFort!
```

```bash
chmod 600 /home/backupuser/.my.cnf
```


## 3. Sauvegarde physique complète

### 3.1. Commande pas-à-pas

```bash
mariadb-backup --backup \
  --target-dir=/var/backups/mariadb/full_$(date +%F)
```

1. `--backup` effectue une copie à chaud sans arrêter MariaDB.
2. `--target-dir` indique un dossier vide qui recevra l’image.

### 3.2. Analyse du dossier de sauvegarde

```text
full_YYYY-MM-DD/
├── backup-my.cnf
├── ibdata1
├── xtrabackup_logfile
├── xtrabackup_checkpoints
├── xtrabackup_info
├── mysql/
├── performance_schema/
└── votre_base/
```

- **backup-my.cnf** : paramètres du serveur au moment du backup, relus en préparation
- **ibdata1** : tablespace système InnoDB, indispensable
- **xtrabackup_logfile** : journal InnoDB capturé, rejoué en préparation
- **xtrabackup_checkpoints** : LSN début/fin, type de backup (full/incrémental)
- **xtrabackup_info** : métadonnées (durée, taille) pour traçabilité
- **mysql/**, **performance_schema/** : bases système (utilisateurs, privilèges)
- **votre_base/** : données applicatives (fichiers `.ibd`)


## 4. Sauvegarde physique incrémentale

### 4.1. Principe et organisation

L’incrémentale copie uniquement les pages modifiées depuis la dernière full (ou incrémentale), optimisant temps et espace.

### 4.2. Sauvegarde complète (full)

```bash
mariadb-backup --backup \
  --target-dir=/var/backups/mariadb/2025-07-16/full
```


### 4.3. Sauvegarde incrémentale

```bash
mariadb-backup --backup \
  --target-dir=/var/backups/mariadb/2025-07-16/inc_01 \
  --incremental-basedir=/var/backups/mariadb/2025-07-16/full
```

- **`.delta`** : pages modifiées
- **`.meta`** : index et checksum
- **xtrabackup_checkpoints** : enchaînement incrément→full


## 5. Préparation et restauration sur le serveur

### 5.1. Préparer les sauvegardes (`--prepare`)

```bash
mariadb-backup --prepare \
  --target-dir=/var/backups/mariadb/2025-07-16/full

mariadb-backup --prepare \
  --target-dir=/var/backups/mariadb/2025-07-16/full \
  --incremental-dir=/var/backups/mariadb/2025-07-16/inc_01
```

Cette étape applique les journaux et fusionne les incrémentales pour garantir la cohérence (roll-forward et roll-back).

### 5.2. Restaurer les fichiers (`--copy-back`)

```bash
sudo systemctl stop mariadb

mariadb-backup --copy-back \
  --target-dir=/var/backups/mariadb/2025-07-16/full

sudo chown -R mysql:mysql /var/lib/mysql
sudo systemctl start mariadb
```


## 6. Restauration physique dans Docker

### 6.1. Schéma général

1. Préparez la sauvegarde sur l’hôte (`--prepare`).
2. Montez le dossier préparé **directement** sur `/var/lib/mysql` du conteneur MariaDB.
3. MariaDB démarre sur ces fichiers sans copie supplémentaire.

### 6.2. Étapes pas-à-pas

```bash
# 1. Identifiez votre dossier préparé
BACKUP_DIR=/var/backups/mariadb/2025-07-16/full_prepared

# 2. Lancez le conteneur restauré
docker run -d --name mariadb_restored \
  -e MARIADB_ALLOW_EMPTY_ROOT_PASSWORD=1 \
  -v ${BACKUP_DIR}:/var/lib/mysql \
  -p 3307:3306 \
  mariadb:latest \
  bash -c "chown -R mysql:mysql /var/lib/mysql && exec docker-entrypoint.sh mysqld"


# 3. Vérifiez la restauration
docker exec -it mariadb_restored \
  mariadb -uroot -e "SHOW DATABASES;"
```


## 7. Automatiser la sauvegarde

### 7.1. Script Bash commenté

```bash
#!/bin/bash
BASE_DIR="/var/backups/mariadb"
DATE=$(date +%F_%H%M)
FULL_DIR="$BASE_DIR/full_$DATE"
LAST_FULL=$(ls -td $BASE_DIR/full_* 2>/dev/null | head -1)
INC_DIR="$BASE_DIR/inc_$DATE"
LOG="/var/log/backup_phys.log"
exec >> "$LOG" 2>&1
echo "Sauvegarde $DATE"
if [ -z "$LAST_FULL" ] || [ $(date +%u) -eq 1 ]; then
  mariadb-backup --backup --target-dir="$FULL_DIR"
else
  mariadb-backup --backup --target-dir="$INC_DIR" --incremental-basedir="$LAST_FULL"
fi
```


### 7.2. Planification cron

```bash
crontab -e
# Lundi full à 02h
0 2 * * 1 /usr/local/bin/backup_physical.sh
# Mardi–dimanche incrémental à 02h
0 2 * * 2-7 /usr/local/bin/backup_physical.sh
```


## 8. Bonnes pratiques et sécurité

- Conserver les sauvegardes hors-site (NAS, cloud)
- Chiffrer les archives si sensibles
- Politique GFS : 7 j / 4 sem / 12 mois
- Surveiller et alerter sur les logs (`xtrabackup_info`, `backup_phys.log`)
- Tester la restauration complète mensuellement


## 9. Validation et tests

| Étape | Commande | Attendu |
| :-- | :-- | :-- |
| Préparation réussie | `grep "completed OK" full_*/xtrabackup_info` | Ligne « completed OK » présente |
| Fichiers disponibles | `ls -lh full_*/ibdata1` | Fichier non vide |
| Restauration locale | `mariadb -e "SHOW TABLES;" votre_base` | Tables listées |
| Restauration Docker | `docker exec mariadb_restored mariadb ...` | Pas d’erreur et bases listées |
| Vérification LSN | `cat full_*/xtrabackup_checkpoints` | LSN cohérent |

## 10. Ressources complémentaires

- **MariaDB Backup Overview** – MariaDB Docs : https://mariadb.com/kb/en/mariadb-backup-overview/
- **Percona Blog** : *Incremental Backups Explained*
- **ANSSI** : Bonnes pratiques de sauvegarde (RGPD/ANSSI)
- **Percona Playground** : Autotest-Restore (CI)
https://github.com/percona-lab/percona-playground/tree/main/autotest-restore

