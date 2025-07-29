<?php
/**
 * Renvoie la connexion de la base de données ou un message au format string en cas d'erreur
 *
 * @return string | PDO
 */
function connexionBDD()
{
    $connexionBDD = null;
    $hote = "mysql:host=learning-env-mariadb-dev-1;dbname=main_database";
    $utilisateur = "root";
    $motDePasse = "my-secret-pw";
    try {
        $connexionBDD = new PDO($hote, $utilisateur, $motDePasse);
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
    return $connexionBDD;
}

/*
* Renvoie un message d'erreur au format string en cas d'erreur d'insertion
*/
function insererUnUtilisateur (PDO $connexionBDD, $username, $email, $password) {
    try{
        $requete = $connexionBDD->prepare('INSERT INTO users (email, username, hash_password) VALUE (:valueEmail, :valueUsername, :valuePassword)');
        $requete->execute([
            'valueEmail' => $email,
            'valueUsername' => $username,
            'valuePassword' => hash('sha512', "123!".$password."plop@"), // Grain de sel
        ]);
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
}

/**
 * Renvoie un tableau d'utilisateur ou fait crash le site en cas d'erreur
 *
 * @param PDO $connexionBDD
 * @return array
 */
function recupererUtilisateurs(PDO $connexionBDD){
    try {
        $requete = $connexionBDD->prepare('SELECT * from users');
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        die($th);
    }
}
/**
 * Renvoie rien ou fait crash le site en cas d'erreur
 *
 * @param PDO $connexionBDD
 * @return void
 */
function supprimerUnUtilisateur(PDO $connexionBDD, $id){
    try {
        $requete = $connexionBDD->prepare('DELETE FROM users WHERE id = :valueId');
        $requete->execute([
            'valueId' => $id
        ]);
    } catch (\Throwable $th) {
        die($th);
    }
}