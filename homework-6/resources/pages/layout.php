<?php
/** @var array $config */
/** @var array $genres */
/** @var string $content */
/** @var string $currentPage */
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $config['title'] ?></title>
	<link rel="stylesheet" href="./resources/css/reset.css">
	<link rel="stylesheet" href="./resources/css/style.css">
	<link rel="stylesheet" href="./resources/css/movie-details.css">
</head>
<body>
<div class="wrapper">
	<div class="sidebar">
		<div class="sidebar-logotype" style="background-image: url(./resources/images/img-tex/BITFLIX.svg);"></div>
		<ul class="menu">
			<li class="menu-item <?= $currentPage === 'index' ? "menu-item--active" : "" ?>">
				<a href="<?= "index" . ".php"?>"><?= $config['menu']['index'] ?></a>
			</li>
			<?php foreach ($genres as $code => $name): ?>
				<li class="menu-item <?= $currentPage === "index.php" . "?genre=" . $name ? "menu-item--active" : "" ?>">
					<a href="<?= "index.php" . "?genre=" . $name?>"><?= $name ?></a>
				</li>
			<?php endforeach; ?>
			<li class="menu-item <?= $currentPage === 'favorites' ? "menu-item--active" : "" ?>">
				<a href="<?= "favorites" . ".php"?>"><?= $config['menu']['favorites'] ?></a>
			</li>
		</ul>
	</div>
	<div class="container">
		<div class="header">
			<form class="search" action="">
				<div class="search-bar">
					<div class="search-bar--icon"></div>
					<input class="search-bar--input" type="text" placeholder="Поиск по каталогу...">
					<div class="search-bar--wrapper"></div>
				</div>
				<button class="search-button">искать</button>
			</form>
			<a href="<?= "add" . ".php"?>"><?= $config['add'] ?></a>
		</div>
		<div class="content">
			<?= $content ?>
		</div>
	</div>
</div>
</body>
</html>