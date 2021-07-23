<?php
    $songs = $params['songs'];
    $users = $params['users'];
    $jsonSongsList = json_encode($songs);
    $jsonUsersList = json_encode($users);
?>
<script type="module">
    import {setMusicsList} from '../../public/scripts/songs.js';
    // For the video player to work, we need to pass the songs data to JS
    setMusicsList(<?= $jsonSongsList ?>);
</script>

<section class="section whiteBG">
    <div class="section-container">
        <h2 class="pageTitle">Musiques</h2>
        <ul class="usersList">
            <?php
                foreach($users as $user){
                    echo '<li class="usersList_user user_'.$user['id'].' userColor_'.strToLower($user['color']).'">'.strToUpper($user['name'][0]).'</li>';
                }
            ?>   
        </ul>
    </div>
</section>

<section class="section darkGreyBG">
    <div id="videoPlayerSection" class="section-container">
        <button id="randomJukeboxBtn" class="kidsMoviesBtn yellowBG">Random jukebox</button>
        <button id="randowJukeboxBtnStop" class="kidsMoviesBtn redBG hidden">Arrêter le Jukebox</button>
        <div id="videoPlayerContainer">
            <div id="videoPlayer-jukeBox"></div>
        </div>
    </div>
    <script type="module" src="../../public/scripts/jukeBox.js"></script>
</section>

<section class="section greyBG">
    <div id="musicList" class="section-container d-flex fairSpread">
        <!-- Contient la liste des chansons -->
        <?php for($i=0;$i<count($songs);$i++) : ?>
            <div class="listElement">
                <h3><span><?= $songs[$i]['movie'] ?></span><br/><?= $songs[$i]['title'] ?></h3>
                <img class="songItem" id="song-<?= $i ?>" title="<?= $songs[$i]['title'] ?>" src="https://img.youtube.com/vi/<?= $songs[$i]['youtubeId'] ?>/1.jpg" alt="<?= $songs[$i]['title'] ?>" />
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
    <div id="videoPlayed"></div>
</section>