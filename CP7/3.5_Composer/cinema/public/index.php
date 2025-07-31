<?php
// Chemin racine du projet
define("ROOT", str_replace("/public", "", __DIR__));
// Lecture du fichier .env pour récupérer les variables d'environnements du fichier
define("ENV", parse_ini_file(ROOT . "/.env"));
// Chargement du dossier des librairies téléchargés par composer
require_once ROOT . "/includes/actions.php";

$bodyContent = match (true) {
    isset($_GET['action']) && $_GET['action'] === 'detail' && isset($_GET['id']) =>
    getAndDisplayMovieDetail((int) $_GET['id']),
    isset($_GET['action']) && $_GET['action'] === 'search' && isset($_GET['query']) =>
    getAndDisplaySearchResults(),
    default =>
    getAndDisplayTrendingMovies(),
};


require_once ROOT . "/templates/header.php";

?>
<div class="m-3">
    <div class="container">
        <?= $bodyContent['content'] ?>
    </div>
</div>
<?php
require_once ROOT . "/templates/footer.php";
?>