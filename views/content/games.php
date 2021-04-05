<?php
    $songs = $params['songs'];
    $jsonSongsList = json_encode($songs);
?>
<script type="module">
    import {setMusicsList} from '../../public/scripts/songs.js';
    // For the video player to work, we need to pass the songs data to JS
    setMusicsList(<?= $jsonSongsList ?>);
</script>

<section class="section whiteBG">
    <div class="section-container">
        <h2 class="pageTitle">Jeux</h2>
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