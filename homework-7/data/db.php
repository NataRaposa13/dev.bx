<?php

function connectToDB(array $settings): mysqli
{
	$database = mysqli_init();
	$connectionResult = mysqli_real_connect(
		$database,
		$settings['host'],
		$settings['username'],
		$settings['password'],
		$settings['dbName']
	);

	if(!$connectionResult)
	{
		$error = mysqli_connect_errno() . ": ". mysqli_connect_error();
		trigger_error($error, E_USER_ERROR);
	}

	$result = mysqli_set_charset($database, 'utf8');
	if(!$result)
	{
		trigger_error(mysqli_error($database), E_USER_ERROR);
	}

	return $database;
}

function connectPDO(array $settings): PDO
{
	// подключение DNS

	$host = $settings['host'];
	$db = $settings['dbName'];
	$user = $settings['username'];
	$password = $settings['password'];
	$charset = 'utf8mb4';

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false
	];
	try {
		$pdo = new PDO($dsn, $user, $password, $options);
	} catch (\PDOException $e) {
		throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}

	return $pdo;
}