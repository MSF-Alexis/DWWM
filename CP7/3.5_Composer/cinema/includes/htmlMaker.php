<?php
define('MOVIE_OVERVIEW_MAX_LENGHT', 100);
define('MOVIE_TITLE_MAX_LENGTH', 25);
define('IMG_WIDTH', 400);

function makeMovieCard(array $movieArray): string
{
    $truncateText = fn(string $text, int $maxLength): string =>
    strlen($text) > $maxLength ? substr($text, 0, $maxLength) . '...' : $text;

    $data = [
        'imgWidth' => IMG_WIDTH,
        'posterPath' => htmlspecialchars($movieArray['poster_path'] ?? ''),
        'title' => htmlspecialchars($truncateText($movieArray['title'], MOVIE_TITLE_MAX_LENGTH)),
        'overview' => htmlspecialchars($truncateText($movieArray['overview'], MOVIE_OVERVIEW_MAX_LENGHT)),
        'id' => (int) $movieArray['id']
    ];

    return sprintf(
        "<div class='card h-100 w-100'>
            <div class='card-img-container' style='height: 400px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;'>
                <img class='card-img-top' 
                     src='https://image.tmdb.org/t/p/w%d%s' 
                     alt='Image de couverture du film - %s' 
                     style='max-width: 100%%; max-height: 100%%; object-fit: contain;'>
            </div>
            <div class='card-body d-flex flex-column'>
                <h5 class='card-title'>%s</h5>
                <p class='card-text flex-grow-1'>%s</p>
                <a href='/public?action=detail&id=%d' class='btn btn-primary mt-auto'>Voir les détails</a>
            </div>
        </div>",
        $data['imgWidth'],
        $data['posterPath'],
        $data['title'],
        $data['title'],
        $data['overview'],
        $data['id']
    );
}





function makeMovieGallery(array $movies): string
{
    $resultHtml = "<div class='row g-3'>";
    foreach ($movies as $movie) {
        $resultHtml .= "<div class='col-xl-3 col-lg-4 col-md-6 col-sm-12 d-flex'>" . makeMovieCard($movie) . "</div>";
    }
    $resultHtml .= "</div>";
    return $resultHtml;
}

