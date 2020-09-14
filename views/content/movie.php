<script>
    //On transmet les données de PHP au Javascript
    const movieInfo = <?= $params['movieDetails'] ?>;
    const suiteList = <?= $params['suite'] ?>;
    const musicList = <?= $params['songs'] ?>;
    setMusicList(musicList);
    const charList = <?= $params['characters'] ?>;
</script>

<section id="movieHeader">
    <img id="moviePageImg" src="./img/<?= $params['movie']->movie_img ?>" />
    <div id="moviePageInfo">
        <h2 id="movieTitle"></h2>
        <div id="movieDetails">
            <h3>Informations :</h3>
            <p id="movieDate"></p>
            <p id="movieLength"></p>
            <p id="movieStory"></p>
            <!-- Liste des suites éventuelles -->
        </div>
    </div>
    <script>
        showMovie(movieInfo[0], suiteList);
    </script>
</section>

<?php if($params['songs'] !== '[]'): ?>
    <h2 class="movieSectionTitle">Musiques</h2>
    <div id="musicList">
        <!-- Contient la liste des chansons -->
    </div>
    <section id="videoPlayer" class="hidden" onclick="closePlayer()">  
        <div id="videoPlayed"></div>
    </section>
    <script>
        //On affiche la liste des chansons
        showSongs(musicList);
    </script>
<?php endif; ?>

<?php if($params['characters'] !== '[]'): ?>
    <h2 class="movieSectionTitle">Personnages</h2>
    <div id="charactersDisplay">
        <div id="charactersList">
            <!-- Contient la liste des personnages -->
        </div>
        <div id="charInfo" class="hidden">
            <img id="closeInfo" src="./img/close.png" title="Fermer" onclick="closeInfo()" />
            <img id="charImg" />
            <h3 id="charName"></h3>
            <p id="charMovie">Film : <a id="charMovieLink"></a></p>
            <p id="charDesc"></p>
        </div>
        <script>
            //On affiche la liste des personnages
            showCharacters(charList);
        </script>
    </div>
<?php endif; ?>