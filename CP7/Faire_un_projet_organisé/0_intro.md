# 0 — Projet Web PHP organisé : architecture, base de données et import/export CSV

| Élément | Détails |
| :-- | :-- |
| **Titre** | Structurer un projet PHP organisé, base de données, import/export CSV |
| **Bloc RNCP ciblé** | BC01 – Front-end (formulaire), BC02 – Back-end (BDD, accès données, sécurité, documentation) |
| **Niveau** | Débutant avancé |
| **Prérequis** | Bases PHP, HTML, SQL, serveur local (XAMPP/WAMP), notions sur les fichiers |
| **Objectifs SMART** | 1) Organiser l’arborescence d’un projet web réel. <br>2) Réaliser un CRUD sur BDD avec PHP procédural.<br>3) Mettre en œuvre un import/export CSV synchronisé avec la base.<br>4) Documenter et tester l’ensemble. |

## 1. Rappel du contexte et du but initial

L’objectif n’est PAS simplement de manipuler des données, mais **d’apprendre à organiser un projet web comme dans la réalité professionnelle**.
> Un développeur junior sait découper logiquement ses fichiers, séparer les responsabilités, favoriser la réutilisation, maintenir les données en sécurité et fournir des scripts/outils pour faciliter l’intégration, la maintenance et le transfert du projet.
> Ici, la partie import/export CSV est une _fonction_ et non la finalité : la finalité reste la **structuration et organisation de projet**.

## 2. Raisons d’une organisation modulaire

| Problème rencontré en entreprise | Solution organisationnelle | Bénéfice immédiat |
| :-- | :-- | :-- |
| Code “spaghetti” difficile à maintenir | Découpage logique des dossiers : `public/`, `includes/`, `data/`... | Facilité de navigation, évolutivité |
| Impossible d’isoler les erreurs | Centralisation des accès BDD, fonctions isolées dans `includes/` | Débogage et tests plus simples |
| Sécurité faible | Fichiers sensibles hors `public/`, SQL sécurisé via requêtes | Moins de failles, meilleure conformité |
| Travail en équipe compliqué | README détaillé, scripts SQL, configuration partagée | Onboarding plus rapide |

## 3. Structure de projet recommandée

```
contacts-organise/
├── public/
│   └── index.php             # Entrée unique, aucune info sensible
├── includes/
│   ├── db.php                # Accès base générique (PDO)
│   ├── crud.php              # Fonctions CRUD (create, read, update, delete)
│   ├── import.php            # Fonction d’import CSV → BDD
│   ├── export.php            # Fonction d’export BDD → CSV
├── templates/
│   ├── header.php
│   └── footer.php
├── data/
│   └── exemples.csv          # Exemples pour import (jamais de stockage sensible ici)
├── config/
│   └── config.php            # Constantes, accès BDD, variables d’env
├── tests/
│   └── test_import.php       # Peut être lancé pour valider le process
├── README.md
└── .gitignore
```


## 4. Exemples de principes organisationnels

- **Séparation du code métier** : Toute logique d’accès BDD dans `includes/`, pas de SQL dans `public/`.
- **Fonctions réutilisables et testables** : Même fonction de “lecture contacts” exploitée en import/export, affichage ou test.
- **Sécurité/Conformité** : Accès aux données via requêtes préparées, fichiers sensibles jamais exposés côté `public/`.
- **Documentation** : README explicite sur l’installation, le fonctionnement, la structure de chaque fichier, processus de test.


## 5. Backward Objectives (objectifs finaux observables)

| Code | Objectif observable | Critère de réussite | Compétence RNCP |
| :--: | :-- | :-- | :-- |
| OBJ-PROJ1 | L’apprenant met en place une arborescence conforme (voir ci-dessus) | Dossiers/fichiers respectés, pas de code “monobloc” | BC02 |
| OBJ-PROJ2 | Il configure une connexion PDO sécurisée | Config centralisée, test de connexion réussi | BC02 |
| OBJ-PROJ3 | Il développe les fonctions CRUD et les importe/exporte en CSV | Utilisation de fonctions centralisées, données transférées sans erreur | BC02 |
| OBJ-PROJ4 | Il rédige un README expliquant l’architecture | Documentation claire/testée | BC02 |
| OBJ-PROJ5 | Il applique le contrôle de sécurité et la validation des données | Emails validés, injections SQL impossibles | BC02 |

## 6. Évaluation - Les preuves attendues

- **Arborescence du projet vérifiée via dépôt Git** (preuve d’autonomie et d’organisation)
- **README** : pas d’ambiguïté, installation/test reproductibles
- **Fonctionalité :**
    - Import d’un csv proposé → affichage des nouveaux contacts en BDD, gestion erreurs/doublons.
    - Export BDD en CSV → vérification via import sur instance vierge.
- **Sécurité** : Injection SQL impossible, aucun accès direct à des fichiers sensibles.
- **Test** : Lancer le script simple dans `/tests/` pour “jouer” une session import/export fictive.


## 7. Alignement rigoureux avec le RNCP 37674

- **BC02 – Développer la partie back-end d’une application web ou web mobile sécurisée**
    - *Mettre en place une base de données relationnelle* (fiche compétence pro 5, pp.23-24)
    - *Développer des composants d’accès aux données SQL et NoSQL* (fiche compétence pro 6, pp.25-26)
    - *Développer des composants métier côté serveur* (fiche compétence pro 7, pp.27-28)
    - *Documenter le déploiement de l’application* (fiche compétence pro 8, p.29)
- Validation par :
    - **Organisation des fichiers** (preuve de professionnalisation)
    - **Centralisation des accès BDD**
    - **Respect de la sécurité ANSSI/OWASP**
    - **Documentation du déploiement et des scripts**


## 8. Synthèse : Le “pourquoi” de l’organisation

Ce projet place la **structuration** AVANT la fonction :
L’apprenant saura non seulement coder des opérations métier, mais surtout :

- organiser ;
- nommer clairement ;
- centraliser la configuration et les accès aux ressources sensibles ;
- fournir une documentation minimale mais professionnelle — _juste comme en entreprise_.

C’est la **base réelle** attendue au RNCP, avant d’aller vers la POO/Frameworks.

## Annexe : Checklist rapide pour le formateur

- [ ] Dossier `public/` minimaliste, rien d’autre que le point d’entrée
- [ ] Accès BDD **uniquement** en `includes/db.php`
- [ ] Pas de code monolithique : toute action/traitement dans un fichier dédié
- [ ] README exhaustif, pas de “zone grise”
- [ ] Processus de test et de validation clairement décrit

Ce module transforme le savoir-faire “coder un CRUD” en compétence durable : **savoir s’organiser, structurer, sécuriser, documenter et livrer comme un vrai professionnel du web**.

