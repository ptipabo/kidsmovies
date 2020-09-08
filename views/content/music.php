<script>
    musicList = <?= $params['songs'] ?>
</script>

<div class="pageHeader">
    <h2>Musiques</h2>
</div>

<div id="mainContent">
    <div id="videoPlayer" class="hidden" onclick="closePlayer()">
        <iframe id="videoPlayed" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>
<script>
    showSongs(musicList);
</script>