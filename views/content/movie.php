<section class="movieHeader">
    <img class="moviePageImg" src="./img/<?= $params['movie']->movie_img ?>" />
    <div class="moviePageInfo">
        <h2><?= $params['movie']->movie_title ?></h2>
        <div class="movieDetails">
            <h3>Informations :</h3>
            <ul>
                <li>Année de sortie : <?= $params['movie']->movie_date ?></li>
                <li>Durée du film : <?= $params['movie']->movie_length ?> minutes</li>
            </ul>
            <?php
                if(count($params['suite']) > 1){
                    echo '<h3 class="suiteListTitle">Dans la même série de films : </h3>';
                    echo '<ul>';
                        foreach($params['suite'] as $suite){
                            if($suite->movie_id !== $params['movie']->movie_id){
                                echo '<li><a title="'.$suite->movie_title.'" href="'.$suite->movie_url.'">'.$suite->movie_title.'</a></li>';
                            }
                        }
                    echo '</ul>';
                }
            ?>
        </div>
    </div>
</section>

<section class="movieContent">
    <?php if(!empty($params['songs'])): ?>
        <h2>Musiques</h2>
        <div class="movieSection">
        <?php foreach($params['songs'] as $song): ?>
            <div class="listElement">
                <h3 class="elementTitle"><?= $song->song_title ?></h3>
                <?php $videoId = explode('/', $song->song_video); ?>
                <img class="elementImg" title="<?= $song->song_title ?>" src="https://img.youtube.com/vi/<?= $videoId[4] ?>/1.jpg" onclick="play('<?= $song->song_video ?>')" />
            </div>
        <?php endforeach; ?>
            <div id="videoPlayer" class="hidden" onclick="closePlayer()">
                <img src="./img/close.png" />
                <iframe id="videoPlayed" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><!-- width="280" height="157"-->
            </div>
        </div>
    <?php endif; ?>

    <?php if(!empty($params['characters'])): ?>
        <h2>Personnages</h2>
        <div class="movieSection">
        <?php foreach($params['characters'] as $character): ?>
            <div class="listElement">
                <h3 class="elementTitle"><?= $character->char_name ?></h3>
                <img class="elementImg" title="<?= $character->char_name ?>" src="./img/characters/<?= $character->char_img ?>" />
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>