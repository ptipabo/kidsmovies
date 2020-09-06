<div class="pageHeader">
    <h2>Personnages</h2>
</div>

<div class="mainContent">   
    <?php foreach($params['characters'] as $character): ?>
        <div class="listElement">
            <?php
                foreach($params['movies'] as $movie){
                    if($character->char_movie === $movie->movie_id){
                        $movieTitle = $movie->movie_title;
                    }
                }
            ?>
            <h3 class="elementTitle">
                <span class="elementMovie">
                    <?= $movieTitle ?>
                </span><br/>
                <?= $character->char_name ?>
            </h3>
            
            <img class="elementImg" title="<?= $character->char_name ?>" src="./img/characters/<?= $character->char_img ?>" />

        </div>
    <?php
    endforeach;
    ?>
</div>