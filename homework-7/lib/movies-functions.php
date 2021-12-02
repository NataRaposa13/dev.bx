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

function getAllValuesByKey(array $movies, string $key): array
{
	$result = [];
	foreach ($movies as $movie)
	{
		if(array_key_exists($key, $movie))
		{
			$result[] = $movie[$key];
		}
	}
	return $result;
}

function formatGenreList(array $genres): string
{
	$result = implode(", ", array_values($genres));
	return mb_strlen($result, 'UTF-8') <= 30? $result : formatMessage($result, 27);
}

function createRectangleByMoviesRating(int $i, float $rating): string
{
	{
		if ($i<=$rating){
			return '<div style= "background:#E78818;"  class="rating-rectangle"></div>';
		}
		else
		{
			return '<div class="rating-rectangle"></div>';
		}
	}
}
