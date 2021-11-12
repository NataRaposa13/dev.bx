<?php
/** @var array $currentMovie */
?>

<div class="movie-details">
	<div class="movie-details--head">
		<div class="movie-details--head-title"><?= $currentMovie['title'] . " ({$currentMovie['release-date']})" ?></div>
		<div class="movie-details--head-subtitle">
			<?= $currentMovie['original-title'] ?>
			<div class="movie-details--head-subtitle--age-restriction"><?= $currentMovie['age-restriction'] . '+' ?></div>
		</div>
		<div class="movie-details--head-wrapper"></div>
	</div>
	<div class="big-wrapper-about-movie">
		<div class="wrapper-img-about-movie">
			<img class="img-about-movie" alt="movie" src="<?="./resources/images/img-content/".$currentMovie['id'].".jpg"?>">
		</div>
		<div class="wrapper-data-about-movie">
			<div class="wrapper-about-movie-rating">
				<?php for ($i = 1; $i <= 10; $i++): ?>
					<?= movieRectangleRating($i, $currentMovie['rating']) ?>
				<?php endfor; ?>
				<div class="rating-ellipse"><?= sprintf('%0.1f', $currentMovie['rating']) ?></div>
			</div>
			<div class="about-movie-small-descr-title">О фильме</div>
			<div class="wrapper-about-movie-small-descr">
				<ul class="wrapper-about-movie-small-descr-subtitle">
					<li class="about-movie-small-descr-subtitle-name">Год производства:</li>
					<li class="about-movie-small-descr-subtitle-name">Режиссер:</li>
					<li class="about-movie-small-descr-subtitle-name">В главных ролях:</li>
				</ul>
				<ul class="wrapper-about-movie-small-description">
					<li class="about-movie-small-description-full"><?= $currentMovie['release-date'] ?></li>
					<li class="about-movie-small-description-full"><?= $currentMovie['director'] ?></li>
					<li class="about-movie-small-description-full"><?= implode(", ", $currentMovie['cast']) ?></li>
				</ul>
			</div>
			<div class="about-movie-descr-title">Описание</div>
			<div class="about-movie-descr"><?= $currentMovie['description'] ?></div>
			<div class="about-movie-heart">
				<img src="./resources/images/img-tex/heart.svg" alt="heart">
			</div>
		</div>
	</div>
	</div>
</div>
