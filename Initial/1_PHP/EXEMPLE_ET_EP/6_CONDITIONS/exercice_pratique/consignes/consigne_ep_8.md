# Exercices pratiques : Conditions en PHP (`if`, `else`, `elseif`)

## Objectif
Ces exercices vous permettront de pratiquer les structures conditionnelles en PHP (`if`, `else`, `elseif`). Vous manipulerez des variables et des valeurs pour comprendre comment prendre des décisions dans un programme. À la fin, vous mélangerez opérateurs logiques et de comparaison pour résoudre des problèmes plus complexes.

---

## Exercice 1 : Condition simple (`if`)
1. Créez une variable `$age` contenant un nombre.
2. Utilisez une condition `if` pour vérifier si l'âge est supérieur ou égal à 18.
3. Affichez un message comme : "Vous êtes majeur." si la condition est vraie.

---

## Exercice 2 : Condition avec `else`
1. Créez une variable `$heure` contenant un nombre (entre 0 et 23).
2. Utilisez une condition `if` pour vérifier si l'heure est inférieure à 12.
3. Affichez "Bonjour !" si c'est le matin, sinon affichez "Bon après-midi !".

---

## Exercice 3 : Condition avec `elseif`
1. Créez une variable `$note` contenant un nombre (entre 0 et 20).
2. Utilisez des conditions `if`, `elseif` et `else` pour afficher :
   - "Excellent !" si la note est >= 16.
   - "Très bien !" si la note est >= 14.
   - "Bien !" si la note est >= 12.
   - "Passable." si la note est >= 10.
   - "Insuffisant." sinon.

---

## Exercice 4 : Mélange de conditions et d'opérateurs logiques
1. Créez deux variables : `$estConnecte` (booléen) et `$estAdmin` (booléen).
2. Utilisez des conditions pour afficher :
   - "Bienvenue, administrateur !" si l'utilisateur est connecté ET administrateur.
   - "Bienvenue, utilisateur !" si l'utilisateur est connecté mais pas administrateur.
   - "Veuillez vous connecter." sinon.

---

## Exercice 5 : Conditions complexes
1. Créez une variable `$meteo` contenant une chaîne de caractères (ex : `"pluie"`, `"neige"`, `"soleil"`).
2. Créez une variable `$temperature` contenant un nombre.
3. Utilisez des conditions pour afficher :
   - "Prenez un parapluie !" s'il pleut ET que la température est > 5.
   - "Mettez un manteau !" s'il neige OU que la température est < 0.
   - "Profitez du soleil !" sinon.

---

## Exercice 6 (Bonus) : Conditions imbriquées
1. Créez une variable `$age` contenant un nombre.
2. Créez une variable `$possedePermis` contenant un booléen.
3. Utilisez des conditions imbriquées pour afficher :
   - "Vous pouvez conduire." si l'âge est >= 18 ET que la personne a un permis.
   - "Vous ne pouvez pas conduire." si l'âge est >= 18 mais que la personne n'a pas de permis.
   - "Vous êtes trop jeune pour conduire." sinon.

---


## Instructions pour les exercices
- Ouvrez le fichier `/reponses/ep_8.php`.
- Écrivez votre code dans les espaces prévus (`^ ^ Écrivez au-dessus ^ ^`).
- Utilisez `var_dump` ou `echo` pour afficher les résultats des comparaisons.
- Exécutez le fichier pour vérifier vos résultats.