# Support de Travaux Dirigés : Projet Cinéma "TMDB Explorer"


## Développement d'une application web cinéma avec Composer et Guzzle

| Élément | Détails |
| :-- | :-- |
| **Titre** | Application web cinéma avec Composer, Guzzle et TMDB API |
| **Compétence RNCP** | BC02.7 – Intégrer et gérer des bibliothèques tierces côté serveur |
| **Niveau** | Débutant intermédiaire |
| **Durée** | 4h guidées + 2h atelier libre |
| **Prérequis** | POO PHP, fonctions, includes |

## 🎯 Objectifs pédagogiques

À l'issue de ce TD, vous serez capable de :

1. **Installer et configurer Composer** pour gérer les dépendances PHP
2. **Utiliser Guzzle HTTP** pour effectuer des requêtes vers l'API TMDB
3. **Gérer la configuration** avec des fichiers .env
4. **Intégrer une API externe** pour afficher des données cinéma
5. **Créer des templates HTML** dynamiques avec PHP
6. **Implémenter une fonctionnalité de recherche** complète
7. **Développer un système de pagination** robuste

## 📋 Structure du projet à réaliser

```
tmdb-project/
├── public/
│   └── index.php                 # Point d'entrée avec routage
├── includes/
│   ├── actions.php              # Fonctions de traitement des actions
│   ├── tmdbClient.php           # Client API TMDB avec Guzzle
│   └── htmlMaker.php            # Génération du HTML
├── templates/
│   ├── header.php               # Template d'en-tête
│   └── footer.php               # Template de pied de page
├── .env                         # Variables d'environnement et configuration
├── composer.json
└── vendor/                      # Dépendances Composer
```


## 🚀 Phase 1 : Installation et configuration (30 min)

### Étape 1.1 : Initialisation du projet

```bash
# Créer le répertoire projet
mkdir tmdb-project && cd tmdb-project

# Initialiser Composer
composer init
```


### Étape 1.2 : Installation de Guzzle

```bash
composer require guzzlehttp/guzzle
```


### Étape 1.3 : Configuration avec fichier .env

**📝 Créer le fichier `.env` à la racine du projet :**

```ini
APP_NAME="Six Nez Mat"

TMDB_READ_API_KEY=votre_cle_read_api_ici
TMDB_API_KEY=votre_cle_api_ici
```

**⚠️ Important :**

