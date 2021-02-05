<?php
    $movieDetails = $params['movieDetails'];
    $movieSuiteList = $params['movieSuiteList'];
    $movieSongs = $params['movieSongs'];
    $jsonSongsList = json_encode($movieSongs);
    $movieCharacters = $params['movieCharacters'];
    $jsonCharactersList = json_encode($movieCharacters);
?>
<script type="module">
    import {setMusicsList} from '../../public/scripts/songs.js';
    import {setCharactersList} from '../../public/scripts/characters.js';
    // For the video player to work, we need to pass the songs data to JS
    setMusicsList(<?= $jsonSongsList ?>);
    setCharactersList(<?= $jsonCharactersList ?>);
</script>

<section id="movieHeader">
    <img id="moviePageImg" src="<?= $movieDetails['img']?>" />
    <div id="moviePageInfo">
        <h2 id="movieTitle"><?= $movieDetails['title']?></h2>
        <div id="movieDetails">
            <h3>Informations :</h3>
            <p id="movieDate">Année de sortie : <?= $movieDetails['date']?></p>
            <?php
                $hours = floor($movieDetails['length']/60);
                $minutes = $movieDetails['length'] - ($hours*60)
            ?>
            <p id="movieLength">Durée : <?= $hours ?>h<?= $minutes ?></p>
            <?php if($movieDetails['story'] != "") :?>
                <h3>Synopsis :</h3>
                <p id="movieStory"><?= $movieDetails['story'] ?></p>
            <?php endif; ?>
            <!-- Liste des suites éventuelles -->
            <?php if(count($movieSuiteList) > 1) :?>
                <h3 id="movieSuiteTitle">Dans la même série de films :</h3>
                <ul>
                    <?php foreach($movieSuiteList as $suite) :?>
                        <?php if($suite['slug'] != $movieDetails['slug']) : ?>
                            <li><a href="./<?= $suite['slug'] ?>" title="<?= $suite['title'] ?>"><?= $suite['title'] ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if(count($movieSongs) > 0): ?>
    <h2 class="movieSectionTitle">Musiques</h2>
    <div id="musicList">
        <!-- Contient la liste des chansons -->
        <?php for($i=0;$i<count($movieSongs);$i++) : ?>
            <div class="listElement">
                <h3><?= $movieSongs[$i]['title'] ?></h3>
                <img class="songItem" id="song-<?= $i ?>" title="<?= $movieSongs[$i]['title'] ?>" src="https://img.youtube.com/vi/<?= $movieSongs[$i]['youtubeId'] ?>/1.jpg" alt="<?= $movieSongs[$i]['title'] ?>" />
            </div>
        <?php endfor; ?>
    </div>
    <section id="videoPlayer" class="hidden">
        <div id="videoNavBar">
            <img id="previousVid" src="./img/previous.png" title="Vidéo précédente" />
            <img id="closeVid" src="./img/close.png" title="Fermer le lecteur" />
            <img id="nextVid" src="./img/next.png" title="Vidéo suivante" />
        </div>    
        <div id="videoPlayed"></div>
    </section>
<?php endif; ?>

<?php if(count($movieCharacters) > 0): ?>
    <h2 class="movieSectionTitle">Personnages</h2>
    <div id="charactersDisplay">
        <div id="charactersList">
            <!-- Contient la liste des personnages -->
            <?php for($i=0;$i<count($movieCharacters);$i++) : ?>
                <div class="listElement">
                    <h3><?= $movieCharacters[$i]['name'] ?></h3>
                    <img class="elementImg" id="char-<?= $i ?>" title="<?= $movieCharacters[$i]['name'] ?>" src="./img/characters/<?= $movieCharacters[$i]['img'] ?>" alt="<?= $movieCharacters[$i]['name'] ?>" />
                </div>
            <?php endfor; ?>
        </div>
        <div id="charInfo" class="hidden">
            <img id="closeInfo" src="./img/close.png" title="Fermer" />
            <img id="charInfoImg" />
            <h3 id="charName"></h3>
            <p id="charMovie">Film : <a id="charMovieLink"></a></p>
            <p id="charDesc"></p>
        </div>
    </div>
<?php endif; ?>