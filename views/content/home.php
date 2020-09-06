<div class="pageHeader">
    <h2>Films</h2>
    <div class="sortBy">
        <label for="sortBy">Trier par : </label>
        <select name="sortBy" onchange="orderBy(this.value)">
            <option value="movieByTitle">Ordre alphabétique</option>
            <option value="movieByDate">Date de sortie</option>
            <option value="movieBySuite">Suites</option>
            <option value="movieByLength">Durée</option>
        </select>
    </div>
</div>

<div class="mainContent" id="movieByTitle">
    <?php foreach($params['movieByTitle'] as $movie): ?>
        <div class="movie">
            <a class="movieLink" title="<?= $movie->movie_title ?>" href="./<?= $movie->movie_url ?>">.</a>
            <img class="moviePicture" src="./img/<?= $movie->movie_img ?>" />
            <h2 class="movieTitle"><?= $movie->movie_title ?></h2>
            <p class="movieDate"><?= $movie->movie_date ?></p>
        </div>
    <?php endforeach ?>
</div>

<div class="mainContent hidden" id="movieByDate">
    <?php foreach($params['movieByDate'] as $movie): ?>
        <div class="movie">
            <a class="movieLink" title="<?= $movie->movie_title ?>" href="./<?= $movie->movie_url ?>">.</a>
            <img class="moviePicture" src="./img/<?= $movie->movie_img ?>" />
            <h2 class="movieTitle"><?= $movie->movie_title ?></h2>
            <p class="movieDate"><?= $movie->movie_date ?></p>
        </div>
    <?php endforeach ?>
</div>

<div class="mainContent hidden" id="movieBySuite">

    <?php foreach($params['movieBySuite'] as $movie): ?>
        <div class="movie">
            <a class="movieLink" title="<?= $movie->movie_title ?>" href="./<?= $movie->movie_url ?>">.</a>
            <img class="moviePicture" src="./img/<?= $movie->movie_img ?>" />
            <h2 class="movieTitle"><?= $movie->movie_title ?></h2>
            <p class="movieDate"><?= $movie->movie_date ?></p>
        </div>
    <?php endforeach ?>
</div>

<div class="mainContent hidden" id="movieByLength">

    <?php foreach($params['movieByLength'] as $movie): ?>
        <div class="movie">
            <a class="movieLink" title="<?= $movie->movie_title ?>" href="./<?= $movie->movie_url ?>">.</a>
            <img class="moviePicture" src="./img/<?= $movie->movie_img ?>" />
            <h2 class="movieTitle"><?= $movie->movie_title ?></h2>
            <p class="movieDate"><?= $movie->movie_date ?></p>
        </div>
    <?php endforeach ?>
</div>