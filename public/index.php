<?php

//On importe toutes les classes de l'application en une seule fois
require '../vendor/autoload.php';

//On indique au script qu'on va utiliser un objet de la classe Controller qui se trouve dans le namespace App\Controllers
use Routes\Router;
use App\Controllers\Controller;

//On définit quelques constantes importantes (Titre de l'application, répertoire des vues, répertoire des scripts et identifiants de la base de données)
define('TITLE', 'Kids Movies');
define('VIEWS', dirname(__DIR__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
define('PUBLICFOLDER', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'kidsmovies');

//On crée notre routeur en lui indiquant l'url actuelle
$router = new Router($_GET['url']);

//On crée toutes les routes de l'application (NB: la route '/:movieUrl' doit être placée en dernier sinon le navigateur confond le nom d'un film avec le nom de nos pages)
$router->setGetRoute('/', 'App\controllers\ViewController@home');
$router->setGetRoute('/music', 'App\controllers\ViewController@music');
$router->setGetRoute('/characters', 'App\controllers\ViewController@characters');
$router->setGetRoute('/games', 'App\controllers\ViewController@games');
$router->setGetRoute('/:movieUrl', 'App\controllers\ViewController@movie');

$router->setGetRoute('/api/checkfavourite', 'App\controllers\ApiController@checkFavourite');
$router->setGetRoute('/api/addfavourite', 'App\controllers\ApiController@addFavourite');
$router->setGetRoute('/api/removefavourite', 'App\controllers\ApiController@removeFavourite');

$router->setGetRoute('/admin/movies', 'App\controllers\Admin\MovieController@index');
$router->setGetRoute('/admin/movies/delete/:id', 'App\controllers\Admin\MovieController@destroy');

//On utilise la méthode urlCheck contenue dans Router.php
$router->urlCheck();

?>