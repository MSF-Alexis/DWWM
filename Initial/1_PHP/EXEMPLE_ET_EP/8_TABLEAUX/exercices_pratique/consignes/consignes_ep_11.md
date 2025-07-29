# Exercices sur les Tableaux Avancés - Partie 2

## Objectif
Ces exercices vous feront découvrir les tableaux complexes en PHP. Vous apprendrez à créer et manipuler des tableaux associatifs (clé-valeur), puis à structurer des données hiérarchiques avec des tableaux multidimensionnels. Par des cas pratiques (gestion d'étudiants, inventaires), vous maîtriserez les opérations CRUD sur ces structures et les parcourrez avec des boucles imbriquées.

## Exercice 1 : Tableaux Associatifs Simples

### Exercice 1.1 - Création
- Créez un tableau associatif nommé "etudiant" avec :
  * Une clé "nom" ayant pour valeur "Alice"
  * Une clé "age" avec la valeur 20
  * Une clé "notes" contenant un tableau avec les valeurs 12, 15 et 18
- Affichez le message : "Alice a X notes" (en calculant automatiquement le nombre de notes)

### Exercice 1.2 - Modification
- Modifiez l'âge d'Alice pour 21
- Ajoutez une nouvelle clé "ville" avec la valeur "Paris"
- Affichez le contenu complet du tableau

---

## Exercice 2 : Manipulation de Tableaux

### Exercice 2.1 - Parcours
- Affichez toutes les informations de l'étudiant sous la forme :
  nom: Alice
  age: 21
  ville: Paris
  notes: 12, 15, 18

### Exercice 2.2 - Recherche
- Vérifiez si la clé "notes" existe dans le tableau
- Affichez "Le tableau contient des notes" ou "Pas de notes" selon le cas

---

## Exercice 3 : Tableaux Multidimensionnels

### Exercice 3.1 - Création
- Créez un tableau "classe" contenant 2 étudiants :
  * Le premier étudiant est Alice (avec ses notes 12, 15)
  * Le second est Bob (notes 10, 14)
- Structurez les données de manière claire

### Exercice 3.2 - Accès
- Affichez :
  * La deuxième note d'Alice
  * Un message "Age non renseigné" pour Bob (puisqu'il n'a pas d'âge dans les données)

---

## Exercice 4 : Opérations Avancées

### Exercice 4.1 - Ajout
- Ajoutez un troisième étudiant nommé "Clara" avec une note de 16
- Affichez la liste complète des étudiants

### Exercice 4.2 - Suppression
- Supprimez toutes les notes d'Alice
- Vérifiez que la suppression a bien fonctionné

---

## Exercice 5 : Boucles Complexes

### Exercice 5.1 - Affichage Structuré
- Affichez tous les étudiants avec leur nom et leurs notes sous la forme :
  Alice : 12, 15
  Bob : 10, 14
  Clara : 16

### Exercice 5.2 - Calculs
- Pour chaque étudiant, calculez et affichez sa moyenne sous la forme :
  Alice : 13.5/20
  Bob : 12/20
  Clara : 16/20

---

## Exercice 6 : Applications Concrètes

### Exercice 6.1 - Gestion de Bibliothèque
- Créez un tableau "bibliotheque" avec 2 livres :
  * Harry Potter (auteur: JK Rowling, disponible: oui)
  * Le Seigneur des Anneaux (auteur: JRR Tolkien, disponible: non)
- Affichez uniquement les livres disponibles

### Exercice 6.2 - Menu de Restaurant
- Créez un menu avec :
  * Entrées : Salade (5€), Soupe (4€)
  * Plats : Poulet (12€), Poisson (15€)
- Affichez le menu complet avec les prix

## Instructions pour les exercices
- Ouvrez le fichier `/reponses/ep_11.php`.
- Utilisez des fonctions pour faire votre propre retour visuel.
- Exécutez le fichier pour vérifier vos résultats.