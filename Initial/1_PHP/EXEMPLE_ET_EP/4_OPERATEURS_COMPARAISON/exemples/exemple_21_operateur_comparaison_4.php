<?php
$ageUtilisateur = 21;
$boiteTestEstCeQueUtilisateurMajeur = $ageUtilisateur >= 18;
$boiteTestEstCeQueUtilisateurMineurAuxUSA = $ageUtilisateur < 21;
var_dump($boiteTestEstCeQueUtilisateurMajeur);
var_dump($boiteTestEstCeQueUtilisateurMineurAuxUSA);
