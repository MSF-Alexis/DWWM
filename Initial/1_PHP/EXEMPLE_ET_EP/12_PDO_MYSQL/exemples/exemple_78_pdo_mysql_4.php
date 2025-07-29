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
    $requete = "INSERT INTO users (username, email, password_hash) values (:pseudonyme, :mail, :mdp_hashe)";
    $delcaration = $connexionBDD->prepare($requete);
    $delcaration->execute([
        'pseudonyme' => 'alexl',
        'mail' => 'alexis.l.msf@gmail.com',
        'mdp_hashe' => '$2y$10$V/Ka5YJvW1eLq1kQ9Zr0uJf7KQZJ9Xl3dYb6WYc5RvJ1XrV2YhL6',
    ]);
} catch (\Throwable $th) {
    die($th->getMessage());
}