function makeMovieDetail(array $movieData): string
{
    // Validation des données essentielles
    if (empty($movieData['title'])) {
        return "<div class='alert alert-danger'>Erreur: Données du film invalides</div>";
    }

    // Fonctions utilitaires pour le formatage
    $formatGenres = fn(array $genres): string =>
    implode(', ', array_map(fn($genre) => htmlspecialchars($genre['name']), $genres));

    $formatCompanies = fn(array $companies): string =>
    implode(', ', array_map(fn($company) => htmlspecialchars($company['name']), $companies));

    $formatCountries = fn(array $countries): string =>
    implode(', ', array_map(fn($country) => htmlspecialchars($country['name']), $countries));

    $formatLanguages = fn(array $languages): string =>
    implode(', ', array_map(fn($lang) => htmlspecialchars($lang['english_name']), $languages));

    $formatRuntime = fn(?int $runtime): string =>
    $runtime ? sprintf('%dh %02dmin', intval($runtime / 60), $runtime % 60) : 'Non renseigné';

    $formatBudget = fn(?int $amount): string =>
    $amount && $amount > 0 ? number_format($amount, 0, ',', ' ') . ' $' : 'Non communiqué';

    // Extraction et formatage des données avec valeurs par défaut
    $backdropPath = $movieData['backdrop_path'] ?? '';
    $posterPath = $movieData['poster_path'] ?? '';
    $title = htmlspecialchars($movieData['title'] ?? '');
    $originalTitle = htmlspecialchars($movieData['original_title'] ?? '');
    $tagline = htmlspecialchars($movieData['tagline'] ?? '');
    $overview = htmlspecialchars($movieData['overview'] ?? 'Synopsis non disponible.');
    $releaseDate = $movieData['release_date'] ?? 'Non renseigné';
    $runtime = $formatRuntime($movieData['runtime'] ?? null);
    $voteAverage = number_format($movieData['vote_average'] ?? 0, 1);
    $voteCount = number_format($movieData['vote_count'] ?? 0, 0, ',', ' ');
    $popularity = number_format($movieData['popularity'] ?? 0, 1);
    $status = $movieData['status'] ?? 'Non renseigné';
    $adult = ($movieData['adult'] ?? false) ? 'Oui' : 'Non';
    $originalLanguage = strtoupper($movieData['original_language'] ?? '');
    $imdbId = !empty($movieData['imdb_id']) ? $movieData['imdb_id'] : null;
    $homepage = !empty($movieData['homepage']) ? $movieData['homepage'] : null;
    $budget = $formatBudget($movieData['budget'] ?? null);
    $revenue = $formatBudget($movieData['revenue'] ?? null);

    // Formatage des collections
    $genres = $movieData['genres'] ?? [];
    $companies = $formatCompanies($movieData['production_companies'] ?? []);
    $countries = $formatCountries($movieData['production_countries'] ?? []);
    $languages = $formatLanguages($movieData['spoken_languages'] ?? []);

    // Génération des badges pour les genres
    $genreBadges = '';
    if (!empty($genres)) {
        foreach ($genres as $genre) {
            $genreBadges .= "<span class='badge bg-primary fs-6 me-2 mb-1'>" . htmlspecialchars($genre['name']) . "</span>";
        }
    }

    // Calcul des bénéfices si possible
    $profitSection = '';
    $budgetValue = (int) str_replace([' ', '$', ','], '', $budget);
    $revenueValue = (int) str_replace([' ', '$', ','], '', $revenue);

    if ($budgetValue > 0 && $revenueValue > 0) {
        $profit = $revenueValue - $budgetValue;
        $profitClass = $profit >= 0 ? 'text-success' : 'text-danger';
        $profitSection = "<div class='col-12'>
            <h6 class='fw-bold text-success mb-2'>Bénéfices estimés</h6>
            <p class='fs-4 fw-bold {$profitClass}'>" . number_format($profit, 0, ',', ' ') . " $</p>
        </div>";
    }

    // Section collection
    $collectionSection = '';
    if (!empty($movieData['belongs_to_collection'])) {
        $collection = $movieData['belongs_to_collection'];
        $collectionPoster = !empty($collection['poster_path'])
            ? "<img src='https://image.tmdb.org/t/p/w300{$collection['poster_path']}' alt='Collection' class='img-fluid rounded mt-2'>"
            : '';

        $collectionSection = "<div class='card mb-4 shadow-lg'>
            <div class='card-header bg-secondary text-white py-3'>
                <h4 class='card-title h4 mb-0'><i class='fas fa-layer-group me-2'></i>Collection</h4>
            </div>
            <div class='card-body p-4'>
                <h6 class='fw-bold mb-2'>" . htmlspecialchars($collection['name']) . "</h6>
                {$collectionPoster}
            </div>
        </div>";
    }

    // Liens externes
    $imdbLink = $imdbId
        ? "<a href='https://www.imdb.com/title/{$imdbId}' target='_blank' class='btn btn-warning btn-lg w-100 mb-3'>
            <i class='fab fa-imdb me-2'></i> Voir sur IMDB
        </a>"
        : '';

    $homepageLink = $homepage
        ? "<a href='{$homepage}' target='_blank' class='btn btn-info btn-lg w-100'>
            <i class='fas fa-globe me-2'></i> Site officiel
        </a>"
        : '';

    // Sections optionnelles pour les informations techniques
    $imdbSection = $imdbId
        ? "<div class='col-md-6'>
            <h6 class='fw-bold text-info mb-2'>ID IMDB</h6>
            <p class='fs-6'>{$imdbId}</p>
        </div>"
        : '';

    $homepageSection = $homepage
        ? "<div class='col-md-6'>
            <h6 class='fw-bold text-info mb-2'>Site officiel</h6>
            <p class='fs-6'>
                <a href='{$homepage}' target='_blank' class='text-decoration-none'>
                    Visiter <i class='fas fa-external-link-alt'></i>
                </a>
            </p>
        </div>"
        : '';

    return sprintf(
        "<!-- Section Hero avec image de fond -->
        <div class='position-relative mb-5' style='height: 70vh; background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url(\"https://image.tmdb.org/t/p/original%s\") center/cover;'>
            <div class='container h-100 d-flex align-items-end'>
                <div class='text-white pb-5'>
                    <h1 class='display-2 fw-bold mb-3'>%s</h1>
                    %s
                    <div class='d-flex align-items-center flex-wrap mt-4'>
                        <span class='badge bg-warning text-dark me-3 fs-5 px-3 py-2 mb-2'>
                            <i class='fas fa-star'></i> %s/10
                        </span>
                        <span class='me-3 mb-2'>(%s votes)</span>
                        <span class='badge bg-info fs-6 px-3 py-1 me-3 mb-2'>%s</span>
                        <span class='mb-2'>%s</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class='container-fluid px-4'>
            <div class='row'>
                <!-- Colonne principale -->
                <div class='col-xl-8 col-lg-7'>
                    <!-- Carte des informations principales -->
                    <div class='card mb-5 shadow-lg'>
                        <div class='card-body p-4'>
                            <div class='row'>
                                <div class='col-lg-4 col-md-5'>
                                    <img src='https://image.tmdb.org/t/p/w500%s' 
                                         alt='Affiche - %s' 
                                         class='img-fluid rounded shadow-lg mb-4'
                                         onerror=\"this.src='https://via.placeholder.com/500x750/e9ecef/6c757d?text=Pas+d\\'affiche'\">
                                </div>
                                <div class='col-lg-8 col-md-7'>
                                    <h2 class='display-5 mb-4'>%s</h2>
                                    
                                    <div class='row g-4 mb-4'>
                                        <div class='col-md-6'>
                                            <h6 class='fw-bold text-primary mb-2'>Date de sortie</h6>
                                            <p class='fs-5'>%s</p>
                                        </div>
                                        <div class='col-md-6'>
                                            <h6 class='fw-bold text-primary mb-2'>Durée</h6>
                                            <p class='fs-5'>%s</p>
                                        </div>
                                        <div class='col-md-6'>
                                            <h6 class='fw-bold text-primary mb-2'>Statut</h6>
                                            <p class='fs-5'>%s</p>
                                        </div>
                                        <div class='col-md-6'>
                                            <h6 class='fw-bold text-primary mb-2'>Langue originale</h6>
                                            <p class='fs-5'>%s</p>
                                        </div>
                                        <div class='col-12'>
                                            <h6 class='fw-bold text-primary mb-2'>Titre original</h6>
                                            <p class='fs-5 fst-italic'>%s</p>
                                        </div>
                                        <div class='col-12'>
                                            <h6 class='fw-bold text-primary mb-2'>Contenu adulte</h6>
                                            <span class='badge %s fs-6'>%s</span>
                                        </div>
                                    </div>
                                    
                                    <div class='mb-4'>
                                        <h6 class='fw-bold text-primary mb-3'>Genres</h6>
                                        <div class='d-flex flex-wrap gap-2'>
                                            %s
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class='card mb-5 shadow-lg'>
                        <div class='card-header bg-primary text-white py-3'>
                            <h3 class='card-title h3 mb-0'><i class='fas fa-book-open me-2'></i>Synopsis complet</h3>
                        </div>
                        <div class='card-body p-4'>
                            <p class='fs-5 lh-lg'>%s</p>
                        </div>
                    </div>

                    <!-- Informations techniques -->
                    <div class='card mb-5 shadow-lg'>
                        <div class='card-header bg-info text-white py-3'>
                            <h3 class='card-title h3 mb-0'><i class='fas fa-cogs me-2'></i>Informations techniques</h3>
                        </div>
                        <div class='card-body p-4'>
                            <div class='row g-4'>
                                <div class='col-md-6'>
                                    <h6 class='fw-bold text-info mb-2'>Langues parlées</h6>
                                    <p class='fs-6'>%s</p>
                                </div>
                                <div class='col-md-6'>
                                    <h6 class='fw-bold text-info mb-2'>Popularité TMDB</h6>
                                    <p class='fs-6'>%s</p>
                                </div>
                                <div class='col-md-6'>
                                    <h6 class='fw-bold text-info mb-2'>ID TMDB</h6>
                                    <p class='fs-6'>#%s</p>
                                </div>
                                %s
                                %s
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class='col-xl-4 col-lg-5'>
                    <!-- Box Office -->
                    <div class='card mb-4 shadow-lg'>
                        <div class='card-header bg-success text-white py-3'>
                            <h4 class='card-title h4 mb-0'><i class='fas fa-dollar-sign me-2'></i>Box Office</h4>
                        </div>
                        <div class='card-body p-4'>
                            <div class='row g-4'>
                                <div class='col-12'>
                                    <h6 class='fw-bold text-success mb-2'>Budget de production</h6>
                                    <p class='fs-4 text-success fw-bold'>%s</p>
                                </div>
                                <div class='col-12'>
                                    <h6 class='fw-bold text-success mb-2'>Recettes mondiales</h6>
                                    <p class='fs-4 text-success fw-bold'>%s</p>
                                </div>
                                %s
                            </div>
                        </div>
                    </div>
                    
                    <!-- Production -->
                    <div class='card mb-4 shadow-lg'>
                        <div class='card-header bg-warning text-dark py-3'>
                            <h4 class='card-title h4 mb-0'><i class='fas fa-film me-2'></i>Production</h4>
                        </div>
                        <div class='card-body p-4'>
                            <div class='mb-4'>
                                <h6 class='fw-bold text-warning mb-3'>Sociétés de production</h6>
                                <div class='small lh-lg'>%s</div>
                            </div>
                            <div class='mb-4'>
                                <h6 class='fw-bold text-warning mb-3'>Pays de production</h6>
                                <div class='small lh-lg'>%s</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Collection (si applicable) -->
                    %s
                    
                    <!-- Actions -->
                    <div class='card shadow-lg'>
                        <div class='card-body p-4 text-center'>
                            <a href='/public' class='btn btn-outline-primary btn-lg w-100 mb-3'>
                                <i class='fas fa-arrow-left me-2'></i> Retour à la galerie
                            </a>
                            %s
                            %s
                        </div>
                    </div>
                </div>
            </div>
        </div>",

        // Arguments du sprintf dans l'ordre d'apparition
        $backdropPath,                                                // background image
        $title,                                                       // title h1
        $tagline ? "<p class='lead fs-4'>{$tagline}</p>" : '',      // tagline
        $voteAverage,                                                // rating
        $voteCount,                                                  // vote count
        $genres ? implode(', ', array_column($genres, 'name')) : 'Non renseigné', // genres inline
        $runtime,                                                    // runtime
        $posterPath,                                                 // poster image
        $title,                                                      // alt text
        $title,                                                      // title h2
        $releaseDate,                                               // release date
        $runtime,                                                    // runtime
        $status,                                                     // status
        $originalLanguage,                                           // original language
        $originalTitle,                                              // original title
        $adult === 'Oui' ? 'bg-danger' : 'bg-success',             // adult badge class
        $adult,                                                      // adult text
        $genreBadges,                                               // genre badges
        $overview,                                                   // overview
        $languages ?: 'Non renseigné',                              // spoken languages
        $popularity,                                                 // popularity
        $movieData['id'] ?? 'N/A',                                  // TMDB ID
        $imdbSection,                                               // IMDB section
        $homepageSection,                                           // homepage section
        $budget,                                                     // budget
        $revenue,                                                    // revenue
        $profitSection,                                             // profit section
        $companies ?: 'Non renseigné',                              // production companies
        $countries ?: 'Non renseigné',                              // production countries
        $collectionSection,                                         // collection section
        $imdbLink,                                                  // IMDB link
        $homepageLink                                               // homepage link
    );
}

