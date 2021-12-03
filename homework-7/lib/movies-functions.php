<?php

function getListGenres(mysqli $database, PDO $pdo, $page = 1, $pageSize = 50): array
{
	$query = "SELECT * FROM genre";

	$offset = $pageSize * ($page - 1);
	$limit = $pageSize;
	$query .= " LIMIT {$limit} OFFSET {$offset}";

	$result = $pdo->query($query);
	if (!$result)
	{
		trigger_error($database->error, E_USER_ERROR);
	}

	return $result->fetchAll(PDO::FETCH_UNIQUE);
}

function getListCodeGenres(mysqli $database, PDO $pdo): array
{
	$query = "SELECT CODE FROM genre";

	$result = $pdo->query($query);
	if (!$result)
	{
		trigger_error($database->error, E_USER_ERROR);
	}

	return $result->fetchAll(PDO::FETCH_COLUMN);
}

function getListActors(mysqli $database, PDO $pdo): array
{
	$query = "SELECT * FROM actor";

	$result = $pdo->query($query);
	if (!$result)
	{
		trigger_error($database->error, E_USER_ERROR);
	}

	return $result->fetchAll(PDO::FETCH_UNIQUE);
}

function getListMovies(mysqli $database, PDO $pdo, array $genres, string $genre = null): array
{
	if ($genre === null)
	{
		$query = "SELECT m.ID, TITLE, ORIGINAL_TITLE, DESCRIPTION, DURATION, AGE_RESTRICTION, RELEASE_DATE, RATING, d.NAME DIRECTOR,
       			         (SELECT GROUP_CONCAT(GENRE_ID SEPARATOR ', ') FROM movie_genre WHERE movie_genre.MOVIE_ID = m.ID) GENRES,
       					 (SELECT GROUP_CONCAT(ACTOR_ID SEPARATOR ', ') FROM movie_actor WHERE movie_actor.MOVIE_ID = m.ID) ACTORS
				  FROM movie m INNER JOIN director d ON m.DIRECTOR_ID = d.ID";
	}
	else
	{
		$genre = mysqli_real_escape_string($database, $genre);
		$query = "SELECT m.ID, TITLE, ORIGINAL_TITLE, DESCRIPTION, DURATION, AGE_RESTRICTION, RELEASE_DATE, RATING, d.NAME DIRECTOR,
       					 (SELECT GROUP_CONCAT(GENRE_ID SEPARATOR ', ') FROM movie_genre WHERE movie_genre.MOVIE_ID = m.ID) GENRES,
       			 		 (SELECT GROUP_CONCAT(ACTOR_ID SEPARATOR ', ') FROM movie_actor WHERE movie_actor.MOVIE_ID = m.ID) ACTORS
				  FROM movie m INNER JOIN director d ON m.DIRECTOR_ID = d.ID
             				   INNER JOIN movie_genre mg ON m.ID = mg.MOVIE_ID
             				   INNER JOIN genre g on mg.GENRE_ID = g.ID
             	  WHERE CODE = '{$genre}'";
	}

	$result = $pdo->query($query);
	if (!$result)
	{
		trigger_error($database->error, E_USER_ERROR);
	}

	return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getListMoviesWithGenres(array $movies, array $genres): array
{
	$n = count($movies);
	for ($i = 0; $i < $n; $i++)
	{
		$listGenres = explode(", ", $movies[$i]['GENRES']);
		$listNameGenres = array_map(fn($value): string => $genres[$value]['NAME'], $listGenres);
		$movies[$i]['GENRES'] = implode(", ", $listNameGenres);
	}

	return $movies;
}

function getListMoviesWithActors(array $movie, array $actors): array
{
	$listActors = explode(", ", $movie['ACTORS']);
	$listNameActors = array_map(fn($value): string => $actors[$value]['NAME'], $listActors);
	$movie['ACTORS'] = implode(", ", $listNameActors);

	return $movie;
}

function getMoviesById(mysqli $database, PDO $pdo, int $id): array
{
	$query = "SELECT m.ID, TITLE, ORIGINAL_TITLE, DESCRIPTION, DURATION, AGE_RESTRICTION, RELEASE_DATE, RATING, d.NAME DIRECTOR,
       			     (SELECT GROUP_CONCAT(GENRE_ID SEPARATOR ', ') FROM movie_genre WHERE movie_genre.MOVIE_ID = m.ID) GENRES,
       				 (SELECT GROUP_CONCAT(ACTOR_ID SEPARATOR ', ') FROM movie_actor WHERE movie_actor.MOVIE_ID = m.ID) ACTORS
			   FROM movie m INNER JOIN director d ON m.DIRECTOR_ID = d.ID 
			   WHERE m.ID = {$id}";

	$result = mysqli_query($database, $query);
	if (!$result)
	{
		trigger_error($database->error, E_USER_ERROR);
	}
	return mysqli_fetch_assoc($result);
}

//общие функции

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

function formatGenreList(string $genres): string
{
	return mb_strlen($genres, 'UTF-8') <= 30? $genres : formatMessage($genres, 27);
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
