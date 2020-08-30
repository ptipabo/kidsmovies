<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= TITLE ?></title>
        <link rel="stylesheet" href="<?= SCRIPTS.'css'.DIRECTORY_SEPARATOR.'style.css' ?>"/>
    </head>
    <body>
    <h1><a href="<?= dirname(SCRIPTS) ?>"><?= TITLE ?></a></h1>
        <?= $content ?>
    </body>
</html>