<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

define("DEFAULT_HEADER_OPTIONS", [
    'accept' => 'application/json',
    'Content-Type' => 'application/json'
]);

define("DEFAULT_QUERY_OPTIONS", [
    'api_key' => ENV['TMDB_API_KEY'],
    'language' => 'fr-FR'
]);


/**
 * @return Client
 */
function getTMDBGuzzleClient(): Client
{
    return new Client([
        'base_uri' => 'https://api.themoviedb.org/3/',
        'timeout' => 30,
        'verify' => true,
    ]);
}

function getTrendingMovies(Client $guzzleClient, $page = 1)
{
    try {
        $response = $guzzleClient->request('GET', 'trending/movie/day', [
            'headers' => [
                ...DEFAULT_HEADER_OPTIONS
            ],
            'query' => [
                ...DEFAULT_QUERY_OPTIONS,
                'page' => $page,
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    } catch (RequestException $e) {
        echo '<pre>';
        var_dump($e);
        echo '</pre>';
        die();
    }
}

function getMovieDetail(Client $guzzleClient, string|int $movieId)
{
    try {
        $response = $guzzleClient->request('GET', 'movie/'.$movieId, [
            'headers' => [
                ...DEFAULT_HEADER_OPTIONS
            ],
            'query' => [
                ...DEFAULT_QUERY_OPTIONS,
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    } catch (RequestException $e) {
        echo '<pre>';
        var_dump($e);
        echo '</pre>';
        die();
    }
}

function searchMovies(Client $guzzleClient, string $query, $page = 1)
{
    try {
        $response = $guzzleClient->request('GET', 'search/movie', [
            'headers' => [
                ...DEFAULT_HEADER_OPTIONS
            ],
            'query' => [
                ...DEFAULT_QUERY_OPTIONS,
                'query' => $query,
                'page' => $page,
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    } catch (RequestException $e) {
        echo '<pre>';
        var_dump($e);
        echo '</pre>';
        die();
    }
}

