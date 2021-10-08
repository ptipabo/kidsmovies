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

<section class="section blindTest">
    <div class="section-container">
        <h3 class="blindTest-title">Blind test</h3>
        <div class="blindTest-stepA">
            <form>
                <div>
                    <h4>Niveau de difficulté :</h4>
                    <input type="radio" id="level-veryEasy" value="1" name="level"><label for="level-veryEasy">Très facile</label>
                    <input type="radio" id="level-easy" value="4" name="level"><label for="level-easy">Facile</label>
                    <input type="radio" id="level-medium" value="3" name="level"><label for="level-medium">Normal</label>
                    <input type="radio" id="level-hard" value="2" name="level"><label for="level-hard">Difficile</label>
                    <input type="radio" id="level-extreme" value="5" name="level"><label for="level-extreme">Extrême</label>
                </div>
                <div>
                    <h4>Nombre joueurs :</h4>
                    <input type="radio" id="players-1" value="1" name="players"><label for="players-1">1</label>
                    <input type="radio" id="players-2" value="2" name="players"><label for="players-2">2</label>
                    <input type="radio" id="players-3" value="3" name="players"><label for="players-3">3</label>
                    <input type="radio" id="players-4" value="4" name="players"><label for="players-4">4</label>
                </div>
                <button class="kidsMoviesBtn blueBG">Commencer</button>
            </form>
        </div>
        <div class="blindTest-stepB">
            <div id="blindTest-stepB-container">
                <div id="blindTest-stepB-videoPlayer">Vidéo</div>
            </div>
        </div>
    </div>
    <script type="module" src="../../public/scripts/blindTest.js"></script>
</section>