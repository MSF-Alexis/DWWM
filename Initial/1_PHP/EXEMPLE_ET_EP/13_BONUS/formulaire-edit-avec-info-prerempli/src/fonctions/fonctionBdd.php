<?php
/**
 * Renvoie la connexion de la base de données ou un message au format string en cas d'erreur
 *
 * @return string | PDO
 */
function connexionBDD()
{
    $connexionBDD = null;
    $hote = "mysql:host=learning-env-mariadb-dev-1;dbname=shop_database";
    $utilisateur = "root";
    $motDePasse = "my-secret-pw";
    try {
        $connexionBDD = new PDO($hote, $utilisateur, $motDePasse);
    } catch (\Throwable $th) {
        die($th->getMessage());
    }
    return $connexionBDD;
}

/*
* Renvoie un message d'erreur au format string en cas d'erreur d'insertion
*/
function insererUnProduit (PDO $connexionBDD, $name, $price) {
    try{
        $requete = $connexionBDD->prepare('INSERT INTO products (name, price) VALUE (:nameVal, :priceVal)');
        $requete->execute([
            'nameVal' => $name,
            'priceVal' => $price * 100, // On multiplie par 100 car la colonne price est un int (entier naturel = pas de virgule ), et multiplié par 100 revient à retirer la virgule 
            // mais il faudra diviser de nouveau par 100 pour récupérer le prix sous format xx, xx €
        ]);
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
}

function recupererUnProduitParId(PDO $connexionBDD, $id) {
    try {
        $requete = $connexionBDD->prepare('SELECT id, name, (price / 100) as price FROM products WHERE id = :valId');
        $requete->execute([
            'valId' => $id
        ]);
        return $requete->fetch(PDO::FETCH_ASSOC);
        
    } catch (\Throwable $th ) {
        return $th->getMessage();
    }
}