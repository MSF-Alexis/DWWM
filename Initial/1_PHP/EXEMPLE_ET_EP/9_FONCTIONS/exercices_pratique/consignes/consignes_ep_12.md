# Exercices pratiques : Fonctions PHP (Niveau Débutant à Intermédiaire)

## Objectif
Ces exercices vous permettront de maîtriser les fonctions PHP en partant de bases simples jusqu'à des concepts plus avancés. Vous apprendrez à créer, utiliser et combiner des fonctions pour résoudre des problèmes concrets.

---

### **Section 1 : Fonctions Mathématiques de Base**

#### Exercice 1.1 - Somme simple
1. Écrivez une fonction `somme($a, $b)` qui calcule la somme de deux nombres
2. Testez avec : `somme(5, 3)` → doit afficher `8`

#### Exercice 1.2 - Moyenne
1. Écrivez une fonction `moyenne($a, $b, $c)` qui calcule la moyenne de trois nombres
2. Testez avec : `moyenne(10, 20, 30)` → doit afficher `20`

#### Exercice 1.3 - Conversion température
1. Écrivez une fonction `celsiusVersFahrenheit($celsius)` utilisant la formule :  
   `F = (C × 9/5) + 32`
2. Testez avec : `celsiusVersFahrenheit(25)` → doit afficher `77`

---

### **Section 2 : Vérifications et Comparaisons**

#### Exercice 2.1 - Pair ou Impair
1. Écrivez une fonction `estPair($nombre)` qui retourne :
   - `true` si le nombre est pair
   - `false` sinon
2. Testez avec 4 et 7

#### Exercice 2.2 - Plus grand nombre
1. Écrivez une fonction `maxNombre($a, $b)` qui retourne le plus grand des deux nombres
2. Testez avec : `maxNombre(8, 15)` → doit retourner `15`

---

### **Section 3 : Manipulation de Chaînes**

#### Exercice 3.1 - Longueur de chaîne
1. Écrivez une fonction `longueurChaine($texte)` qui retourne le nombre de caractères
2. Testez avec : `longueurChaine("Bonjour")` → doit retourner `7`

#### Exercice 3.2 - Trouver un caractère
1. Écrivez une fonction `trouverCaractere($texte, $caractere)` qui retourne :
   - La position du premier caractère trouvé
   - `-1` si non trouvé
2. Testez avec : `trouverCaractere("bonjour", "j")` → doit retourner `3`

---

### **Section 4 : Exercices Avancés (Bonus)**

#### Exercice 4.1 - Palindrome 
1. Écrivez une fonction `estPalindrome($mot)` qui vérifie si un mot se lit pareil à l'endroit et à l'envers
2. Testez avec : `estPalindrome("kayak")` → `true` et `estPalindrome("php")` → `false`

#### Exercice 4.2 - Compteur de mots 
1. Écrivez une fonction `compterMots($phrase)` qui compte le nombre de mots
   - Astuce : utilisez `explode(" ", $phrase)`
2. Testez avec : `compterMots("PHP est super")` → doit retourner `3`

---

### **Section 5 : Défis Combinés**

#### Exercice 5.1 - Calculatrice 
1. Écrivez une fonction `calculer($a, $b, $operation)` qui :
   - Accepte "+", "-", "*", "/"
   - Retourne le résultat ou `"Opération invalide"`
2. Testez toutes les opérations

#### Exercice 5.2 - Validation de données
1. Écrivez une fonction `validerEmail($email)` qui vérifie :
   - Présence d'un "@"
   - Un "." après le "@"
   - Longueur minimale de 5 caractères


## Instructions pour les exercices
- Créez et ouvrez fichier `/reponses/ep_12.php`.
- Utilisez des fonctions pour faire votre propre retour visuel.
- Exécutez le fichier pour vérifier vos résultats.