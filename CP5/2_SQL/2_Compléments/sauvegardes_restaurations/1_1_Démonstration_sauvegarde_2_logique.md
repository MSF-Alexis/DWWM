# Démonstration : Sauvegarde logique MariaDB avec deux méthodes

### Objectif

Réaliser une sauvegarde logique d’une base MariaDB avec l’outil natif `mariadb-dump`. Cette méthode exporte la structure et les données sous forme de script SQL lisible.

### Partie 1 : Sauvegarde simple avec mot de passe en ligne de commande

> **Attention :** Cette méthode est pédagogique et doit être réservée aux environnements de test. Elle n’est pas recommandée en production.

#### Prérequis

- Accès à un serveur MariaDB fonctionnel.
- Droits suffisants sur la base à sauvegarder.
- Terminal ou invite de commandes disponible.


#### 1. Lister les bases disponibles

```bash
mariadb -u root -p -e "SHOW DATABASES;"
```


#### 2. Sauvegarder une base nommée `ma_base`

```bash
mariadb-dump -u root -p ma_base > sauvegarde_ma_base.sql
```

- `-u root` : utilisateur avec droits suffisants
- `-p` : demande le mot de passe
- `ma_base` : nom de la base à sauvegarder
- `> sauvegarde_ma_base.sql` : redirige la sortie vers un fichier


#### 3. Inclure routines, triggers et événements

```bash
mariadb-dump -u root -p --routines --triggers --events ma_base > sauvegarde_complete.sql
```


#### 4. Sauvegarder et compresser en une seule commande

```bash
mariadb-dump -u root -p ma_base | gzip > sauvegarde_ma_base.sql.gz
```


#### 5. Vérifier le contenu de la sauvegarde

```bash
head -20 sauvegarde_ma_base.sql
```


#### 6. Automatiser la sauvegarde avec un script Bash

```bash
#!/bin/bash
DATE=$(date +%F)
DB="masolutionformation"
USER="root"
PASSWORD="my-secret-pw"
BACKUP_DIR="/backup"
mariadb-dump --user=$USER --password=$PASSWORD $DB > $BACKUP_DIR/${DB}_$DATE.sql
```


### Partie 2 : Sécurisation avec un fichier `.my.cnf`

> **Méthode recommandée en environnement professionnel** pour éviter d’exposer le mot de passe.

#### 1. Créer un utilisateur dédié à la sauvegarde (optionnel, recommandé)

Connectez-vous à MariaDB et créez un utilisateur avec droits limités :

```sql
CREATE USER 'backupuser'@'localhost' IDENTIFIED BY 'motDePasseFort';
GRANT SELECT, LOCK TABLES, SHOW VIEW, TRIGGER ON ma_base.* TO 'backupuser'@'localhost';
FLUSH PRIVILEGES;
```


#### 2. Créer le fichier de configuration sécurisé

Dans le dossier personnel de l’utilisateur Linux qui exécute la sauvegarde, créez un fichier `~/.my.cnf` :

```ini
[client]
user=backupuser
password=motDePasseFort
```

**Sécurisez ce fichier :**

```bash
chmod 600 ~/.my.cnf
```

Seul l’utilisateur courant peut lire ce fichier.

#### 3. Lancer la sauvegarde sans exposer le mot de passe

```bash
mariadb-dump ma_base > sauvegarde_ma_base.sql
```

- L’outil lit automatiquement les identifiants dans `~/.my.cnf`.
- Le mot de passe n’est plus visible dans la commande, ni dans les logs ou l’historique.


#### 4. Automatiser la sauvegarde avec un script Bash sécurisé

```bash
#!/bin/bash
DATE=$(date +%F)
DB="ma_base"
BACKUP_DIR="/home/backupuser/backups"
mariadb-dump $DB > $BACKUP_DIR/${DB}_$DATE.sql
```

- Ce script s’exécute avec l’utilisateur Linux disposant du fichier `~/.my.cnf` sécurisé.


### Bonnes pratiques complémentaires

- **Stocker la sauvegarde** sur un support externe ou distant.
- **Automatiser la tâche** avec cron, toujours avec l’utilisateur dédié.
- **Tester régulièrement** la restauration à partir des sauvegardes.
- **Limiter les droits** de l’utilisateur de sauvegarde au strict nécessaire.
- **Documenter la procédure** pour la rendre reproductible.


### Points pédagogiques à retenir

- La méthode simple avec mot de passe en clair est facile à comprendre mais dangereuse pour la sécurité.
- La méthode avec `.my.cnf` est professionnelle et protège les identifiants.
- Toujours privilégier la configuration sécurisée en entreprise ou sur des données sensibles.
- Sensibiliser les apprenants aux risques liés à la gestion des mots de passe dans les scripts.


