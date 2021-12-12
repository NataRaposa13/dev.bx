<?php
declare(strict_types=1);
/** @var array $config */
require_once "./config/app.php";
require_once "./lib/template-functions.php";
require_once "./lib/helper-functions.php";
require_once "./lib/movies-functions.php";
require_once "./data/db.php";

$database = connectPDOToDB($config['db']);

$movies = null;
$genres = getListGenres($database);

if (is_numeric($_GET['id'] ?? null)) {
	$movies = getMoviesById($database, (int) $_GET['id']);
}

if ($movies === null) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: index.php");
	exit();
}

// prepare page content
$moviesListPage = renderTemplate("./resources/pages/movie-details.php", [
	'movies' => getListMoviesWithActors($database, $movies, $movies['ACTORS'])
]);

// render layout
renderLayout($moviesListPage, [
	'config' => $config,
	'genres' => $genres,
	'currentPage' => getFileName(__FILE__)
]);