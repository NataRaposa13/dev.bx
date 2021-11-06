<?php
declare(strict_types=1);
/** @var array $movies */
require "./movies/movies.php";
require "./movies/movie-function.php";
require "functions.php";

printMessage("Welcome to movie list!");
$age = readline("Enter age: ");

if (!checkAge($age))
{
	printMessage("Wrong age");
	return false;
}

printSelectMoviesByAge((int)$age, $movies);