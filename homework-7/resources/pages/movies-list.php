<?php
/** @var array $movies */
?>

<div class="movie-list">
	<?php foreach ($movies as $movie): ?>
		<?= renderTemplate("./resources/blocks/_movie.php", ['movie' => $movie]) ?>
	<?php endforeach; ?>
</div>
