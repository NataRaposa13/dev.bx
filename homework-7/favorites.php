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

$text = "Здесь будут только избранные фильмы";

// prepare page content
$moviesListFavorites = renderTemplate("./resources/pages/movies-list-favorites.php",
	[
		'text' => $text
	]
);

// render layout
renderLayout($moviesListFavorites,
	[
		'config' => $config,
		'genres' => $genres,
		'currentPage' => getFileName(__FILE__)
	]
);