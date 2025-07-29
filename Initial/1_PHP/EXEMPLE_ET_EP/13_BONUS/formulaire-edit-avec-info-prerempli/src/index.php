<?php
    // On récupère les fonctions du fichier pour pouvoir les utilisers
    // dans le fichier actuel 
    require_once('./fonctions/testeurUrl.php');
    
    $produitRecupererDepuisURL = null;
    if (estCeQuIlYaUnIdDansLUrl() && estCeQueLIdDansLUrlestBienUnNombre()) {
        require_once('./fonctions/fonctionBdd.php');
        $connexionBDD = connexionBDD();
        $produitRecupererDepuisURL = recupererUnProduitParId($connexionBDD, $_GET['id']);
        die(var_dump($produitRecupererDepuisURL));
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon beau formulaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .hero {
            background-image: url('https://picsum.photos/1600/400');
            height: 50%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
    </style>
</head>

<body class="bg-dark">
    <header class="hero text-center py-5 mb-5">
        <div class="container bg-dark bg-opacity-50 rounded">
            <h1 class="display-4 text-light fw-light p-2">Formulaire
                <!-- On test si il y a quelque chose dans l'url  -->
                <!-- Et non vide pour afficher le texte adéquat -->
                <?php if (estCeQuIlYaUnIdDansLUrl() && estCeQueLIdDansLUrlestBienUnNombre()): ?>
                    de modification
                <?php else : ?>
                    d'ajout
                <?php endif; ?>
                d'un produit</h1>
        </div>
    </header>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <form class="bg-black rounded-3 p-4 shadow-lg" action="./traitementProduit.php" method="POST">
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label text-light">Nom</label>
                        <input type="text" name="name-input" class="form-control bg-dark border-dark text-light" id="champNom">
                    </div>
                    <div class="mb-3">
                        <label for="inputPrice" class="form-label text-light">Prix</label>
                        <input type="number" step="0.01" name="price-input" class="form-control bg-dark border-dark text-light" id="champPrix">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block rounded-pill">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>