<?php
    /** @var App\Entities\Character $character */
    $character = $params['character'];
    $movieCharacters = $params['movieCharacters'];
    $movies = $params['movies'];
?>

<section class="section whiteBG">
    <div class="section-container">
        <h1 class="pageTitle">Modifier un personnage</h1>
        <a class="backLink" href="/admin/characters" title="Retour">Retour</a>
    </div>
</section>

<section class="section whiteBG">
    <div class="section-container">
        <form method="post" action="/admin/characters/edit/<?= $character->getId() ?>" class="admin-form">
            <fieldset>
                <legend>Film lié à cette chanson</legend>
                <select id="movieField" name="characterMovie" required="required">
                    <?php
                    /** @var App\Entities\Movie $movie */
                    foreach ($movies as $movie): ?>
                        <option value="<?= $movie->getId() ?>"<?= $character->getMovie() == $movie->getId() ? ' selected' : '' ?>><?= $movie->getTitle() ?></option>
                    <?php endforeach; ?>
                </select>
            </fieldset>
            <fieldset class="mainInfo">
                <legend>Infos concernant le personnage</legend>
                <label for="characterName">Nom</label>
                <input type="text" id="characterName" name="characterName" placeholder="Nom" value="<?= $character->getName() ? $character->getName() : '' ?>" required="required">
                <label for="characterImg">Url de l'image</label>
                <input type="text" id="characterImg" name="characterImg" placeholder="Url de l'image" value="<?= $character->getImg() ? $character->getImg() : '' ?>" required="required">
                <label for="characterDesc">Description</label>
                <textarea id="characterDesc" name="characterDesc" required="required"><?= $character->getDesc() ? $character->getDesc() : '' ?></textarea>
            </fieldset>
            <input type="submit" name="submitButton" value="Valider">
        </form>
        <div id="movieCharactersList">
            <h2>Autres personnages liés à ce film :</h2>
            <table class="admin-table">
                <tr><th>Nom</th></tr>
                <?php
                /** @var App\Entities\Character $movieCharacter */
                foreach ($movieCharacters as $movieCharacter): ?>
                    <?php if($movieCharacter->getId() != $character->getId()): ?>
                        <tr><td><a href="/admin/characters/edit/<?= $movieCharacter->getId() ?>"><?= $movieCharacter->getName() ?></a></td></tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</section>

<script src="../../../public/scripts/admin.js"></script>