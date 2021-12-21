<?php
    $movieSuites = $params['movieSuites'];
?>

<section class="section whiteBG">
    <div class="section-container">
        <h1 class="pageTitle">Ajouter un film</h1>
        <a class="backLink" href="/admin/movies" title="Retour">Retour</a>
    </div>
</section>

<section class="section whiteBG">
    <div class="section-container">
        <form method="post" action="/admin/movies/create" class="admin-form">
            <fieldset>
                <legend>Série liée à ce film</legend>
                <div class="suiteChoice">
                    <input id="existingSuite" type="radio" name="suiteChoice" value="0" checked><label for="existingSuite">Série existante</label>
                    <input id="newSuite" type="radio" name="suiteChoice" value="1"><label for="newSuite">Nouvelle série</label>
                </div>
                <select id="movieSuiteField" name="movieSuite" required="required">
                    <?php
                    /** @var \App\Entities\MovieSuite $suite */
                    foreach ($movieSuites as $suite): ?>
                        <option value="<?= $suite->getId() ?>"><?= $suite->getTitle() ?></option>
                    <?php endforeach; ?>
                </select>
                <input id="newMovieSuiteField" type="text" name="newMovieSuite" placeholder="Titre de la série" value="">
            </fieldset>
            <fieldset class="mainInfo">
                <legend>Infos concernant le film</legend>
                <label for="movieImg">Affiche</label>
                <input type="text" id="movieImg" name="movieImg" placeholder="Affiche" value="" required="required">
                <label for="movieTitle">Titre</label>
                <input type="text" id="movieTitle" name="movieTitle" placeholder="Titre" value="" required="required">
                <label for="movieStory">Synopsis</label>
                <textarea id="movieStory" name="movieStory" placeholder="Synopsis" required="required"></textarea>
                <label for="movieLength">Durée (en minutes)</label>
                <input type="number" id="movieLength" name="movieLength" value="0" required="required">
                <label for="movieDate">Année de sortie</label>
                <input type="number" id="movieDate" name="movieDate" min="1900" max="<?= date('Y') ?>" step="1" value="2000" required="required">
                <label for="movieSlug">Slug</label>
                <input type="text" id="movieSlug" name="movieSlug" placeholder="Slug" value="" required="required">
            </fieldset>
            <input type="submit" name="submitButton" value="Valider">
        </form>
    </div>
</section>

<script src="../../../public/scripts/admin.js"></script>