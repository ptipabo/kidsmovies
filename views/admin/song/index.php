<section class="section whiteBG">
    <div class="section-container">
        <h1 class="pageTitle">Administration des chansons</h1>
        <div class="linksBlock">
            <a class="backLink" href="/admin/" title="Retour">Retour</a>
            <a class="kidsMoviesBtn blueBG" href="/admin/songs/create" title="Ajouter une chanson">Ajouter une chanson</a>
        </div>
    </div>
</section>

<table class="admin-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Film</th>
            <th>Titre</th>
            <th>Lien Youtube</th>
            <th>Censurée</th>
            <th>Ordre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $songs = $params['songs'];
        $movies = $params['movies'];

        /** @var \App\Entities\Song $song */
        foreach($songs as $song): ?>
            <?php 
                $movieTitle = $song->getMovie();
                foreach($movies as $movie){
                    if($movie->getId() == $song->getMovie()){
                        $movieTitle = $movie->getTitle();
                    }
                }
            ?>
            <tr>
                <td><?= $song->getId() ?></td>
                <td><?= $movieTitle ?></td>
                <td><?= $song->getTitle() ?></td>
                <td><?= $song->getVideo() ?></td>
                <td><?= $song->isCensored()?'<span class="btn btn-danger">oui</span>':'<span class="btn btn-green">non</span>' ?></td>
                <td><?= $song->getOrder() ?></td>
                <td>
                    <a href="/admin/songs/edit/<?= $song->getId() ?>" class="link editButton">Modifier</a>
                    <?php
                        // This button has the power to destroy a movie from the DB so it is commented to not do something we would regret...
                        /*<a href="/admin/songs/<?= $song->getId() ?>" class="deleteButton redVersion">Supprimer</a>*/
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>