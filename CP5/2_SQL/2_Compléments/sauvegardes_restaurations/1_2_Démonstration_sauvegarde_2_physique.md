# Démonstration : Sauvegarde physique MariaDB avec `mariadb-backup`

## Objectifs pédagogiques

À l'issue de cette démonstration, les apprenants seront capables de :

- **Exécuter** `mariadb-backup` pour créer une sauvegarde physique cohérente sur un serveur actif
- **Identifier** les différents types de sauvegardes physiques (complète, incrémentale, avec compression)
- **Sécuriser** les identifiants d'accès via un fichier de configuration client `~/.my.cnf`

## Partie 1 : Sauvegarde physique simple (environnement de test)

> **Attention pédagogique :** Cette méthode avec mot de passe en clair est présentée uniquement pour la compréhension. Elle ne doit jamais être utilisée en production.

### 1.1 Installation de mariadb-backup

**Sur Debian/Ubuntu :**

```bash
sudo apt-get update
sudo apt-get install mariadb-backup
```

**Sur CentOS/RHEL :**

```bash
sudo yum install mariadb-backup
```


### 1.2 Création d'un utilisateur MariaDB pour la sauvegarde

```sql
CREATE USER 'backupuser'@'localhost' IDENTIFIED BY 'MotDePasseFort!';
GRANT RELOAD, PROCESS, LOCK TABLES, BINLOG MONITOR ON *.* TO 'backupuser'@'localhost';
FLUSH PRIVILEGES;
```


### 1.3 Commande de sauvegarde avec mot de passe exposé

```bash
sudo mariadb-backup \
  --backup \
  --user=backupuser \
  --password=MotDePasseFort! \
  --target-dir=/var/mariadb/backup_full/
```

Exemple

```bash
mariadb-backup --backup --user=root --password=my-secret-pw --target-dir=/backup/dossier_backup_1
```

**Paramètres expliqués :**

- `--backup` : déclenche la copie à chaud des fichiers de données
- `--target-dir` : répertoire de destination (doit être vide ou inexistant)
- `--user/--password` : identifiants d'accès (vulnérables dans cette forme)

### 1.3.1 Comprendre le processus

**Que fait cette commande ?**
- `mariadb-backup` copie tous les fichiers de données MariaDB
- `--backup` indique qu'on veut faire une sauvegarde (et non une restauration)
- `--target-dir` spécifie où stocker les fichiers copiés
- Le processus se fait "à chaud" : pas d'arrêt du serveur nécessaire

**Pourquoi cette méthode ?**
- Plus rapide que `mariadb-dump` sur les grosses bases
- Copie exacte des fichiers : restauration identique
- Inclut tous les éléments (logs, configuration, etc.)

### 1.4 Vérification de la sauvegarde

```bash
ls -la /var/mariadb/backup_full/
```

Vous devriez voir des fichiers comme :

- `backup-my.cnf`
- `ibdata1`
- `xtrabackup_checkpoints`
- `xtrabackup_info`


## Partie 2 : Sécurisation via fichier `~/.my.cnf`

### 2.1 Création du fichier client sécurisé

```ini
# /home/backupuser/.my.cnf
[client]
user=backupuser
password=MotDePasseFort!
```

**Sécurisation obligatoire :**

```bash
chmod 600 /home/backupuser/.my.cnf
```


### 2.2 Exécution sécurisée

```bash
sudo -u backupuser mariadb-backup \
  --backup \
  --target-dir=/var/mariadb/backup_full/
```

**Avantages :** Aucune trace du mot de passe dans l'historique shell, les logs système ou la liste des processus.

### 2.3 Script automatisé professionnel

```bash
#!/bin/bash
# Script de sauvegarde physique sécurisé
# Utilise le fichier ~/.my.cnf pour les identifiants

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/mariadb/backups"
TARGET_DIR="$BACKUP_DIR/backup_$DATE"

# Créer le dossier de sauvegarde
mkdir -p "$TARGET_DIR"

# Lancer la sauvegarde
echo "Début de la sauvegarde..."
mariadb-backup --backup --target-dir="$TARGET_DIR"

# Vérifier le résultat
if [ $? -eq 0 ]; then
    echo "✅ Sauvegarde réussie dans : $TARGET_DIR"
else
    echo "❌ Erreur lors de la sauvegarde"
    exit 1
fi
```
