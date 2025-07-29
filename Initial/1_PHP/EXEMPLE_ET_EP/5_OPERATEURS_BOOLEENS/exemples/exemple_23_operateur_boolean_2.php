<?php
$ageUtilisateur = 17;
$utilisateurMajeur = $ageUtilisateur >= 18;
$ageDuParentDeLutilisateur = 40;
$parentMajeur = $ageDuParentDeLutilisateur >= 18;

var_dump($utilisateurMajeur || $ageDuParentDeLutilisateur);
// Revient à écrire $ageUtilisateur >= 18 || $ageDuParentDeLutilisateur >= 18