<?php
$infoUtilisateur = [
    'pseudo' => 'Alex',
    'email' => 'alexis.legras@masolutionformation.com',
    'age' => 25,
];

foreach ($infoUtilisateur as $clef => $valeur) {
    echo "<b>".$clef."</b> de mon utilisateur est utilisateur <b>".$valeur."</b><br>";
}

