<div class="movieHeader">
    <img class="moviePageImg" src="../img/<?= $params['movie']->movie_img ?>" />
    <div class="moviePageInfo">
        <h2><?= $params['movie']->movie_title ?></h2>
        <ul>
            <li>Année de sortie : <?= $params['movie']->movie_date ?></li>
            <li>Durée du film : <?= $params['movie']->movie_length ?> minutes</li>
        </ul>
    </div>
</div>

<div class="movieContent">
    <?php
    if(!empty($params['characters'])){
        echo '<h2>Personnages</h2>';    
        foreach($params['characters'] as $character){
            echo '<div class="character">
                <img class="charImg" src="../img/characters/'.$character->char_img.'" />
                <div class="charInfo">
                    <h3 class="charName">'.$character->char_name.'</h3>
                    <p class="charDesc">'.$character->char_desc.'</p>
                </div>
            </div>';
        }
    }
    ?>
</div>
<div class="movieContent">
    <?php
    if(!empty($params['songs'])){
        echo '<h2>Chansons</h2>';
        echo '<div class="songsList">';
            foreach($params['songs'] as $song){
                echo '<div class="song">
                        <h3 class="songTitle">'.$song->song_title.'</h3>
                        <iframe width="560" height="315" src="'.$song->song_video.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>';
            }
        echo '</div>';
    }
    ?>
</div>