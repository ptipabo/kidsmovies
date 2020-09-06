<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= TITLE ?></title>
        <link rel="stylesheet" href="<?= SCRIPTS.'css'.DIRECTORY_SEPARATOR.'style.css' ?>"/>
        <script src="<?= SCRIPTS.'scripts'.DIRECTORY_SEPARATOR.'app.js' ?>"></script>
    </head>
    <body>
        <header>
            <h1><a title="<?= TITLE ?>" href="<?= dirname(SCRIPTS) ?>"><?= TITLE ?></a></h1>
            <nav>
                <a class="pageLink" href="./">Films</a>
                <a class="pageLink" href="./music">Musiques</a>
                <a class="pageLink" href="./characters">Personnages</a>
            </nav>
        </header>
        <main>
            <?= $content ?>
        </main>
    </body>
</html>