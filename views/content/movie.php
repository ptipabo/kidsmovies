<?php
    $movieDetails = $params['movieDetails'];
    $movieSuiteList = $params['movieSuiteList'];
    $movieSuiteSongs = $params['movieSuiteSongs'];
    $movieSongs = $params['movieSongs'];
    $jsonSongsList = json_encode($movieSongs);
    $jsonSuiteSongsList = json_encode($movieSuiteSongs);
    $suiteCharacters = $params['suiteCharacters'];
    $jsonCharactersList = json_encode($suiteCharacters);

    function check_url($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);

        return $headers['http_code'];
    }
?>
<script type="module">
    import {setMusicsList} from '../../public/scripts/songs.js';
    import {setCharactersList} from '../../public/scripts/characters.js';
    let brokenVideos;// Variable that will contain all the link of broken songs
    let movieSongsList = document.getElementsByClassName("movieMusicList")[0];
    let suiteSongsList = document.getElementsByClassName("suiteMusicList")[0];

    // For the video player to work, we need to pass the songs data to JS
    // If there is at least one song in this specific movie, by default, we load only the songs from this movie
    if (<?= $jsonSongsList ?>.length > 0){
        setMusicsList(<?= $jsonSongsList ?>);
    }else{// Otherwise, we load the musics from all the suites of this movie
        setMusicsList(<?= $jsonSuiteSongsList ?>);
    }
    // Same thing for the characters except that all the characters of all the suites of this movie are directly loaded
    setCharactersList(<?= $jsonCharactersList ?>);

    // This event is used to change the playlist (I had no other choice but to place it here...)
    const $suiteSongsSwitch = $('#showFullSerie');
    $suiteSongsSwitch.on('click', (event) => {
        if(event.target.checked){
            setMusicsList(<?= $jsonSuiteSongsList ?>);
            suiteSongsList.classList.remove('hidden');
            suiteSongsList.classList.add('d-flex');
            movieSongsList.classList.remove('d-flex');
            movieSongsList.classList.add('hidden');
        }else{
            setMusicsList(<?= $jsonSongsList ?>);
            movieSongsList.classList.remove('hidden');
            movieSongsList.classList.add('d-flex');
            suiteSongsList.classList.remove('d-flex');
            suiteSongsList.classList.add('hidden');
        }
    });
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
                    switch($movieDetails['type']){
                        case 2:
                            $customLength = ' d\'un épisode';
                            break;
                        case 3:
                            $customLength = ' totale';
                            break;
                        default:
                            $customLength = '';
                    }
                    $hours = floor($movieDetails['length']/60);
                    $minutes = $movieDetails['length'] - ($hours*60);
                    $minutesOnly = false;
                    if($hours < 1){
                        $minutesOnly = true;
                    }
                ?>
                <?php if($movieDetails['type'] != 4) :?>
                    <p id="movieLength" class="movieHeader-info-details-text">Durée<?= $customLength ?> : <?= !$minutesOnly ? $hours .'h' : '' ?><?= $minutes < 10 && !$minutesOnly ? '0' : '' ?><?= $minutes ?><?= $minutesOnly ? ' minutes' : '' ?></p>
                <?php endif; ?>
                <?php if($movieDetails['story'] != "") :?>
                    <h3 class="movieHeader-info-details-title">Description :</h3>
                    <p class="movieHeader-info-details-text longText"><?= $movieDetails['story'] ?></p>
                <?php endif; ?>
                <!-- Liste des suites éventuelles -->
                <?php if(count($movieSuiteList) > 1) :?>
                    <h3 id="movieSuiteTitle" class="movieHeader-info-details-title">Dans la même collection :</h3>
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

<?php if(count($movieSuiteSongs) > 0): ?>
<section class="section midGreyBG">
    <div class="section-container">
        <h3 class="sectionTitle">Extraits</h3>
        <?php if(count($movieSongs) > 0 && count($movieSongs) != count($movieSuiteSongs)): ?>
        <div class="movieMusicListOptions">
            <label for="showFullSerie">Collection complète : </label>
            <input type="checkbox" name="showFullSerie" id="showFullSerie" />
        </div>
        <?php endif; ?>
    </div>
