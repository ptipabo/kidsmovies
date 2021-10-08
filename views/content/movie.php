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

<section class="section whiteBG">
    <div class="section-container movieHeader">
        <img class="movieHeader-img" src="<?= $movieDetails['img']?>" />
        <div class="movieHeader-info">
            <h2 class="pageTitle"><?= $movieDetails['title']?></h2>
            <div class="movieHeader-info-details">
                <h3 class="movieHeader-info-details-title">Informations :</h3>
                <p id="movieDate" class="movieHeader-info-details-text">Année de sortie : <?= $movieDetails['date']?></p>
                <?php
                    $hours = floor($movieDetails['length']/60);
                    $minutes = $movieDetails['length'] - ($hours*60);
                ?>
                <p id="movieLength" class="movieHeader-info-details-text">Durée : <?= $hours ?>h<?= $minutes < 10 ? '0' : '' ?><?= $minutes ?></p>
                <?php if($movieDetails['story'] != "") :?>
                    <h3 class="movieHeader-info-details-title">Synopsis :</h3>
                    <p class="movieHeader-info-details-text longText"><?= $movieDetails['story'] ?></p>
                <?php endif; ?>
                <!-- Liste des suites éventuelles -->
                <?php if(count($movieSuiteList) > 1) :?>
                    <h3 id="movieSuiteTitle" class="movieHeader-info-details-title">Dans la même série de films :</h3>
                    <ul class="movieHeader-info-details-list">
                        <?php foreach($movieSuiteList as $suite) :?>
                            <?php if($suite['slug'] != $movieDetails['slug']) : ?>
                                <li class="movieHeader-info-details-list-item">
                                    <a class="movieHeader-info-details-list-item-link" href="./<?= $suite['slug'] ?>" title="<?= $suite['title'] ?>">
                                        <img src="<?= $suite['img'] ?>" alt="<?= $suite['title'] ?>" />
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if(count($movieSongs) > 0): ?>
<section class="section midGreyBG">
    <div class="section-container">
        <h3 class="sectionTitle">Musiques</h3>
    </div>
</section>
<section class="section greyBG">
    <div id="musicList" class="section-container d-flex fairSpread">
        <!-- Contient la liste des chansons -->
        <?php for($i=0;$i<count($movieSongs);$i++) : ?>
            <div class="listElement">
                <h3><?= $movieSongs[$i]['title'] ?></h3>
                <img class="songItem" id="song-<?= $i ?>" title="<?= $movieSongs[$i]['title'] ?>" src="https://img.youtube.com/vi/<?= $movieSongs[$i]['youtubeId'] ?>/1.jpg" alt="<?= $movieSongs[$i]['title'] ?>" />
            </div>
        <?php endfor; ?>
    </div>
</section>
<section id="videoPlayer" class="hidden">
    <div id="videoNavBar">
        <img id="previousVid" src="./img/previous.png" title="Vidéo précédente" />
        <img id="closeVid" src="./img/close.png" title="Fermer le lecteur" />
        <img id="nextVid" src="./img/next.png" title="Vidéo suivante" />
    </div>
    <div id="censoredBlock" class="censoredBlock hidden"></div>
    <div id="videoPlayed"></div>
</section>
<?php endif; ?>

<?php if(count($movieCharacters) > 0): ?>
<section class="section midGreyBG">
    <div class="section-container">
        <h3 class="sectionTitle">Personnages</h3>
    </div>
</section>
<section class="section greyBG">
    <div class="section-container d-flex fairSpread">
        <div id="charactersList">
            <!-- Contient la liste des personnages -->
            <?php for($i=0;$i<count($movieCharacters);$i++) : ?>
                <div class="listElement">
                    <h3><?= $movieCharacters[$i]['name'] ?></h3>
                    <img class="elementImg" id="char-<?= $i ?>" title="<?= $movieCharacters[$i]['name'] ?>" src="./img/characters/<?= $movieCharacters[$i]['img'] ?>" alt="<?= $movieCharacters[$i]['name'] ?>" />
                </div>
            <?php endfor; ?>
        </div>
        <div id="charInfo" class="dataSheet hidden">
            <img id="closeInfo" src="./img/close.png" title="Fermer" />
            <img id="charInfoImg" />
            <h3 id="charName"></h3>
            <p id="charMovie">Film : <a id="charMovieLink"></a></p>
            <p id="charDesc"></p>
        </div>
    </div>
</section>
<?php endif; ?>