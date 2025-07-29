# Exercices pratiques : Fonctions et inclusions en PHP

## Objectifs
- Découper son code en fichiers thématiques
- Utiliser des fonctions spécialisées
- Pratiquer l'inclusion de fichiers

---

### Thématique 1 : Comparaisons numériques
#### Fichier : maths.php
Contiendra des fonctions pour :
1. Trouver le plus grand entre 2 nombres
2. Vérifier si un nombre est pair
3. Calculer la moyenne de 3 nombres

#### Exercice 1.1
1. Créez maths.php avec ces 3 fonctions
2. Dans index.php, incluez maths.php
3. Testez chaque fonction avec différents nombres

---

### Thématique 2 : Manipulation de texte
#### Fichier : textes.php
Contiendra des fonctions pour :
1. Compter le nombre de mots dans une phrase
2. Inverser une chaîne de caractères
3. Mettre la première lettre en majuscule

#### Exercice 2.1
1. Implémentez ces fonctions dans textes.php
2. Incluez le fichier dans index.php
3. Testez avec "bonjour le monde"

---

### Thématique 3 : Calculs utiles
#### Fichier : calculs.php
Contiendra des fonctions pour :
1. Calculer un pourcentage
2. Convertir des euros en dollars
3. Arrondir un nombre à 2 décimales

#### Exercice 3.1
1. Créez calculs.php avec ces fonctions
2. Utilisez-les dans index.php avec :
   - 50% de 200
   - 10€ en dollars (taux 1.2)
   - Arrondir 3.14159

---

### Thématique 4 : Vérifications
#### Fichier : validations.php
Contiendra des fonctions pour :
1. Vérifier si un email est valide
2. Contrôler si un mot de passe est assez long (8 caractères)
3. Tester si une date est future

#### Exercice 4.1
1. Implémentez ces vérifications
2. Testez avec :
   - "test@example.com"
   - "mdp123"
   - "2025-01-01"

---

## Structure recommandée
``` mon_projet/
├── includes/
│ ├── maths.php
│ ├── textes.php
│ ├── calculs.php
│ └── validations.php
└── index.php
```

## Consignes générales
1. Un fichier = une thématique
2. Une fonction = une tâche précise
3. Tester systématiquement chaque fonction
4. Utiliser require_once pour les inclusions

## Erreurs à éviter
- Mettre trop de fonctions dans un fichier
- Oublier de tester les cas limites
- Utiliser des noms peu clairs

---

## Progression recommandée
1. Commencer par maths.php (le plus simple)
2. Poursuivre avec textes.php
3. Traiter ensuite calculs.php
4. Finir par validations.php (le plus complexe)
