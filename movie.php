<?php

require 'vendor/autoload.php';

define('TITLE', 'Kids Movies');

use Database\ServerConnection;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
</head>
<body>
    <h1><a href="./index.php"><?= TITLE ?></a></h1>
    <?php
        $db = new ServerConnection('localhost', 'root', '', 'kidsmovies');
        $req = $db->getConnection()->query('SELECT * FROM movies WHERE movies.movie_id="'.$_GET['id'].'"');
        $movie = $req->fetchAll();
    ?>
    <h2><?= $movie[0]->movie_title ?></h2>
    <p>Année de sortie : <?= $movie[0]->movie_date ?> - Durée du film : <?= $movie[0]->movie_length ?> minutes</p>
    <img src="./img/<?= $movie[0]->movie_img ?>" />
    <div class="movieCharacters">
        <?php

        $db = new ServerConnection('localhost', 'root', '', 'kidsmovies');
        $req = $db->getConnection()->query('SELECT * FROM characters WHERE characters.char_movie="'.$_GET['id'].'"');
        $characters = $req->fetchAll();

        foreach($characters as $character){
            echo '<div class="character">';
                echo '<img class="charImg" src="./img/characters/'.$character->char_img.'" />';
                echo '<h3 class="charName">'.$character->char_name.'</h3>';
                echo '<p class="charDesc">'.$character->char_desc.'</p>';
            echo '</div>';
        }
        ?>
        <!--<div class="character">
            <img src="./img/characters/Flash_McQueen.jpg" />
            <h3>Flash McQueen</h3>
            <p>Flash McQueen est un champion de Nascar, il se considère comme un "instrument de précision et un bolide aérodynamique".</p>
        </div>
        <div class="character">
            <img src="./img/characters/Flash_McQueen.jpg" />
            <h3>Martin</h3>
            <p>Martin est le meilleur ami de Flash McQueen.</p>
        </div>-->
    </div>

</body>
</html>