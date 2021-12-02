<?php
declare(strict_types=1);
/** @var array $config */
require_once "./config/app.php";
/** @var array $movies */
/** @var array $genres */
require_once "./data/movies.php";
require_once "./lib/template-functions.php";
require_once "./lib/helper-functions.php";
require_once "./lib/movies-functions.php";

if (!isset($_GET['id']))
{
	return;
}

$id = (int)$_GET['id'];
$movies = getMoviesById($movies, $id);

// prepare page content
$moviesListPage = renderTemplate("./resources/pages/movie-details.php",
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