</section>
<section class="section greyBG">
    <?php if(count($movieSongs) > 0): ?>
    <div id="musicList" class="movieMusicList section-container d-flex fairSpread">
        <!-- Contient la liste des chansons -->
        <?php for($i=0;$i<count($movieSongs);$i++) : ?>
            <div class="listElement">
                <h3><?= $movieSongs[$i]['title'] ?></h3>
                <?php 
                    $errorDetected = '';
                    if(check_url('https://img.youtube.com/vi/'.$movieSongs[$i]['youtubeId'].'/1.jpg') !== 200){
                        $errorDetected = ' imageNotFound';
                    }
                ?>
                <img class="songItem<?= $errorDetected ?>" data-not-found="<?= $movieSongs[$i]['id'].'_/_'.$movieSongs[$i]['movie'].'_/_'.$movieSongs[$i]['youtubeId'] ?>" id="song-<?= $i ?>" title="<?= $movieSongs[$i]['title'] ?>" src="https://img.youtube.com/vi/<?= $movieSongs[$i]['youtubeId'] ?>/1.jpg" alt="<?= $movieSongs[$i]['title'] ?>" />
            </div>
        <?php endfor; ?>
        <script>
            function addLog(eventType, message) {
                $.ajax({url: '/api/addlog', 
                    data: {
                        'event_type': eventType,
                        'message': message
                    }
                });
            }

            brokenVideos = Array.from(document.getElementsByClassName('imageNotFound'));
            brokenVideos.forEach((item) => {
                const songData = item.getAttribute('data-not-found').split('_/_');
                const response = 'id : ' + songData[0] + ', Movie : ' + songData[1] + ', Title : ' + item.getAttribute('title') + ', Youtube ID : ' + songData[2];
                addLog(1, response);
            });
        </script>
    </div>
    <?php endif; ?>
    <?php if(count($movieSuiteSongs) > 0): ?>
    <div id="musicList" class="suiteMusicList section-container fairSpread<?= count($movieSongs) > 0?' hidden':' d-flex' ?>">
        <!-- Contient la liste des chansons -->
        <?php for($i=0;$i<count($movieSuiteSongs);$i++) : ?>
            <div class="listElement">
                <h3><?= $movieSuiteSongs[$i]['title'] ?></h3>
                <?php 
                    $errorDetected = '';
                    if(check_url('https://img.youtube.com/vi/'.$movieSuiteSongs[$i]['youtubeId'].'/1.jpg') !== 200){
                        $errorDetected = ' imageNotFound';
                    }
                ?>
                <img class="songItem<?= $errorDetected ?>" data-not-found="<?= $movieSuiteSongs[$i]['id'].'_/_'.$movieSuiteSongs[$i]['movie'].'_/_'.$movieSuiteSongs[$i]['youtubeId'] ?>" id="song-<?= $i ?>" title="<?= $movieSuiteSongs[$i]['title'] ?>" src="https://img.youtube.com/vi/<?= $movieSuiteSongs[$i]['youtubeId'] ?>/1.jpg" alt="<?= $movieSuiteSongs[$i]['title'] ?>" />
            </div>
        <?php endfor; ?>
        <script>
            function addLog(eventType, message) {
                $.ajax({url: '/api/addlog', 
                    data: {
                        'event_type': eventType,
                        'message': message
                    }
                });
            }

            brokenVideos = Array.from(document.getElementsByClassName('imageNotFound'));
            brokenVideos.forEach((item) => {
                const songData = item.getAttribute('data-not-found').split('_/_');
                const response = 'id : ' + songData[0] + ', Movie : ' + songData[1] + ', Title : ' + item.getAttribute('title') + ', Youtube ID : ' + songData[2];
                addLog(1, response);
            });
        </script>
    </div>
    <?php endif; ?>
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

<?php if(count($suiteCharacters) > 0): ?>
<section class="section midGreyBG">
    <div class="section-container">
        <h3 class="sectionTitle">Personnages</h3>
    </div>
</section>
<section class="section greyBG">
    <div class="section-container d-flex fairSpread">
        <div id="charactersList">
            <!-- Contient la liste des personnages -->
            <?php for($i=0;$i<count($suiteCharacters);$i++) : ?>
                <div class="listElement">
                    <h3><?= $suiteCharacters[$i]['name'] ?></h3>
                    <img class="elementImg" id="char-<?= $i ?>" title="<?= $suiteCharacters[$i]['name'] ?>" src="./img/characters/<?= $suiteCharacters[$i]['img'] ?>" alt="<?= $suiteCharacters[$i]['name'] ?>" />
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