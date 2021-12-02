<?php
/** @var array $movie */
?>

<div class="movie-list--item">
	<div class="movie-list--item-image" style="background-image: url(<?="./resources/images/img-content/".$movie['id'].".jpg"?>);"></div>
	<div class="movie-list--item-head">
		<div class="movie-list--item-title"><?=formatMessage($movie['title'], 24) ?></div>
		<div class="movie-list--item-subtitle"><?= $movie['original-title'] ?></div>
		<div class="movie-list--item-wrapper"></div>
	</div>
	<div class="movie-list--item-description"><?= formatMessage($movie['description'], 190) ?></div>
	<div class="movie-list--item-bottom">
		<div class="movie-list--item-time">
			<div class="movie-list--item-time--icon"></div>
			<?=$movie['duration'].' мин.'.' / '.date('h:i', mktime(0,$movie['duration']))?>
		</div>
		<div class="movie-list--item-genre">
				<div><?= formatGenreList($movie['genres']) ?></div>
		</div>
	</div>
	<div class="movie-list--item-overlap">
		<a href="<?= "details" . ".php" . "?id=" . $movie['id']?>" class="movie-list--item-overlap--more"><?= "Подробнее" ?></a>
	</div>
</div>