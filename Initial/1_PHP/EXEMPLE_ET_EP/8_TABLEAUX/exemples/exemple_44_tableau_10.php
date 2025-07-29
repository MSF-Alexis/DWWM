<?php
$infoUtilisateur = [
    'pseudo' => 'Alex',
    'email' => 'alexis.legras@masolutionformation.com',
    'age' => 25,
];
echo '<pre>';
print_r($infoUtilisateur);
// Ajouter une clé 
$infoUtilisateur['motDePasse'] = 'motdepassesupersecretdelamortquitue76000!!!';
// Modifier une clé
$infoUtilisateur['pseudo'] = 'Alexxela';
// Supprimer une clé
unset($infoUtilisateur['age']);
print_r($infoUtilisateur);
echo '</pre>';

