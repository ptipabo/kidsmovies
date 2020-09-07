<div class="pageHeader">
    <h2>Musiques</h2>
</div>

<div class="mainContent">
    <?php foreach($params['songs'] as $song): ?>
        <div class="listElement">
            <?php
                foreach($params['movies'] as $movie){
                    if($song->song_movie === $movie->movie_id){
                        $movieTitle = $movie->movie_title;
                    }
                }
            ?>
            <h3 class="elementTitle">
                <span class="elementMovie">
                    <?= $movieTitle ?>
                </span><br/>
                <?= $song->song_title ?>
            </h3>
            
            <?php $videoId = explode('/', $song->song_video); ?>
            
            <img class="elementImg" title="<?= $song->song_title ?>" src="https://img.youtube.com/vi/<?= $videoId[4] ?>/1.jpg" onclick="play('<?= $song->song_video ?>')" />
        </div>
        <div id="videoPlayer" class="hidden" onclick="closePlayer()">
            <iframe id="videoPlayed" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    <?php endforeach ?>
</div>