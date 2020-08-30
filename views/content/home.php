<div class="moviesList">

<?php foreach($params['movies'] as $movie): ?>
        <div class="movie">
            <img class="moviePicture" src="./img/<?= $movie->movie_img ?>" />
            <h2 class="movieTitle"><?= $movie->movie_title ?></h2>
            <p class="movieDate"><?= $movie->movie_date ?></p>
            <a href="./movie/<?= $movie->movie_id ?>">Plus d'infos...</a>
        </div>
    <?php endforeach ?>
</div>