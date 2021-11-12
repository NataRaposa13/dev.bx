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

// genre filtering
if (isset($_GET['genre']) && in_array($_GET['genre'], array_values($genres)))
{
	$movies = getMoviesByGenres($movies, $_GET['genre']);
}

// prepare page content
$moviesListPage = renderTemplate("./resources/pages/movies-list.php",
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