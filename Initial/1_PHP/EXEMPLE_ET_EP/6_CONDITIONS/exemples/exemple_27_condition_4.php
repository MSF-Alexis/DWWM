<?php
$couleur = "rouge";
switch ($couleur) {
    case "rouge":
        echo "Votre starter pour cette aventure sera salamèche";
        break;
    case "bleu":
        echo "Votre starter pour cette aventure sera carapuce";
        break;
    case "vert":
        echo "Votre starter pour cette aventure sera bulbizar";
        break;
    default:
        echo "Votre couleur est trop compliquée. Votre starter pour cette aventure sera chenipotte";
        break;
}
echo "<br>";
$jour = "Samedi";
switch ($jour) {
    case 'Lundi':
        echo "Super c'est lundi";
        break;
    case 'Mardi':
        echo "Salut everybody tout le monde c'est mardi, c'est bientôt le week-end";
        break;
    case 'Mercredi':
        echo "Mercredi c'est ravioli";
        break;
    case 'Jeudi':
        echo "Jeudi pluvieux, jeudi heureux";
        break;
    case 'Vendredi':
        echo "C'est le dernière jour avant le week-end vivre le vendredi !";
        break;
    default:
        echo "C'est le week-end !!!!!";
        break;
}