function makePagination(int $currentPage = 1, int $totalPages = 1, array $queryParams = [], int $maxVisible = 7): string
{
    if ($totalPages <= 1) {
        return '';
    }

    $currentPage = max(1, min($currentPage, $totalPages));

    $buildUrl = function (int $page) use ($queryParams): string {
        $params = array_merge($queryParams, ['page' => $page]);
        return '?' . http_build_query($params);
    };

    $halfVisible = floor($maxVisible / 2);
    $startPage = max(1, $currentPage - $halfVisible);
    $endPage = min($totalPages, $startPage + $maxVisible - 1);

    if ($endPage - $startPage + 1 < $maxVisible) {
        $startPage = max(1, $endPage - $maxVisible + 1);
    }

    $html = "<nav aria-label='Navigation des pages' class='mt-4'>
        <ul class='pagination justify-content-center pagination-sm d-sm-none'>";

    $html .= sprintf(
        "<li class='page-item %s'>
            %s
        </li>
        <li class='page-item active'>
            <span class='page-link'>%d / %d</span>
        </li>
        <li class='page-item %s'>
            %s
        </li>",
        $currentPage <= 1 ? 'disabled' : '',
        $currentPage <= 1
            ? "<span class='page-link'>&laquo;</span>"
            : sprintf("<a class='page-link' href='%s'>&laquo;</a>", $buildUrl($currentPage - 1)),
        $currentPage,
        $totalPages,
        $currentPage >= $totalPages ? 'disabled' : '',
        $currentPage >= $totalPages
            ? "<span class='page-link'>&raquo;</span>"
            : sprintf("<a class='page-link' href='%s'>&raquo;</a>", $buildUrl($currentPage + 1))
    );

    $html .= "</ul>
        <ul class='pagination justify-content-center d-none d-sm-flex'>";

    if ($currentPage > 1) {
        $html .= sprintf(
            "<li class='page-item'>
                <a class='page-link' href='%s' aria-label='Page précédente'>
                    <span aria-hidden='true' class='d-none d-md-inline'>&laquo; Précédent</span>
                    <span aria-hidden='true' class='d-md-none'>&laquo;</span>
                </a>
            </li>",
            $buildUrl($currentPage - 1)
        );
    } else {
        $html .= "<li class='page-item disabled'>
            <span class='page-link'>
                <span aria-hidden='true' class='d-none d-md-inline'>&laquo; Précédent</span>
                <span aria-hidden='true' class='d-md-none'>&laquo;</span>
            </span>
        </li>";
    }

    if ($startPage > 1) {
        $html .= sprintf(
            "<li class='page-item'>
                <a class='page-link' href='%s'>1</a>
            </li>",
            $buildUrl(1)
        );

        if ($startPage > 2) {
            $html .= "<li class='page-item disabled d-none d-lg-block'>
                <span class='page-link'>...</span>
            </li>";
        }
    }

    for ($i = $startPage; $i <= $endPage; $i++) {
        $hiddenClass = '';
        if ($i !== $currentPage && $i !== 1 && $i !== $totalPages) {
            if (abs($i - $currentPage) > 1) {
                $hiddenClass = 'd-none d-md-block';
            }
        }

        if ($i === $currentPage) {
            $html .= sprintf(
                "<li class='page-item active' aria-current='page'>
                    <span class='page-link'>%d</span>
                </li>",
                $i
            );
        } else {
            $html .= sprintf(
                "<li class='page-item %s'>
                    <a class='page-link' href='%s'>%d</a>
                </li>",
                $hiddenClass,
                $buildUrl($i),
                $i
            );
        }
    }

    if ($endPage < $totalPages) {
        if ($endPage < $totalPages - 1) {
            $html .= "<li class='page-item disabled d-none d-lg-block'>
                <span class='page-link'>...</span>
            </li>";
        }

        $html .= sprintf(
            "<li class='page-item'>
                <a class='page-link' href='%s'>%d</a>
            </li>",
            $buildUrl($totalPages),
            $totalPages
        );
    }

    if ($currentPage < $totalPages) {
        $html .= sprintf(
            "<li class='page-item'>
                <a class='page-link' href='%s' aria-label='Page suivante'>
                    <span aria-hidden='true' class='d-none d-md-inline'>Suivant &raquo;</span>
                    <span aria-hidden='true' class='d-md-none'>&raquo;</span>
                </a>
            </li>",
            $buildUrl($currentPage + 1)
        );
    } else {
        $html .= "<li class='page-item disabled'>
            <span class='page-link'>
                <span aria-hidden='true' class='d-none d-md-inline'>Suivant &raquo;</span>
                <span aria-hidden='true' class='d-md-none'>&raquo;</span>
            </span>
        </li>";
    }

    $html .= "</ul></nav>";

    return $html;
}

function makePaginationSummary(int $currentPage = 1, int $totalPages = 1, int $totalResults = 0): string
{
    if ($totalPages <= 1) {
        return $totalResults > 0
            ? "<p class='text-muted text-center mb-3 small'>{$totalResults} résultat(s)</p>"
            : '';
    }

    $summary = "Page {$currentPage} sur {$totalPages}";

    if ($totalResults > 0) {
        $summary .= " - " . number_format($totalResults, 0, ',', ' ') . " résultat(s)";
    }

    return "<p class='text-muted text-center mb-3 small'>{$summary}</p>";
}

function makeSearchResultsHeader(string $query, int $totalResults): string
{
    $safeQuery = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');
    if ($totalResults === 0) {
        return "<div class='alert alert-warning text-center'>
                    Aucun résultat trouvé pour « {$safeQuery} ».
                </div>";
    }
    return "<div class='alert alert-info'>
                <h4 class='mb-1'>Résultats pour : « {$safeQuery} »</h4>
                <p class='mb-0'>{$totalResults} film(s) trouvé(s)</p>
            </div>";
}
