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

$delcaration = $connexionBDD->query("SELECT * FROM users");
$users = $delcaration->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
foreach($users as $cle => $valeur){
    print_r($valeur);
}
echo "</pre>";

