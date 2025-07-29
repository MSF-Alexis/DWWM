# Cadre Méthodologique et Vue d’Ensemble pour l’Écriture de Supports de Formation

**Recommandation principale :** Adopter un processus systématique en cinq étapes (Analyse → Design → Production → Validation → Amélioration continue) pour garantir cohérence, traçabilité RNCP et lisibilité des supports, tout en offrant une vision globale et un fil rouge clair de la formation.

## 1. Analyse

Objectif : Comprendre le contexte, le public et les compétences visées

- Identifier le **persona cible** (Reconvers-Dev, Auto-Didacte, Visuel, Vincent-Rebelle) et ses besoins d’apprentissage.
- Définir le **niveau** (débutant → intermédiaire → junior → junior+) et le **parcours** global.
- Sélectionner la ou les **fiches compétences RNCP** concernées et extraire les **résultats d’apprentissage** attendus.
- Cartographier la formation dans le temps (durée totale, découpage en modules et en phases).


## 2. Design (Backward Design)

Objectif : Définir les résultats finaux et concevoir à rebours

1. **Fixer les objectifs SMART**
    - Formuler des objectifs mesurables alignés fiche RNCP (ex. « à l’issue de la formation, l’apprenant implémente un service métier avec tests ≥ 85% »).
2. **Déterminer les preuves d’apprentissage**
    - Choisir des évaluations authentiques : quiz, démos live, projets intégrateurs, soutenances.
3. **Planifier les activités pédagogiques**
    - Séquences théoriques, démonstrations, exercices guidés, ateliers collaboratifs.
4. **Établir la progression**
    - Articuler les modules (théorie ↔ pratique), prévoir des points de contrôle réguliers (quiz intermédiaires, auto-évaluations).

1. Résultats d’apprentissage visés
- À l’issue du module, l’apprenant doit être capable de :
- Mettre en place et configurer un accès transactionnel à une base relationnelle (CRUD avec rollback).
- Concevoir et implémenter des services d’accès aux données NoSQL (schéma, indexation).
- Sécuriser les accès (authentification, chiffrement, droits, protection injections).
- Assurer tolérance aux pannes et continuité (rollback, reprise, journaux).
- Réaliser des tests d’intégration, de sécurité et de charge (fuzzing, injection, tests de performance).
- Gérer la concurrence (verrou optimiste/pessimiste, isolations, résolution conflits).
- Produire la documentation de déploiement (diagrammes, procédures, sauvegarde).
- Développer des composants métier côté serveur (logique de traitement, agrégations).


2. Objectifs d’apprentissage SMART
    1. **CRUD Transactionnel SQL**
    À la fin du module, chaque apprenant implémentera en Node.js un DAO PostgreSQL complet (Create, Read, Update, Delete) avec gestion manuelle de transactions (`BEGIN`/`COMMIT`/`ROLLBACK`) et rollback automatique sur erreur, validé par une couverture de tests unitaires ≥ 90%.
    2. **Services NoSQL**
    Les apprenants configureront en Python un service MongoDB (`pymongo`), définissant un schéma JSON validé et créant des index pour optimiser les requêtes, avec tests unitaires et gestion d’authentification par clés.
    3. **Sécurisation et Tests**
    Chaque composant fera l’objet de tests d’intégration (injections SQL via sqlmap, fuzzing JSON), de tests de charge (JMeter ou k6 sous 100 req/s) et de tests unitaires automatisés (Jest/PyTest), avec rapport d’analyse des vulnérabilités et des performances.
    4. **Tolérance aux pannes \& journaux**
    À l’issue du module, l’apprenant mettra en place un mécanisme de journalisation des transactions (fichier de logs) et démontrera la reprise après erreur via script de simulation de panne, validé par un exercice pratique.
    5. **Concurrence et Isolation**
    Les apprenants implémenteront un verrouillage optimiste et pessimiste dans MongoDB et PostgreSQL, puis réaliseront un cas pratique de résolution de conflit concurrent avec isolation démontrée, attestée par des logs et un test end-to-end.
    6. **Documentation de déploiement**
    Chaque apprenant produira un guide complet (README.md + diagrammes Docker Compose / Kubernetes) détaillant variables d’environnement, procédures d’installation et sauvegarde/restauration, validé par un exercice de mise en production en local.
    7. **Composants métier**
    À la fin du module, l’apprenant développera un service métier (calculs, agrégations, règles métier) côté serveur en Node.js ou Python, couvert par des tests unitaires ≥ 85% et intégré dans l’architecture globale du microservice.


## 3. Production des Supports

Objectif : Créer des contenus clairs, structurés et conformes

- Utiliser les **templates de contenus** (cours, exercices, projet) :
    - Cours : accroche → objectifs SMART → contenu → résumé → quiz
    - Exercices : consignes, fichiers de départ, indices, corrections commentées
    - Projet : cahier des charges, livrables, grille d’évaluation RNCP
- Adapter la **différenciation pédagogique** selon le persona :
    - Reconvers-Dev : tutoriels pas à pas, captures d’écran
    - Auto-Didacte : documentation exhaustive, liens ressources
    - Visuel : infographies, mind-maps
    - Vincent-Rebelle : défis, cas concrets
- Veiller à la **conformité RGPD, RGAA, OWASP** pour tous les documents.


## 4. Validation \& Évaluation

Objectif : Vérifier l’efficacité et la conformité

- Construire des **évaluations alignées** : QCM, mises en situation, revues de code, soutenances.
- Définir des **indicateurs clés** (taux de réussite > 85%, satisfaction ≥ 4,5/5, couverture de tests ≥ 90%).
- Mettre en place le **collecte de feedback** : enquêtes post-module, analytics LMS (temps passé, taux d’abandon).


## 5. Amélioration Continue

Objectif : Ajuster et faire évoluer la formation

- Analyser les **résultats vs. objectifs SMART** et identifier les écarts.
- Proposer des **actions correctives** : capsules ciblées, workshops de remédiation.
- Mettre à jour les **contenus et méthodes** (nouvelles technologies, évolution RNCP).
- Boucler vers la phase Analyse pour chaque nouvelle session.


## Vue d’ensemble de la Formation

| Phase | Contenu clé | Supports \& Activités | Persona / Niveau |
| :-- | :-- | :-- | :-- |
| 1. Préparation | Diagnostic, objectifs généraux | Quiz d’entrée, mind-map de parcours | Tous / Débutant |
| 2. Acquisition | Concepts fondamentaux (HTML, CSS, JS, SQL) | Cours, capsules vidéo, infographies, quiz intermédiaire | Tous / Débutant ↗ Intermédiaire |
| 3. Application | Exercices guidés CRUD, services NoSQL | Templates GitHub, ateliers collaboratifs | Tous / Intermédiaire |
| 4. Intégration | Projet microservice complet | Cahier des charges, coaching synchrone | Tous / Intermédiaire ↗ Junior |
| 5. Certification | Évaluations RNCP (examen, soutenance) | Dossier professionnel, soutenance, QCM final | Tous / Junior |
| 6. Suivi \& Amélioration | Feedback, analytics, itérations | Rapports LMS, ateliers de suivi, mise à jour contenus | Tous / Junior+ |

Ce processus assure un **cadre d’écriture clair et ordonné**, une **traçabilité RNCP totale** et une **vision globale** de la progression pédagogique, de l’analyse initiale jusqu’à l’amélioration continue.

