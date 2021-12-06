<?php
declare(strict_types=1);
/** @var array $config */
require_once "./config/app.php";
require_once "./lib/template-functions.php";
require_once "./lib/helper-functions.php";
require_once "./lib/movies-functions.php";
require_once "./data/db.php";

$database = connectPDOToDB($config['db']);

$genres = getListGenres($database);
$movies = getListMoviesByGenre($database, checkGetGenreIsCorrect($genres, $_GET['genre']), $_GET['genre']);

// prepare page content
$moviesListPage = renderTemplate("./resources/pages/movies-list.php",
	[
		'movies' => getListMoviesWithGenres($movies, $genres)
	]
);

// render layout
renderLayout($moviesListPage,
	[
		'config' => $config,
		'genres' => $genres,
		'currentPage' => getFileName(__FILE__),
		'get' => $_GET
	]
);