<?php
require ROOT . '/vendor/autoload.php';
require_once ROOT . "/includes/tmdbClient.php";
require_once ROOT . "/includes/htmlMaker.php";

function getAndDisplayTrendingMovies()
{
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);
    
    $apiResult = getTrendingMovies(getTMDBGuzzleClient(), $page);
    
    $content = makeMovieGallery($apiResult['results']);
    
    if ($apiResult['total_pages'] > 1) {
        $content .= makePagination($page, $apiResult['total_pages']);
    }
    
    return [
        'title' => 'Nouveauté' . ($page > 1 ? ' - Page ' . $page : ''),
        'content' => $content
    ];
}


function getAndDisplayMovieDetail(string|int $movieId)
{
    $apiResult = getMovieDetail(getTMDBGuzzleClient(), $movieId);
    return [
        'title' => $apiResult['original_title'],
        'content' => makeMovieDetail($apiResult)
    ];
}

function getAndDisplaySearchResults()
{
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);
    
    if (empty($query)) {
        header('Location: /public/');
        exit;
    }
    
    $apiResult = searchMovies(getTMDBGuzzleClient(), $query, $page);
    
    $content = makeSearchResultsHeader($query, $apiResult['total_results']);
    $content .= makeMovieGallery($apiResult['results']);
    
    if ($apiResult['total_pages'] > 1) {
        $content .= makePagination($page, $apiResult['total_pages'], [
            'action' => 'search',
            'query' => $query
        ]);
    }
    
    return [
        'title' => 'Résultats pour : ' . htmlspecialchars($query) . ($page > 1 ? ' - Page ' . $page : ''),
        'content' => $content
    ];
}
