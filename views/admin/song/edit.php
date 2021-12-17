<?php
    /** @var App\Entities\Song $song */
    $song = $params['song'];
    $movies = $params['movies'];
?>

<section class="section whiteBG">
    <div class="section-container">
        <h1 class="pageTitle">Ajouter une chanson</h1>
        <a class="backLink" href="/admin/songs" title="Retour">Retour</a>
    </div>
</section>

<section class="section whiteBG">
    <div class="section-container">
        <form method="post" action="/admin/songs/create" class="admin-form">
            <fieldset>
                <legend>Film lié à cette chanson</legend>
                <select id="movieField" name="movie" required="required">
                    <?php
                    /** @var App\Entities\Movie $movie */
                    foreach ($movies as $movie): ?>
                        <option value="<?= $movie->getId() ?>"<?= $song->getMovie() == $movie->getId() ? ' selected' : '' ?>><?= $movie->getTitle() ?></option>
                    <?php endforeach; ?>
                </select>
            </fieldset>
            <fieldset class="mainInfo">
                <legend>Infos concernant la chanson</legend>
                <label for="songTitle">Titre</label>
                <input type="text" id="songTitle" name="songTitle" placeholder="Titre" value="<?= $song->getTitle() ? $song->getTitle() : '' ?>" required="required">
                <label for="songVideo">Id vidéo Youtube</label>
                <input type="text" id="songVideo" name="songVideo" placeholder="Id vidéo Youtube" value="<?= $song->getVideo() ? $song->getVideo() : '' ?>" required="required">
                <label for="songCensored">Censurée</label>
                <input id="songCensored" type="checkbox" name="songCensored"<?= $song->isCensored() ? ' checked' : '' ?>>
                <label for="songOrder">Ordre</label>
                <input type="number" id="songOrder" name="songOrder" value="<?= $song->getOrder() ? $song->getOrder() : '0' ?>" required="required">
            </fieldset>
            <input type="submit" name="submitButton" value="Valider">
        </form>
    </div>
</section>