# Exercices PDO MySQL - Réseau Social Basique

## Objectifs
- Manipuler les relations entre tables
- Pratiquer les requêtes préparées
- Comprendre les jointures simples

---

### Partie 1 : Lecture de données

#### Exercice 1.1 - Lister les utilisateurs
1. Établir la connexion PDO
2. Récupérer tous les utilisateurs (id + username)
3. Afficher sous forme de liste numérotée

#### Exercice 1.2 - Afficher un profil
1. Pour l'utilisateur avec l'ID 1 :
   - Récupérer ses informations
   - Compter ses posts
   - Afficher les résultats

---

### Partie 2 : Contenu utilisateur

#### Exercice 2.1 - Posts d'un utilisateur
1. Sélectionner tous les posts de l'utilisateur 1
2. Afficher le contenu et la date de création
3. Indiquer le nombre total de posts

#### Exercice 2.2 - Commentaires récents
1. Récupérer les 5 derniers commentaires
2. Afficher pour chacun :
   - Contenu
   - Auteur (username)
   - Post associé

---

### Partie 3 : Insertions basiques

#### Exercice 3.1 - Nouveau post
1. Insérer un post pour l'utilisateur 1
2. Contenu : "Mon premier post !"
3. Afficher l'ID du nouveau post

#### Exercice 3.2 - Ajouter un commentaire
1. Ajouter un commentaire au post 1
2. Auteur : utilisateur 2
3. Contenu : "Super post !"
4. Vérifier l'insertion

---

### Partie 4 : Requêtes avec jointures

#### Exercice 4.1 - Détail d'un post
1. Pour le post 1 :
   - Afficher son contenu
   - Afficher l'auteur (username)
   - Lister ses commentaires (auteur + contenu)

#### Exercice 4.2 - Statistiques
1. Compter pour l'utilisateur 1 :
   - Nombre total de posts
   - Nombre total de commentaires
   - Moyenne de commentaires par post

### Exercice Bonus - Page de profil HTML/PDO

## Objectif
Créer une page de profil dynamique qui affiche :
1. Les infos de l'utilisateur
2. Ses derniers posts
3. Les commentaires réçus

### Consignes
1. Créez un fichier `profil.php`
2. Utilisez PDO pour récupérer :
   - L'utilisateur avec l'ID 1
   - Ses 5 derniers posts
   - Les 3 derniers commentaires sur ses posts
3. Générez un rendu HTML au choix.

> Le script SQL de création de la base sera fourni séparément avec :
> - Structure complète des tables
> - Jeu de données de test
> - Contraintes et relations