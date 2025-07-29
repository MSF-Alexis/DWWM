<?php
$connexionBDD = null;
$hote = "mysql:host=learning-env-mariadb-dev-1;dbname=main-database";
$utilisateur = "root";
$motDePasse = "my-secret-pw";
try {
    $connexionBDD = new PDO($hote, $utilisateur, $motDePasse);
} catch (\Throwable $th) {
    die($th->getMessage());
}

try {
    $requete = "UPDATE users SET username = :username_value WHERE id = :id_value";
    $delcaration = $connexionBDD->prepare($requete);
    $delcaration->execute([
        'username_value' => 'alexisl-76000',
        'id_value' => 4
    ]);
} catch (\Throwable $th) {
    die($th->getMessage());
}