- Ajoutez `.env` dans votre `.gitignore` pour la sécurité
- Récupérez vos clés API sur [TMDB](https://www.themoviedb.org/settings/api)


### Étape 1.4 : Configuration des constantes par défaut

**📝 Dans vos fichiers includes, vous utiliserez :**

```php
define("DEFAULT_HEADER_OPTIONS", [
    'accept' => 'application/json',
    'Content-Type' => 'application/json'
]);

define("DEFAULT_QUERY_OPTIONS", [
    'api_key' => ENV['TMDB_API_KEY'],
    'language' => 'fr-FR'
]);
```


## 🔧 Phase 2 : Point d'entrée et chargement de configuration (45 min)

### Étape 2.1 : Configuration du point d'entrée

**📁 Créer `public/index.php` :**

```php
<?php
define('ROOT', dirname(__DIR__));
require_once ROOT . '/vendor/autoload.php';

// TODO: Charger la configuration depuis le fichier .env
// Utilisez : define("ENV", parse_ini_file(ROOT."/.env"));

require_once ROOT . '/includes/actions.php';

/**
 * TODO: Implémenter le routage avec match/switch
 * 
 * Actions à gérer :
 * - 'detail' => appeler getAndDisplayMovieDetail($_GET['id'])
 * - 'search' => appeler getAndDisplaySearchResults($_GET['query'], $_GET['page'] ?? 1)
 * - par défaut => appeler getAndDisplayTrendingMovies($_GET['page'] ?? 1)
 * 
 * Le résultat de chaque action doit être stocké dans $pageData
 */

$pageData = match ($_GET['action'] ?? 'trending') {
    'detail' => getAndDisplayMovieDetail($_GET['id']),
    'search' => getAndDisplaySearchResults($_GET['query'] ?? '', $_GET['page'] ?? 1),
    default => getAndDisplayTrendingMovies($_GET['page'] ?? 1),
};

require_once ROOT."/templates/header.php";
?>

<div class="container">
    <?= $pageData['content'] ?>
</div>

<?php require_once ROOT."/templates/footer.php"; ?>
```


### Étape 2.2 : Développement du client TMDB

**📁 Créer `includes/tmdbClient.php` :**

```php
<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// TODO: Définir DEFAULT_HEADER_OPTIONS et DEFAULT_QUERY_OPTIONS
// Utilisez ENV['TMDB_API_KEY'] pour la clé API

/**
 * TODO: Créer une fonction getTMDBGuzzleClient(): Client
 * - Retourner une instance de Client Guzzle
 * - Configurer base_uri vers 'https://api.themoviedb.org/3/'
 * - Définir un timeout de 30 secondes  
 * - Activer la vérification SSL (verify: true)
 */

/**
 * TODO: Créer une fonction getTrendingMovies(Client $guzzleClient, $page = 1)
 * - Effectuer une requête GET vers 'trending/movie/day'
 * - Utiliser DEFAULT_HEADER_OPTIONS pour les headers
 * - Utiliser DEFAULT_QUERY_OPTIONS + 'page' => $page pour les paramètres
 * - Retourner json_decode($response->getBody()->getContents(), true)
 * - Gérer les exceptions avec try/catch et afficher l'erreur
 */

/**
 * TODO: Créer une fonction getMovieDetail(Client $guzzleClient, string|int $movieId)
 * - Effectuer une requête GET vers 'movie/'.$movieId  
 * - Utiliser DEFAULT_HEADER_OPTIONS pour les headers
 * - Utiliser DEFAULT_QUERY_OPTIONS pour les paramètres
 * - Retourner json_decode($response->getBody()->getContents(), true)
 * - Gérer les exceptions avec try/catch et afficher l'erreur
 */

/**
 * TODO: Créer une fonction searchMovies(Client $guzzleClient, string $query, $page = 1)
 * - Effectuer une requête GET vers 'search/movie'
 * - Utiliser DEFAULT_HEADER_OPTIONS pour les headers
 * - Utiliser DEFAULT_QUERY_OPTIONS + 'query' => $query + 'page' => $page pour les paramètres
 * - Encoder correctement la requête de recherche
 * - Retourner json_decode($response->getBody()->getContents(), true)
 * - Gérer les exceptions avec try/catch et afficher l'erreur
 */
```


## 🎨 Phase 3 : Templates et génération HTML (60 min)

### Étape 3.1 : Template d'en-tête avec barre de recherche

**📁 Créer `templates/header.php` :**

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageData['title'] ?? ENV['APP_NAME'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- TODO: Ajouter le nom de l'application depuis ENV['APP_NAME'] -->
            <a class="navbar-brand" href="/"><?= ENV['APP_NAME'] ?></a>
            
            <!-- TODO: Ajouter un formulaire de recherche -->
            <!-- 
            Structure suggérée :
            <form class="d-flex ms-auto" method="GET">
                <input type="hidden" name="action" value="search">
                <input class="form-control me-2" type="search" name="query" placeholder="Rechercher un film..." value="...">
                <button class="btn btn-outline-light" type="submit">Rechercher</button>
            </form>
            -->
        </div>
    </nav>
    <main class="container mt-4">
        <h1><?= $pageData['title'] ?? ENV['APP_NAME'] ?></h1>
```

**📁 Créer `templates/footer.php` :**

```php
    </main>
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p>&copy; 2025 <?= ENV['APP_NAME'] ?> - Données fournies par TMDB</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```


### Étape 3.2 : Générateur HTML pour les films

**📁 Créer `includes/htmlMaker.php` :**

```php
<?php
// TODO: Définir les constantes suivantes
define('IMG_WIDTH', 200);
define('MOVIE_TITLE_MAX_LENGTH', 50);
define('MOVIE_OVERVIEW_MAX_LENGHT', 150);

/**
 * TODO: Créer une fonction makeMovieCard(array $movieArray): string
 * 
 * Votre fonction doit :
 * - Utiliser une fonction interne pour tronquer le texte : 
 *   $truncateText = fn($text, $maxLength) => strlen($text) > $maxLength ? substr($text, 0, $maxLength) . '...' : $text;
 * - Créer un tableau $data avec :
 *   - 'imgWidth' => IMG_WIDTH
 *   - 'posterPath' => htmlspecialchars($movieArray['poster_path'])
 *   - 'title' => htmlspecialchars($truncateText($movieArray['title'], MOVIE_TITLE_MAX_LENGTH))
 *   - 'overview' => htmlspecialchars($truncateText($movieArray['overview'], MOVIE_OVERVIEW_MAX_LENGHT))
 *   - 'id' => (int) $movieArray['id']
 * - Utiliser sprintf() pour générer le HTML d'une carte Bootstrap
 * - Inclure un lien "Voir les détails" vers ?action=detail&id={id}
 */

/**
 * TODO: Créer une fonction makeMovieGallery(array $movies): string
 * 
 * Votre fonction doit :
 * - Créer une div avec class="row g-3"
 * - Pour chaque film, créer une div class="col-3"
 * - Appeler makeMovieCard() pour chaque film dans la colonne
 * - Fermer la div row
 * - Retourner le HTML complet
 */

/**
 * TODO: Créer une fonction makePagination(int $currentPage, int $totalPages, array $queryParams = []): string
 * 
 * Votre fonction doit :
 * - Générer une navigation Bootstrap de pagination
 * - Afficher les pages adjacentes (ex: 1...4,5,6,7,8...20)
 * - Gérer les cas limites (première page, dernière page)
 * - Conserver les paramètres de recherche dans les liens
 * - Désactiver les liens "Précédent" et "Suivant" si nécessaire
 * 
 * Structure suggérée :
 * <nav aria-label="Navigation des pages">
 *   <ul class="pagination justify-content-center">
 *     <li class="page-item"><a class="page-link" href="...">Précédent</a></li>
 *     <li class="page-item active"><a class="page-link" href="...">1</a></li>
 *     ...
 *   </ul>
 * </nav>
 */

/**
 * TODO: Créer une fonction makeSearchResultsHeader(string $query, int $totalResults): string
 * 
 * Votre fonction doit :
 * - Générer un header informatif pour les résultats de recherche
 * - Afficher le terme recherché et le nombre de résultats
 * - Proposer un lien de retour vers l'accueil si aucun résultat
 * 
 * Structure suggérée :
 * <div class="alert alert-info">
 *   <h4>Résultats pour "{query}"</h4>
 *   <p>{totalResults} film(s) trouvé(s)</p>
 * </div>
 */

/**
 * TODO: Créer une fonction makeMovieDetail(array $movieData): string
 * 
 * Cette fonction est complexe et doit générer un HTML détaillé utilisant :
 * - Les fonctions utilitaires pour formater les données
 * - sprintf() avec de nombreux paramètres pour le template HTML
 * - Les données de l'API TMDB directement (backdrop_path, poster_path, etc.)
 * 
 * Fonctions utilitaires à créer dans la fonction :
 * - $formatGenres, $formatCompanies, $formatCountries, $formatLanguages
 * - $formatRuntime pour convertir minutes en heures/minutes  
 * - $formatBudget pour formater les montants
 * 
 * Sections à inclure :
 * - Hero section avec backdrop_path en arrière-plan
 * - Informations principales avec poster_path
 * - Synopsis complet
 * - Informations techniques
 * - Box office (budget/revenue)
 * - Informations de production
 * - Collection si belongs_to_collection existe
 * - Liens externes (IMDB, homepage) si disponibles
 */
```


## ⚙️ Phase 4 : Actions métier avec recherche (60 min)

### Étape 4.1 : Fonctions d'actions complètes

**📁 Créer `includes/actions.php` :**

```php
<?php
require_once 'tmdbClient.php';
require_once 'htmlMaker.php';

/**
 * TODO: Créer une fonction getAndDisplayTrendingMovies($page = 1)
 * 
 * Votre fonction doit :
 * - Appeler getTMDBGuzzleClient() pour obtenir le client
 * - Appeler getTrendingMovies($guzzleClient, $page) pour récupérer les films
 * - Générer la pagination avec makePagination()
 * - Retourner un tableau avec :
 *   - 'title' => 'Nouveauté - Page ' . $page
 *   - 'content' => makeMovieGallery($apiResult['results']) . makePagination($page, $apiResult['total_pages'])
 */

/**
 * TODO: Créer une fonction getAndDisplayMovieDetail(string|int $movieId)
 * 
 * Votre fonction doit :
 * - Appeler getTMDBGuzzleClient() pour obtenir le client
 * - Appeler getMovieDetail($guzzleClient, $movieId) pour récupérer le film
 * - Retourner un tableau avec :
 *   - 'title' => $apiResult['original_title']
 *   - 'content' => makeMovieDetail($apiResult)
 */

/**
 * TODO: Créer une fonction getAndDisplaySearchResults(string $query, int $page = 1)
 * 
 * Votre fonction doit :
 * - Vérifier que $query n'est pas vide
 * - Si vide, rediriger vers l'accueil ou afficher un message d'erreur
 * - Appeler getTMDBGuzzleClient() pour obtenir le client
 * - Appeler searchMovies($guzzleClient, $query, $page) pour effectuer la recherche
 * - Générer la pagination avec les paramètres de recherche conservés
 * - Retourner un tableau avec :
 *   - 'title' => 'Résultats de recherche pour : ' . $query . ' - Page ' . $page
 *   - 'content' => makeSearchResultsHeader($query, $apiResult['total_results']) . 
 *                  makeMovieGallery($apiResult['results']) . 
 *                  makePagination($page, $apiResult['total_pages'], ['action' => 'search', 'query' => $query])
 * 
 * Gestion des cas particuliers :
 * - Si aucun résultat trouvé, afficher un message approprié
 * - Échapper les caractères spéciaux dans $query pour l'affichage
 */
```


## 🔍 Phase 5 : Travail en autonomie - Recherche avancée

**Mission à réaliser en autonomie :**

Maintenant que vous avez les bases, implémentez une fonctionnalité de recherche complète en suivant ces spécifications :

### Fonctionnalités à implémenter :

1. **Formulaire de recherche dans le header**
    - Champ de saisie avec placeholder
    - Conservation du terme recherché après soumission
    - Validation côté client (minimum 2 caractères)
2. **Traitement de la recherche**
    - Fonction `searchMovies()` dans `tmdbClient.php`
    - Gestion des erreurs API
    - Support de la pagination
3. **Affichage des résultats**
    - Header informatif avec nombre de résultats
    - Réutilisation de `makeMovieGallery()` pour l'affichage
    - Message si aucun résultat trouvé
    - Navigation par pages avec conservation de la recherche

### Critères de réussite :

- ✅ Le formulaire fonctionne depuis toutes les pages
- ✅ Les résultats s'affichent correctement avec pagination
- ✅ La recherche gère les caractères spéciaux
- ✅ Les paramètres de recherche sont conservés dans la pagination
- ✅ Les erreurs sont gérées proprement
- ✅ L'interface reste cohérente avec le reste de l'application


## 📖 Phase 6 : Travail en autonomie - Système de pagination

**Seconde mission en autonomie :**

Développez un système de pagination complet pour l'application en suivant ces spécifications :

### Fonctionnalités à implémenter :

1. **Pagination de la page d'accueil (films tendance)**
    - Navigation entre les pages de films tendance
    - Affichage du numéro de page dans le titre
    - Gestion des cas limites (page 1, dernière page)
2. **Pagination des résultats de recherche**
    - Conservation du terme de recherche dans tous les liens
    - Navigation cohérente avec la recherche
    - Affichage du contexte (page X sur Y résultats)
3. **Interface de navigation**
    - Boutons "Précédent" et "Suivant"
    - Numéros de pages (avec ellipses si nécessaire)
    - Page courante mise en évidence
    - Liens désactivés pour les actions impossibles

### Spécifications techniques :

```php
// Structure de pagination Bootstrap suggérée
<nav aria-label="Navigation des pages" class="mt-4">
    <ul class="pagination justify-content-center">
        <!-- Lien Précédent -->
        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $previousUrl ?>">Précédent</a>
        </li>
        
        <!-- Pages numérotées -->
        <?php if ($currentPage > 3): ?>
            <li class="page-item"><a class="page-link" href="<?= $firstPageUrl ?>">1</a></li>
            <?php if ($currentPage > 4): ?>
                <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- Pages adjacentes -->
        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="<?= $pageUrl($i) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        
        <!-- Ellipses et dernière page -->
        <?php if ($currentPage < $totalPages - 2): ?>
            <?php if ($currentPage < $totalPages - 3): ?>
                <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
            <li class="page-item"><a class="page-link" href="<?= $lastPageUrl ?>"><?= $totalPages ?></a></li>
        <?php endif; ?>
        
        <!-- Lien Suivant -->
        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $nextUrl ?>">Suivant</a>
        </li>
    </ul>
</nav>
```


### Fonctions utilitaires à créer :

```php
/**
 * Générer l'URL pour une page donnée en conservant les paramètres
 */
function buildPageUrl(int $page, array $params = []): string
{
    $params['page'] = $page;
    return '?' . http_build_query($params);
}

/**
 * Calculer la plage de pages à afficher
 */
function calculatePageRange(int $currentPage, int $totalPages, int $maxVisible = 5): array
{
    $startPage = max(1, $currentPage - floor($maxVisible / 2));
    $endPage = min($totalPages, $startPage + $maxVisible - 1);
    
    // Ajuster le début si on est près de la fin
    if ($endPage - $startPage + 1 < $maxVisible) {
        $startPage = max(1, $endPage - $maxVisible + 1);
    }
    
    return ['start' => $startPage, 'end' => $endPage];
}
```


### Critères de réussite pour la pagination :

- ✅ Navigation fluide entre les pages d'accueil
- ✅ Pagination fonctionnelle sur les résultats de recherche
- ✅ Conservation des paramètres GET dans tous les liens
- ✅ Interface intuitive avec états disabled/active
- ✅ Gestion des cas limites (1 seule page, page inexistante)
- ✅ Performance optimisée (pas de requêtes inutiles)


### Données TMDB pour la pagination :

```php
// Structure de réponse API avec informations de pagination
[
    "page" => 1,              // Page courante
    "results" => [...],       // Résultats de la page
    "total_pages" => 500,     // Nombre total de pages
    "total_results" => 10000  // Nombre total de résultats
]
```


### Validation et sécurité :

```php
// Validation du numéro de page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Minimum page 1

// Dans les fonctions d'API, vérifier les limites
if ($page > $apiResult['total_pages']) {
    // Rediriger vers la dernière page ou afficher erreur
}
```


## 🎯 Tâches Bonus étendues (Niveaux avancés)

### 🥉 Bonus Niveau 1 : Amélioration de l'interface de pagination

**Missions :**

- Ajouter un sélecteur "Films par page" (20, 40, 60)
- Implémenter le "scroll infini" avec JavaScript
- Ajouter des raccourcis clavier (flèches gauche/droite)
- Créer une mini-pagination en haut ET en bas des résultats


### 🥈 Bonus Niveau 2 : Analytics et optimisation

**Missions :**

- Tracker les pages les plus visitées
- Pré-charger la page suivante en arrière-plan
- Implémenter un cache intelligent par page
- Ajouter des métadonnées de pagination (OpenGraph, JSON-LD)


### 🥇 Bonus Niveau 3 : Pagination avancée

**Missions :**

- Système de pagination avec URL SEO-friendly (/films/page/2/)
- Pagination AJAX sans rechargement de page
- Sauvegarde de la position de scroll
- Navigation par clavier complète (Tab, Enter, Espace)


### 🏆 Bonus Niveau 4 : Performance et UX

**Missions :**

- Pagination adaptative selon la taille d'écran
- Preloading des images de la page suivante
- Système de pagination "smart" (plus de résultats sur desktop)
- Indicateur de progression pour les longues listes


## 📚 Ressources pour la pagination

### API TMDB - Paramètres de pagination

```bash
# Films tendance avec pagination
GET /trending/movie/day?api_key={key}&language=fr-FR&page={page}

# Recherche avec pagination
GET /search/movie?api_key={key}&language=fr-FR&query={terme}&page={page}

# Limites API TMDB
- Page maximum : 500 (après, erreur 422)
- Résultats par page : 20 (fixe, non configurable)
- Total résultats maximum : 10,000
```


### Construction d'URLs avec paramètres

```php
// Fonction utilitaire pour construire les URLs
function buildUrl(array $params): string
{
    $baseUrl = $_SERVER['PHP_SELF'];
    $queryString = http_build_query($params);
    return $baseUrl . ($queryString ? '?' . $queryString : '');
}

// Exemples d'utilisation
$searchPageUrl = buildUrl(['action' => 'search', 'query' => 'matrix', 'page' => 2]);
$homePageUrl = buildUrl(['page' => 3]);
```


### Gestion des erreurs de pagination

```php
// Validation robuste des pages
function validatePage(int $page, int $totalPages): int
{
    if ($page < 1) return 1;
    if ($page > $totalPages) return $totalPages;
    return $page;
}

// Gestion d'erreur si page inexistante
if ($page > $apiResult['total_pages'] && $apiResult['total_pages'] > 0) {
    // Redirection 301 vers la dernière page
    header('Location: ' . buildUrl(['page' => $apiResult['total_pages']]), true, 301);
    exit;
}
```


## ✅ Critères d'évaluation mis à jour

| Critère | Points | Description |
| :-- | :-- | :-- |
| **Configuration .env** | 2 pts | Chargement et utilisation correcte |
| **Client API Guzzle** | 3 pts | Requêtes HTTP avec configuration |
| **Génération HTML** | 4 pts | Templates et fonctions HTML |
| **Routage et actions** | 3 pts | Navigation fonctionnelle |
| **Fonctionnalité de recherche** | 3 pts | Recherche complète et fonctionnelle |
| **Système de pagination** | 3 pts | Pagination accueil et recherche |
| **Qualité du code** | 2 pts | Structure, lisibilité, utilisation ENV |
| **Bonus réalisés** | +0 à 10 pts | Fonctionnalités supplémentaires |


## 📝 Livrables attendus

1. **Code source complet** avec recherche et pagination
2. **Application fonctionnelle** permettant de naviguer dans tous les contenus
3. **Fichier README.md** avec documentation complète
4. **Démonstration** de toutes les fonctionnalités implémentées


**Remarques importantes pour les deux missions en autonomie :**

- **Recherche :** Doit être accessible depuis toutes les pages avec conservation des paramètres
- **Pagination :** Doit fonctionner tant sur l'accueil que sur les résultats de recherche
- Gérez tous les cas d'erreur (pages inexistantes, termes vides, erreurs API)
- Maintenez la cohérence visuelle et l'expérience utilisateur
- Testez extensively avec différents scenarios (première page, dernière page, recherches longues)
- Optimisez les performances (évitez les requêtes inutiles)
