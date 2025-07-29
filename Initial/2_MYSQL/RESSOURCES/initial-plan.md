# Plan de Formation SQL Révisé - 28H (4 jours)

## Objectif Final  
Maîtriser les opérations essentielles et concevoir une base de données fonctionnelle pour des applications web.

---

### Jour 1 : Fondamentaux Concrets  
**Objectif** : Modéliser une base de données réaliste  

1. **Théorie Appliquée (2H)**  
   - Rôle des bases de données dans le développement web  
   - Comparaison Excel/CSV vs SQL  

2. **Atelier Pratique (5H)**  
   - Étude de cas : Schéma d'un blog (utilisateurs, articles, commentaires)  
   - Outil de modélisation : dbdiagram.io  
   - Création des tables sans écrire de code (approche visuelle)  

3. **Exercice**  
   - Modéliser un système de réservation de salles de réunion  

---

### Jour 2 : Manipulation des Données en Situation Réelle  
**Objectif** : Manipuler des jeux de données professionnels  

1. **CRUD Guidé (4H)**  
   - Insertion : Catalogue produit d'un site e-commerce  
   - Mise à jour : Correction de données clients  
   - Suppression : Nettoyage de données obsolètes  

2. **Cas d'Usage**  
   - Import de données CSV vers SQL  
   - Export de résultats pour reporting  

3. **Exercice**  
   - Peupler une base de commandes (20 clients, 50 commandes)  
   - Générer un fichier Excel à partir de requêtes  

---

### Jour 3 : Requêtes pour le Développement Web  
**Objectif** : Résoudre des problèmes métiers courants  

1. **Jointures Utiles (3H)**  
   - INNER JOIN : Afficher les commandes avec détails clients  
   - LEFT JOIN : Lister les produits jamais commandés  

2. **Statistiques Basiques (2H)**  
   - CA mensuel par catégorie  
   - Panier moyen des clients  

3. **Exercice Synthèse (2H)**  
   - Requêtes pour un dashboard client :  
     - Dernières commandes  
     - Produits les plus populaires  
     - Clients inactifs  

---

### Jour 4 : Intégration Pro et Sécurité  
**Objectif** : Préparer l'environnement professionnel  

1. **Connexion PHP/PDO (3H)**  
   - Lire des données depuis PHP  
   - Afficher les résultats dans un tableau HTML  
   - Gestion des erreurs basiques  

2. **Sécurité (2H)**  
   - Prévention des injections SQL  
   - Validation des entrées utilisateur  
   - Chiffrement des mots de passe  

3. **Projet Final (2H)**  
   - Application de gestion de contacts :  
     - Formulaire d'ajout sécurisé  
     - Liste paginée  
     - Recherche dynamique  

---

## Kit de Survie Entreprise  

### Commandes Vitales  
- Sélectionner des données avec filtres complexes  
- Exporter des résultats au format CSV/Excel  
- Sauvegarder/restaurer une base de données  

### Erreurs Fréquentes  
- Oubli des clauses WHERE dans UPDATE/DELETE  
- Jointures mal configurées entraînant des doublons  
- Problèmes d'encodage des caractères spéciaux  

### Ressources Clés  
- Documentation officielle MySQL  
- Extensions PHP pour le débogage (Xdebug)  
- Modèles de schémas de base de données courants  