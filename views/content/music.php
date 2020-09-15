<script>
    //On transmet les données de PHP au Javascript
    const musicList = <?= $params['songs'] ?>;
    setMusicList(musicList);
</script>

<section id="pageHeader">
    <h2>Musiques</h2>
</section>

<section id="musicList">
    <!-- Contient la liste des chansons -->
</section>

<section id="videoPlayer" class="hidden" onclick="closePlayer()">  
    <div id="videoNavBar">
        <img id="previousVid" src="./img/previous.png" title="Vidéo précédente" />
        <img id="closeVid" src="./img/close.png" onclick="closePlayer()" title="Fermer le lecteur" />
        <img id="nextVid" src="./img/next.png" title="Vidéo suivante" />
    </div>
    <div id="videoPlayed"></div>
</section>

<script>
    //On affiche la liste des chansons
    showSongs(musicList);
</script>