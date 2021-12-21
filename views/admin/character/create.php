<?php
    $movies = $params['movies'];
?>

<section class="section whiteBG">
    <div class="section-container">
        <h1 class="pageTitle">Ajouter un personnage</h1>
        <a class="backLink" href="/admin/characters" title="Retour">Retour</a>
    </div>
</section>

<section class="section whiteBG">
    <div class="section-container">
        <form method="post" action="/admin/characters/create" class="admin-form">
            <fieldset>
                <legend>Film lié à ce personnage</legend>
                <select id="movieField" name="characterMovie" required="required">
                    <?php
                    /** @var App\Entities\Movie $movie */
                    foreach ($movies as $movie): ?>
                        <option value="<?= $movie->getId() ?>"><?= $movie->getTitle() ?></option>
                    <?php endforeach; ?>
                </select>
            </fieldset>
            <fieldset class="mainInfo">
                <legend>Infos concernant le personnage</legend>
                <label for="characterName">Nom</label>
                <input type="text" id="characterName" name="characterName" placeholder="Nom" value="" required="required">
                <label for="characterImg">Url de l'image</label>
                <input type="text" id="characterImg" name="characterImg" placeholder="Url de l'image" value="" required="required">
                <label for="characterDesc">Description</label>
                <textarea id="characterDesc" name="characterDesc" value="0" required="required"></textarea>
            </fieldset>
            <input type="submit" name="submitButton" value="Valider">
        </form>
        <div id="movieCharactersList">
            <h2>Autres personnages liés à ce film :</h2>
            <table class="admin-table">
            </table>
        </div>
    </div>
</section>

<script src="../../../public/scripts/admin.js"></script>