<?php
declare(strict_types=1);
/** @var array $config */
require_once "./config/app.php";
/** @var array $movies */
require_once "./data/movies.php";
require_once "./lib/template-functions.php";
require_once "./lib/helper-functions.php";
require_once "./lib/movies-functions.php";
require_once "./data/db.php";

$database = connectToDB($config['db']);
$pdo = connectPDO($config['db']);

$genres = getListGenres($database, $pdo);

$path = "./resources/pages/movies-list.php";

if (isset($_GET['id']) && in_array((int)$_GET['id'], getAllValuesByKey($movies, 'id')))
{
	$path = "./resources/pages/movie-details.php";
	$id = (int)$_GET['id'];
	$movies = getMoviesById($movies, $id);
}

// prepare page content
$moviesListPage = renderTemplate($path,
	[
		'movies' => $movies
	]
);

// render layout
renderLayout($moviesListPage,
	[
		'config' => $config,
		'genres' => $genres,
		'currentPage' => getFileName(__FILE__)
	]
);