<?php

require 'vendor/autoload.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disney Movies</title>
</head>
<body>
    <h1><a href="./index.php">Disney Movies</a></h1>
    <div class="moviesList">

        <?php

            use Database\ServerConnection;

            $db = new ServerConnection('localhost', 'root', '', 'disneymovies');
            $req = $db->getConnection()->query('SELECT * FROM movies');
            $movies = $req->fetchAll();

            /*$test = new ServerConnection('localhost', 'root', '');
            $req2 = $test->getConnection()->query('SHOW DATABASES'); --> Ca fonctionne!!! :D
            $dblist = $req2->fetchAll();
            var_dump($dblist);*/

            foreach($movies as $movie){
                echo '<div class="movie">';
                    echo '<img class="moviePicture" src="./img/'.$movie->movie_img.'" />';
                    echo '<h2 class="movieTitle">'.$movie->movie_title.'</h2>';
                    echo '<p class="movieDate">'.$movie->movie_date.'</p>';
                    echo '<a href="./movie.php?id='.$movie->movie_id.'">Plus d\'infos...</a>';
                echo '</div>';
            }
        ?>
    </div>
</body>
</html>