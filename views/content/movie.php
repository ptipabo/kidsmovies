<h2><?= $params['movie']->movie_title ?></h2>
<p>Année de sortie : <?= $params['movie']->movie_date ?> - Durée du film : <?= $params['movie']->movie_length ?> minutes</p>
<img src="../img/<?= $params['movie']->movie_img ?>" />

<div class="movieCharacters">
    <h2>Personnages</h2>
    <?php foreach($params['characters'] as $character): ?>
        <div class="character">
            <img class="charImg" src="../img/characters/<?= $character->char_img ?>" />
            <h3 class="charName"><?= $character->char_name ?></h3>
            <p class="charDesc"><?= $character->char_desc ?></p>
        </div>';
    <?php endforeach?>
</div>