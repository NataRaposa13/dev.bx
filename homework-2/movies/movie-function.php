<?php

function checkAge(string $age): bool
{
	return is_numeric($age) && (int)$age >= 0 && (int)$age < 100;
}

function printSelectMoviesByAge(int $age, array $movies): void
{
	$numberMovies = 0;
	foreach ($movies as $movie)
	{
		if ($movie["age_restriction"] <= $age)
		{
			$numberMovies++;
			printMessage(formatMovie($numberMovies, $movie));
		}
	}
}