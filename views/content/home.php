<div class="moviesList">

<?php foreach($params['movies'] as $movie): ?>
        <div class="movie">
            <a class="movieLink" title="<?= $movie->movie_title ?>" href="./<?= $movie->movie_url ?>">.</a>
            <img class="moviePicture" src="./img/<?= $movie->movie_img ?>" />
            <h2 class="movieTitle"><?= $movie->movie_title ?></h2>
            <p class="movieDate"><?= $movie->movie_date ?></p>
        </div>
    <?php endforeach ?>
</div>