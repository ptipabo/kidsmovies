<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= TITLE ?></title>
        <link rel="stylesheet" href="<?= SCRIPTS.'css'.DIRECTORY_SEPARATOR.'style.css' ?>"/>
        <link rel="icon" href="./favicon.ico" />
        <script src="<?= SCRIPTS.'scripts'.DIRECTORY_SEPARATOR.'init.js' ?>"></script>
    </head>
    <body>
        <header>
            <h1><a title="<?= TITLE ?>" href="<?= dirname(SCRIPTS) ?>"><?= TITLE ?></a></h1>
            <nav>
                <a id="navMovie" class="pageLink" href="./" title="Films">Films</a>
                <a id="navMusic" class="pageLink" href="./music" title="Musiques">Musiques</a>
                <a id="navChar" class="pageLink" href="./characters" title="Personnages">Personnages</a>
            </nav>
        </header>
        <main>
            <?= $content ?>
        </main>
    </body>
</html>