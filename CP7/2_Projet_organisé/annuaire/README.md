## README.md
```markdown
# 📋 Gestionnaire de Contacts - Projet PHP Organisé

## 🎯 Objectif pédagogique

Ce projet enseigne l'organisation professionnelle d'une application web PHP en utilisant :
- Une architecture modulaire claire
- La séparation des responsabilités
- La sécurisation des accès aux données
- La documentation complète

## 📁 Structure du projet

```
contacts-organise/
├── public/           # Point d'entrée public (seul dossier accessible via web)
│   └── index.php
├── includes/         # Logique métier et fonctions
│   ├── db.php        # Connexion base de données
│   ├── crud.php      # Opérations CRUD
│   ├── import.php    # Import CSV
│   └── export.php    # Export CSV
├── templates/        # Templates HTML
│   ├── header.php
│   └── footer.php
├── config/          # Configuration
│   └── config.php
├── data/            # Fichiers CSV
│   └── exemples.csv
└── tests/           # Scripts de test
    └── test_import.php
```

## 🚀 Installation

### Prérequis
- Serveur local (XAMPP, WAMP, MAMP)
- PHP 7.4 ou supérieur
- MySQL/MariaDB
- Navigateur web moderne

### Étapes d'installation

1. **Cloner/télécharger le projet**
   ```
   Placer le dossier dans htdocs/ (XAMPP) ou www/ (WAMP)
   ```

2. **Créer la base de données**
   ```sql
   CREATE DATABASE contacts_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Configurer la connexion**
   - Modifier `config/config.php` si nécessaire
   - Ajuster DB_HOST, DB_USER, DB_PASS selon votre configuration

4. **Lancer l'application**
   ```
   http://localhost/contacts-organise/public/
   ```

5. **Vérifier l'installation**
   ```
   http://localhost/contacts-organise/tests/test_import.php
   ```

## 🛠️ Fonctionnalités

### Gestion des contacts (CRUD)
- ➕ **Créer** : Ajouter un nouveau contact
- 👀 **Lire** : Afficher la liste des contacts
- ✏️ **Modifier** : Éditer un contact existant
- 🗑️ **Supprimer** : Supprimer un contact

### Import/Export CSV
- 📥 **Import** : Importer des contacts depuis un fichier CSV
- 📤 **Export** : Exporter tous les contacts vers CSV
- 📋 **Exemple** : Générer un fichier CSV d'exemple

### Sécurité
- 🔒 Requêtes préparées PDO (protection injection SQL)
- 🧹 Validation et nettoyage des données
- 📁 Fichiers sensibles hors du répertoire public
- ✅ Validation des emails

## 📊 Format CSV attendu

```csv
nom,prenom,email,telephone
Dupont,Jean,jean.dupont@email.com,0123456789
Martin,Marie,marie.martin@email.com,0987654321
```

**Règles :**
- Première ligne = en-têtes (optionnelle)
- Colonnes obligatoires : nom, prenom, email
- Colonne optionnelle : telephone
- Encodage UTF-8 recommandé

## 🧪 Tests et validation

### Test automatique
```bash
http://localhost/contacts-organise/tests/test_import.php
```

### Tests manuels
1. Ajouter un contact via le formulaire
2. Modifier un contact existant
3. Supprimer un contact
4. Importer le fichier exemples.csv
5. Exporter la base vers CSV
6. Vérifier la gestion des erreurs (email en double, champs vides)

## 🏗️ Architecture et bonnes pratiques

### Séparation des responsabilités
- **config/** : Configuration centralisée
- **includes/** : Logique métier pure
- **templates/** : Présentation HTML
- **public/** : Point d'entrée unique

### Sécurité implémentée
- PDO avec requêtes préparées
- Validation des données d'entrée
- Protection contre l'injection SQL
- Gestion sécurisée des uploads

### Standards respectés
- Nommage en français (contexte pédagogique)
- Fonctions courtes et spécialisées
- Gestion d'erreurs systématique
- Code commenté et documenté

## 🐛 Dépannage

### Erreur de connexion DB
1. Vérifier que MySQL est démarré
2. Contrôler les paramètres dans `config/config.php`
3. S'assurer que la base `contacts_db` existe

### Erreur d'upload CSV
1. Vérifier les permissions du dossier `data/`
2. Contrôler la taille du fichier (max 2MB)
3. S'assurer que le fichier est bien en UTF-8

### Page blanche
1. Activer l'affichage des erreurs PHP
2. Consulter les logs d'erreur du serveur
3. Vérifier les chemins dans `config/config.php`

## 📚 Compétences RNCP développées

### BC02 - Développer la partie back-end
- ✅ Base de données relationnelle
- ✅ Composants d'accès aux données SQL
- ✅ Composants métier côté serveur
- ✅ Documentation du déploiement

### BC01 - Front-end (partiellement)
- ✅ Formulaires HTML sécurisés
- ✅ Interface utilisateur responsive

## 👨‍🏫 Notes pour le formateur

### Points d'évaluation
- [ ] Respect de l'arborescence
- [ ] Fonctions dans les bons fichiers
- [ ] Sécurisation des requêtes SQL
- [ ] Gestion des erreurs
- [ ] Tests fonctionnels réussis
- [ ] Documentation README complète

### Extensions possibles
- Recherche/filtrage des contacts
- Pagination de la liste
- Validation JavaScript côté client
- Interface d'administration
- Logs des opérations

# Build l'image de dev
`docker build -t php-apache-dev-env .`
> Commande a lancer depuis **/1_PHP** en racine
# Créer un container
`docker run -d -p 8080:80 -v ${pwd}:/var/www/html --name php-apache-dev-container php-apache-dev-env:latest`
> Commande a lancer depuis **/1_PHP/EXEMEPLE_ET_EP** en racine


# Utiliser le docker-compose pour avoir le même réseau avec mysql sql 
> docker-compose -p learning-env up