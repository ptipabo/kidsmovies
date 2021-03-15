<?php
    $songs = $params['songs'];
    $jsonSongsList = json_encode($songs);
?>
<script type="module">
    import {setMusicsList} from '../../public/scripts/songs.js';
    // For the video player to work, we need to pass the songs data to JS
    setMusicsList(<?= $jsonSongsList ?>);
</script>

<section id="pageHeader">
    <h2>Jeux</h2>
</section>

<section class="section">
    <div id="videoPlayerSection" class="section-container">
        <button id="randomJukeboxBtn" class="kidsMoviesBtn">Random jukebox</button>
        <div id="videoPlayerContainer">
            <div id="videoPlayer-games"></div>
        </div>
    </div>
</section>

<script type="module" src="../../public/scripts/games.js"></script>