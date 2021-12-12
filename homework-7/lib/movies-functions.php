<?php

function getListGenres(PDO $database, $page = 1, $pageSize = 50): array
{
	$query = "SELECT * FROM genre";

	$offset = $pageSize * ($page - 1);
	$limit = $pageSize;
	$query .= " LIMIT $limit OFFSET $offset";

	try {
		$result = $database->query($query);
	} catch (PDOException $e) {
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}

	return $result->fetchAll(PDO::FETCH_UNIQUE);
}

function checkGetGenreIsCorrect(array $genres, string $genre = null): bool
{
	return isset($genre) && in_array($genre, array_column($genres, 'CODE'));
}

function getListMovies(PDO $database): array
{
	$query = "SELECT m.ID, TITLE, ORIGINAL_TITLE, DESCRIPTION, DURATION, AGE_RESTRICTION, RELEASE_DATE, RATING, d.NAME DIRECTOR,
					 (SELECT GROUP_CONCAT(GENRE_ID SEPARATOR ', ') FROM movie_genre WHERE movie_genre.MOVIE_ID = m.ID) GENRES,
					 (SELECT GROUP_CONCAT(ACTOR_ID SEPARATOR ', ') FROM movie_actor WHERE movie_actor.MOVIE_ID = m.ID) ACTORS
			  FROM movie m INNER JOIN director d ON m.DIRECTOR_ID = d.ID";

	try {
		$result = $database->query($query);
	} catch (PDOException $e) {
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}

	return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getListMoviesByGenre(PDO $database, bool $isGenre = false, string $genre = null): array
{
	if (!$isGenre) {
		return getListMovies($database);
	}

	$query = "SELECT m.ID, TITLE, ORIGINAL_TITLE, DESCRIPTION, DURATION, AGE_RESTRICTION, RELEASE_DATE, RATING, d.NAME DIRECTOR,
					 (SELECT GROUP_CONCAT(GENRE_ID SEPARATOR ', ') FROM movie_genre WHERE movie_genre.MOVIE_ID = m.ID) GENRES,
					 (SELECT GROUP_CONCAT(ACTOR_ID SEPARATOR ', ') FROM movie_actor WHERE movie_actor.MOVIE_ID = m.ID) ACTORS
			  FROM movie m INNER JOIN director d ON m.DIRECTOR_ID = d.ID
						   INNER JOIN movie_genre mg ON m.ID = mg.MOVIE_ID
						   INNER JOIN genre g on mg.GENRE_ID = g.ID
			  WHERE CODE = ?";

	try {
		$result = $database->prepare($query);
		$result->execute([$genre]);
	} catch (PDOException $e) {
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}

	return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getMoviesById(PDO $database, int $id = null): ?array
{
	$query = "SELECT m.ID, TITLE, ORIGINAL_TITLE, DESCRIPTION, DURATION, AGE_RESTRICTION, RELEASE_DATE, RATING, d.NAME DIRECTOR,
       			     (SELECT GROUP_CONCAT(GENRE_ID SEPARATOR ', ') FROM movie_genre WHERE movie_genre.MOVIE_ID = m.ID) GENRES,
       				 (SELECT GROUP_CONCAT(ACTOR_ID SEPARATOR ', ') FROM movie_actor WHERE movie_actor.MOVIE_ID = m.ID) ACTORS
			   FROM movie m INNER JOIN director d ON m.DIRECTOR_ID = d.ID 
			   WHERE m.ID = ?";

	try {
		$result = $database->prepare($query);
		$result->execute([$id]);
		$movie = $result->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}

	return $movie !== false ? $movie : null;
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

function getListMoviesWithActors(PDO $database, array $movie, string $idActors): array
{
	$query = "SELECT * FROM actor WHERE ID IN ($idActors)";

	try {
		$result = $database->query($query);
	} catch (PDOException $e) {
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}

	$movie['ACTORS'] = implode(", ", array_values($result->fetchAll(PDO::FETCH_KEY_PAIR)));

	return $movie;
}

//общие функции

function formatGenreList(string $genres): string
{
	return mb_strlen($genres, 'UTF-8') <= 30? $genres : formatMessage($genres, 27);
}

function createRectangleByMoviesRating(int $i, float $rating): string
{
	if ($i<=$rating) {
		return '<div style= "background:#E78818;"  class="rating-rectangle"></div>';
	}
	else {
		return '<div class="rating-rectangle"></div>';
	}
}
