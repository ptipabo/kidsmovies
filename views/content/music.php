<?php
    $songs = $params['songs'];
    $users = $params['users'];
    $types = $params['types'];
    $jsonSongsList = json_encode($songs);
    $jsonUsersList = json_encode($users);
    $jsonTypesList = json_encode($types);
?>
<script type="module">
    import {setMusicsList, setUsersList, setTypesList} from '../../public/scripts/songs.js';
    // For the video player to work, we need to pass the songs data to JS
    setMusicsList(<?= $jsonSongsList ?>);
    setUsersList(<?= $jsonUsersList ?>);
    setTypesList(<?= $jsonTypesList ?>);
</script>

<section class="section whiteBG">
    <div class="section-container">
        <h2 class="pageTitle">Musiques</h2>
        <div class="musicFilters">
            <ul class="usersList">
                <?php
                    foreach($users as $user){
                        echo '<li class="usersList_user user_'.$user['id'].' userColor_'.strToLower($user['color']).'" title="'.$user['name'].'" style="background-image:url(\'/img/users/'.strToLower($user['name']).'.jpg\');">'.strToUpper($user['name'][0]).'</li>';
                    }
                ?>   
            </ul>
            <ul class="contentTypesList">
                <?php
                    foreach($types as $type){
                        echo '<li class="contentTypesList_type type_'.$type['id'].'">'.$type['name'].'</li>';
                    }
                ?>
                <li id="randomModeButton">Aléatoire</li>
            </ul>
        </div>
    </div>
</section>

<section class="section darkGreyBG">
    <div id="videoPlayerSection" class="section-container">
        <button id="randomJukeboxBtn" class="kidsMoviesBtn yellowBG">Random jukebox</button>
        <button id="randowJukeboxBtnStop" class="kidsMoviesBtn redBG hidden">Arrêter le Jukebox</button>
        <div id="videoPlayerContainer" class="random">
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
                <ul class="song_usersList">
                    <?php foreach($users as $user) : ?>
                        <?php 
                        $userDetected = false;
                        foreach($songs[$i]['users'] as $songUser){
                            if($songUser['userId'] == $user['id']){
                                $userDetected = true;
                            }
                        } ?>
                        <li class="<?= $userDetected ? 'songUser' : 'notSongUser' ?> border favourite userColor_<?= $user['color'] ?>" id="favData_<?= $songs[$i]['id'] ?>_<?= $user['id'] ?>" title="<?= $userDetected ? 'Retirer des' : 'Ajouter aux' ?> favoris de <?= $user['name'] ?>"><?= $user['name'][0] ?></li>
                    <?php endforeach; ?>
                </ul>
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