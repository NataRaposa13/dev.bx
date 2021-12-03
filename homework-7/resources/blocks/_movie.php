<?php
/** @var array $movie */
?>

<div class="movie-list--item">
	<div class="movie-list--item-image" style="background-image: url(<?="./resources/images/img-content/".$movie['ID'].".jpg"?>);"></div>
	<div class="movie-list--item-head">
		<div class="movie-list--item-title"><?=formatMessage($movie['TITLE'], 24) ?></div>
		<div class="movie-list--item-subtitle"><?= $movie['ORIGINAL_TITLE'] ?></div>
		<div class="movie-list--item-wrapper"></div>
	</div>
	<div class="movie-list--item-description"><?= formatMessage($movie['DESCRIPTION'], 190) ?></div>
	<div class="movie-list--item-bottom">
		<div class="movie-list--item-time">
			<div class="movie-list--item-time--icon"></div>
			<?=$movie['DURATION'].' мин.'.' / '.date('h:i', mktime(0,$movie['DURATION']))?>
		</div>
		<div class="movie-list--item-genre">
				<div><?= formatGenreList($movie['GENRES']) ?></div>
		</div>
	</div>
	<div class="movie-list--item-overlap">
		<a href="<?= "details" . ".php" . "?id=" . $movie['ID']?>" class="movie-list--item-overlap--more"><?= "Подробнее" ?></a>
	</div>
</div>