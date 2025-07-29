# Projet Bibliothèque Municipale - Consignes
## **🎯 Objectifs** : Développer une application web complète de gestion de livres pour une bibliothèque municipale

### 📐 Partie 0 - Modélisation de la base de données
1. Créer un schéma de base de données avec DrawSQL comprenant :
    - Table books (titre, isbn, disponible)
    - Table author (nom, prenom)
    - Table book_categories (nom)
    - Table customers (nom, prenom, numéro de téléphone)
2. Définir les relations entre les tables
3. Exporter le schéma au format PNG
---
### 📚 Partie 1 - Structure de la base
1. Modéliser le schéma SQL dans MySQL
2. Peupler les tables avec 15 livres fictifs ou non
3. Peupler les tables avec des auteurs fictifs ou non
4. Peupler les tables avec des catégories
5. Peupler les tables avec des clients
5. Peupler les tables avec des emprunts
---
### 💻 Partie 2 - Interface utilisateur
1. Développer une interface responsive avec :
    - Menu de navigation fixé en haut
    - Deux onglets principaux : Livres/Usagers
    - Tableaux avec système de tri et recherche
    - Formulaire modal pour les ajouts/modifications
2. Appliquer un CSS moderne avec :
    - Grille responsive pour les tableaux
    - Contrastes colorimétriques accessibles
    - Animations légères sur les interactions
---
### 🌐 Partie 3 - Intégration dynamique
1. Connecter l'interface à la BDD avec PHP
2. Afficher dynamiquement la liste des livres
3. Préparer les formulaires (sans traitement)
---
### 🔎 Partie 4 - Système de recherche
1. Implémenter la recherche par titre/auteur pour les livres
2. Implémenter la recherche par nom/prénom pour les usagers
3. Gérer les paramètres d'URL
4. Ajouter un feedback utilisateur
---
### 📖 Partie 5 - Gestion des données
1. Mettre en place le CRUD complet (livres et usagers)
2. Ajouter la pagination des résultats (Bonus)
3. Intégrer des confirmations JavaScript
---
### 🛡️ Partie 6 - Sécurisation
1. Valider toutes les entrées utilisateur
2. Protéger contre les injections SQL
3. Gérer les erreurs

```markdown
# ⓘ Info supplémentaire

## 📦 Livrables Obligatoires
0.  Dossier zip contenant le code source de votre application
1.  Dossier "database" contenant :
    - Fichier SQL d'initialisation
    - Export PNG du schéma

## ✅ Critères de Validation
1. Application fonctionnelle sans erreur PHP/JS
2. Code structuré et commenté

## 🧠 Méthodologie Recommandée
- Découper les tâches en sous-problèmes
- Tester chaque composant individuellement


## ✨Bonus : Ajouter un historique des emprunts avec dates
```
