<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= TITLE ?></title>
        <link rel="stylesheet" href="<?= PUBLICFOLDER.'css'.DIRECTORY_SEPARATOR.'style.css' ?>"/>
        <link rel="icon" href="./favicon.ico" />
        <!--JQuery installed!-->
        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous">
        </script>
        <script src="http://www.youtube.com/iframe_api"></script>
    </head>
    <body>
        <header>
            <h1 class="mainTitle"><a title="<?= TITLE ?>" href="<?= dirname(PUBLICFOLDER) ?>"><span id="titleLetterA">K</span><span id="titleLetterB">i</span><span id="titleLetterC">d</span><span id="titleLetterD">s</span> Movies</a></h1>
            <nav class="navMenu">
                <a class="pageLink navMovie" href="./" title="Films">Films</a>
                <a class="pageLink navMusic" href="./music" title="Musiques">Musiques</a>
                <a class="pageLink navChar" href="./characters" title="Personnages">Personnages</a>
                <a class="pageLink navGame" href="./games" title="Jeux">Jeux</a>
            </nav>
        </header>
        <main>
            <?= $content ?>
        </main>
    </body>
</html>