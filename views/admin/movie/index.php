<section class="section whiteBG">
    <div class="section-container">
        <h1 class="pageTitle">Administration des films</h1>
        <div class="linksBlock">
            <a class="backLink" href="/admin/" title="Retour">Retour</a>
            <a class="kidsMoviesBtn blueBG" href="/admin/movies/create" title="Ajouter un film">Ajouter un film</a>
        </div>
    </div>
</section>

<table class="admin-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titre</th>
            <th>Année de sortie</th>
            <th>Durée (en minutes)</th>
            <th>Image</th>
            <th>Suite</th>
            <th>Slug</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $movies = $params['movies'];
        $movieSuites = $params['movieSuites'];
        /** @var \App\Entities\Movie $movie */
        foreach($movies as $movie): ?>
            <?php 
                $suiteTitle = $movie->getSuite();
                foreach($movieSuites as $suite){
                    if($suite->getId() == $movie->getSuite()){
                        $suiteTitle = $suite->getTitle();
                    }
                }
            ?>
            <tr>
                <td><?= $movie->getId() ?></td>
                <td><?= $movie->getTitle() ?></td>
                <td><?= $movie->getDate() ?></td>
                <td><?= $movie->getLength() ?></td>
                <td><?= $movie->getImg() ?></td>
                <td><?= $suiteTitle ?></td>
                <td><?= $movie->getSlug() ?></td>
                <td>
                    <a href="/admin/movies/edit/<?= $movie->getId() ?>" class="link editButton">Modifier</a>
                    <?php
                        // This button has the power to destroy a movie from the DB so it is commented to not do something we would regret...
                        /*<a href="/admin/movies/<?= $movie->getId() ?>" class="deleteButton redVersion">Supprimer</a>*/
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>