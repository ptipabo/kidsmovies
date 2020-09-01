<div class="moviesList">

<?php foreach($params['movies'] as $movie): ?>
        <div class="movie">
            <?php $movieTitle = strtolower(str_replace(' ', '-', $movie->movie_title)); ?>
            <a class="movieLink" title="<?= $movie->movie_title ?>" href="./<?= $movieTitle ?>">.</a>
            <img class="moviePicture" src="./img/<?= $movie->movie_img ?>" />
            <h2 class="movieTitle"><?= $movie->movie_title ?></h2>
            <p class="movieDate"><?= $movie->movie_date ?></p>
        </div>
    <?php endforeach ?>
</div>