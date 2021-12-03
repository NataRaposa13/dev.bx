<?php
declare(strict_types=1);
/** @var array $config */
require_once "./config/app.php";
require_once "./lib/template-functions.php";
require_once "./lib/helper-functions.php";
require_once "./lib/movies-functions.php";
require_once "./data/db.php";

$database = connectToDB($config['db']);
$pdo = connectPDO($config['db']);

$genres = getListGenres($database, $pdo);
$movies = getListMovies($database, $pdo, $genres);

// genre filtering
if (isset($_GET['genre']) && in_array($_GET['genre'], array_values(getListCodeGenres($database, $pdo))))
{
	$movies = getListMovies($database, $pdo, $genres, $_GET['genre']);
}

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