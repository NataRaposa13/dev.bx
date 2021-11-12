<?php

function getMoviesByGenres(array $movies, string $genre): array
{
	return array_filter($movies, function($movie) use ($genre){
		return in_array($genre, $movie['genres']);
	});
}

function getMoviesById(array $movies, int $id): array
{
	foreach ($movies as $movie)
	{
		if($movie['id'] === $id)
		{
			return $movie;
		}
	}
	return [];
}
