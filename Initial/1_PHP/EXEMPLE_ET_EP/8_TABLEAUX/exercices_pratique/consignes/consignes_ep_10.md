# Exercices Tableaux pour Débutants (Niveau 1)

## Objectif
Ces exercices vous permettront de maîtriser les tableaux indexés en PHP. Vous commencerez par des opérations simples de création et d'accès aux éléments, puis progresserez vers des manipulations plus avancées comme l'ajout, la modification et la suppression d'éléments. Enfin, vous combinerez ces notions avec des boucles pour traiter efficacement des ensembles de données. Des exercices concrets vous aideront à ancrer ces fondamentaux.

## Section 1 : Création
### Exercice 1.1 
Créez un tableau `$legumes` avec "carotte", "haricot", "poireau"

### Exercice 1.2
Affichez le 1er et dernier légume avec leur position :  
"Position 0 : carotte"

---

## Section 2 : Modification
### Exercice 2.1
Remplacez "haricot" par "courgette" dans `$legumes`

### Exercice 2.2
Ajoutez "tomate" à la fin, puis "pomme de terre" au début

---

## Section 3 : Suppression
### Exercice 3.1
Supprimez le légume à la position 1, affichez le résultat

### Exercice 3.2
Videz complètement le tableau, vérifiez avec `empty()`

---

## Section 4 : Parcours (Boucles)
### Exercice 4.1
Affichez tous les légumes avec `for` sous forme de liste :  
- carotte  
- courgette  
- ...

### Exercice 4.2
Refaites-le avec `foreach` en ajoutant "J'aime les [légume]"

---

## Section 5 : Pratique Guidée
### Exercice 5.1
Créez un tableau `$notes` avec 5 notes entre 0 et 20  
Affichez "Note X : [note]/20"

### Exercice 5.2
Calculez la somme et la moyenne des notes

### Exercice 5.3
Affichez uniquement les notes >= 10 avec leur position

---

## Section 6 : Jeux
### Exercice 6.1
Devinez un légume :  
- L'utilisateur propose un légume  
- Affichez "Oui !" s'il est dans `$legumes`, "Non..." sinon

### Exercice 6.2
Mélangez le tableau `$legumes` avec `shuffle()`, affichez le résultat

## Instructions pour les exercices
- Ouvrez le fichier `/reponses/ep_10.php`.
- Écrivez votre code dans les espaces prévus (`^ ^ Écrivez au-dessus ^ ^`).
- Utilisez des fonctions pour faire votre propre retour visuel.
- Exécutez le fichier pour vérifier vos résultats.