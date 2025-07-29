# Module SQL - 28H (4 jours)

## Objectif Final  
Maîtriser les opérations CRUD et concevoir une base de données simple pour une application réelle.

---

### Jour 1 : Fondamentaux des Bases de Données  
**Objectif** : Comprendre la structure d'une base relationnelle  

1. **Concepts Clés**  
   - Rôle d'une base de données vs fichiers plats  
   - Tables, colonnes, lignes  
   - Clés primaires (identifiant unique)  
   - Clés étrangères (liens entre tables)  

2. **Pratique Guidée**  
   - Création d'une table utilisateurs : pseudo, email, date d'inscription  
   - Choix des types de données (texte, nombre, date)  
   - Ajout de contraintes (champs obligatoires, valeurs uniques)  

3. **Exercice**  
   - Modéliser une table d'articles de blog (titre, contenu, auteur, date)  

---

### Jour 2 : Manipulation des Données  
**Objectif** : Savoir ajouter, modifier et supprimer des entrées  

1. **Opérations CRUD**  
   - Insertion de données (nouveaux utilisateurs/articles)  
   - Mise à jour d'entrées existantes  
   - Suppression sécurisée (avec conditions)  

2. **Cas Concrets**  
   - Gestion des erreurs courantes (doublons, violations de contraintes)  
   - Import/export de données basique  

3. **Exercice**  
   - Peupler la base avec 5 utilisateurs et 10 articles  
   - Corriger des données erronées  

---

### Jour 3 : Requêtes Avancées  
**Objectif** : Extraire des informations complexes  

1. **Jointures Basiques**  
   - Afficher les articles avec le nom de leur auteur  
   - Types de relations (1-n, n-n)  

2. **Calculs Statistiques**  
   - Compter le nombre d'articles par utilisateur  
   - Moyenne/total sur des données numériques  

3. **Exercice Synthèse**  
   - Générer un rapport : "Top 3 des auteurs les plus actifs"  

---

### Jour 4 : Projet & Bonnes Pratiques  
**Objectif** : Concevoir une base complète pour une application réelle  

1. **Modélisation**  
   - Schéma complet blog : utilisateurs, articles, commentaires  
   - Définition des relations entre tables  

2. **Gestion Professionnelle**  
   - Outils graphiques (phpMyAdmin, Adminer)  
   - Sauvegardes automatisées  
   - Sécurité basique (droits d'accès)  

3. **Checklist Entreprise**  
   - Convention de nommage  
   - Documentation minimale  
   - Procédure de dépannage  

---

## Kit de Survie Entreprise  
1. **Commandes Vitales**  
   - Sélectionner des données avec filtres  
   - Insérer/mettre à jour/supprimer des entrées  
   - Exporter des résultats au format CSV  

2. **Erreurs Fréquentes**  
   - Oublis de contraintes  
   - Jointures mal configurées  
   - Problèmes d'encodage  

3. **Ressources Utiles**  
   - Documentation MySQL officielle  
   - Outil de modélisation en ligne (drawSQL, dbdiagram)