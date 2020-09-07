<div class="pageHeader">
    <h2>Personnages</h2>
</div>

<div class="mainContent">   
    <div class="charactersList">
        <?php
        $i=0;
        foreach($params['characters'] as $character): ?>
            <div class="listElement">
                <?php
                    foreach($params['movies'] as $movie){
                        if($character->char_movie === $movie->movie_id){
                            $movieTitle = $movie->movie_title;
                        }
                    }
        
                    $charDesc = str_replace('"', '\"', $character->char_desc);
                    $i++;
                ?>
                <script>
                   charInfo<?= $i ?> = {
                        charId:"<?= $character->char_id ?>",
                        charMovie:"<?= $movieTitle ?>",
                        charName:"<?= $character->char_name ?>",
                        charImg:"<?= $character->char_img ?>",
                        charDesc:"<?= $charDesc ?>"}
                </script>

                <?php $charObj = 'charInfo'.$i; ?>

                <h3 class="elementTitle">
                    <span class="elementMovie">
                        <?= $movieTitle ?>
                    </span><br/>
                    <?= $character->char_name ?>
                </h3>

                <img class="elementImg" title="<?= $character->char_name ?>" src="./img/characters/<?= $character->char_img ?>" onclick="openInfo(<?= $charObj ?>)" />

            </div>
        <?php
        endforeach;
        ?>
    </div>
    <div id="charInfo" class="hidden">
        <img id="closeInfo" src="./img/close.png" title="Fermer" onclick="closeInfo()" />
        <img id="charImg" />
        <h3 id="charName"></h3>
        <h4 id="charMovie"></h4>
        <p id="charDesc"></p>
    </div>
</div>