<?php
/**
 * Félicitation, vous allez faire votre premier script PHP !
 */

/*
 * === Consigne exo n°1 ===
 * Créer une variable nommée $age contenant votre âge (nombre entier).
 * Créer une variable nommée $prenom contenant votre prénom (chaîne de caractères).
 * Créer une variable nommée $entreprise contenant le nom de l'entreprise dans laquelle
 * vous faites votre alternance (chaîne de caractères).
 */
$age = 25;
// ^ ^ Ecrivez votre solution au-dessus ^ ^
echo "<h1>Test d'exécution exercice n°1</h1>";
echo "Âge : " . $age . "<br>";
echo "Prénom : " . $prenom . "<br>";
echo "Entreprise : " . $entreprise . "<br>";
echo "<hr>";

/*
 * === Consigne exo n°2 ===
 * Créer une variable nommée $saison avec comme valeur la saison actuelle (chaîne de caractères).
 * Créer une variable nommée $mois avec comme valeur le mois actuel (chaîne de caractères).
 * Créer une variable nommée $jour avec comme valeur le numéro du jour actuel (nombre entier).
 * Créer une variable nommée $annee avec comme valeur l'année en cours (nombre entier).
 */

// ^ ^ Ecrivez votre solution au-dessus ^ ^
echo "<h1>Test d'exécution exercice n°2</h1>";
echo sprintf("Nous sommes le %d %s %d et la saison est actuellement : %s", $jour, $mois, $annee, $saison);
echo "<hr>";

/*
 * === Consigne exo n°3 ===
 * Créer une variable nommée $bonAuPoker contenant un booléen (true/false) indiquant si vous êtes bon au poker.
 * Créer une variable nommée $espace contenant la valeur null.
 * Afficher un message indiquant si vous êtes bon au poker ou non.
 */


// ^ ^ Ecrivez votre solution au-dessus ^ ^
echo "<h1>Test d'exécution exercice n°3</h1>";
echo "Vous êtes " . ($bonAuPoker ? "" : "pas") . " bon au poker !<br>";
echo "La variable \$espace contient : " . (is_null($espace) ? "null" : "une valeur") . "<br>";
echo "<hr>";

/*
 * === Consigne exo n°4 (Bonus) ===
 * Créer une variable nommée $nombre1 contenant un nombre entier.
 * Créer une variable nommée $nombre2 contenant un autre nombre entier.
 * Afficher le résultat de l'addition de ces deux nombres.
 */

// ^ ^ Ecrivez votre solution au-dessus ^ ^
echo "<h1>Test d'exécution exercice n°4</h1>";
echo "Le résultat de l'addition entre ".$nombre1." et ".$nombre2." est : " . ($nombre1 + $nombre2) . "<br>";
?>