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

$text = "Скоро сможете добавить свой фильм";

// prepare page content
$moviesListFavorites = renderTemplate("./resources/pages/add-movie.php",
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