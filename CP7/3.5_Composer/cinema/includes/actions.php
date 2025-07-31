<?php
require ROOT . '/vendor/autoload.php';
require_once ROOT . "/includes/tmdbClient.php";
require_once ROOT . "/includes/htmlMaker.php";

function getAndDisplayTrendingMovies()
{
    $apiResult = getTrendingMovies(getTMDBGuzzleClient());
    return [
        'title' => 'Nouveauté',
        'content' => makeMovieGallery($apiResult['results'])
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
