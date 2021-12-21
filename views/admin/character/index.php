<section class="section whiteBG">
    <div class="section-container">
        <h1 class="pageTitle">Administration des personnages</h1>
        <div class="linksBlock">
            <a class="backLink" href="/admin/" title="Retour">Retour</a>
            <a class="kidsMoviesBtn blueBG" href="/admin/characters/create" title="Ajouter un personnage">Ajouter un personnage</a>
        </div>
    </div>
</section>

<table class="admin-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Film</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $characters = $params['characters'];
        $movies = $params['movies'];

        /** @var App\Entities\Character $character */
        foreach($characters as $character): ?>
            <?php 
                $movieTitle = $character->getMovie();
                foreach($movies as $movie){
                    if($movie->getId() == $character->getMovie()){
                        $movieTitle = $movie->getTitle();
                    }
                }
            ?>
            <tr>
                <td><?= $character->getId() ?></td>
                <td><?= $movieTitle ?></td>
                <td><?= $character->getName() ?></td>
                <td>
                    <a href="/admin/characters/edit/<?= $character->getId() ?>" class="link editButton">Modifier</a>
                    <?php
                        // This button has the power to destroy a movie from the DB so it is commented to not do something we would regret...
                        /*<a href="/admin/characters/<?= $character->getId() ?>" class="deleteButton redVersion">Supprimer</a>*/
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>