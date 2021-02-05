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
    <h2>Musiques</h2>
</section>

<section id="musicList">
    <!-- Contient la liste des chansons -->
    <?php for($i=0;$i<count($songs);$i++) : ?>
        <div class="listElement">
            <h3><span><?= $songs[$i]['movie'] ?></span><br/><?= $songs[$i]['title'] ?></h3>
            <img class="songItem" id="song-<?= $i ?>" title="<?= $songs[$i]['title'] ?>" src="https://img.youtube.com/vi/<?= $songs[$i]['youtubeId'] ?>/1.jpg" alt="<?= $songs[$i]['title'] ?>" />
        </div>
    <?php endfor; ?>
</section>

<section id="videoPlayer" class="hidden">
    <div id="videoNavBar">
        <img id="previousVid" src="./img/previous.png" title="Vidéo précédente" />
        <img id="closeVid" src="./img/close.png" title="Fermer le lecteur" />
        <img id="nextVid" src="./img/next.png" title="Vidéo suivante" />
    </div>    
    <div id="videoPlayed"></div>
</section>