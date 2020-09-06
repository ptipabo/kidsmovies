<?php

//On importe toutes les classes de l'application en une seule fois
require '../vendor/autoload.php';

//On indique au script qu'on va utiliser un objet de la classe Controller qui se trouve dans le namespace App\Controllers
use Routes\Router;
use App\Controllers\Controller;

//On définit quelques constantes importantes (Titre de l'application, répertoire des vues, répertoire des scripts et identifiants de la base de données)
define('TITLE', 'Kids Movies');
define('VIEWS', dirname(__DIR__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'kidsmovies');

//On crée notre routeur en lui indiquant l'url actuelle
$router = new Router($_GET['url']);

//On crée toutes les routes de l'application
$router->setGetRoute('/', 'App\Controllers\ViewController@home');
$router->setGetRoute('/music', 'App\Controllers\ViewController@music');
$router->setGetRoute('/characters', 'App\Controllers\ViewController@characters');
$router->setGetRoute('/:movieUrl', 'App\Controllers\ViewController@movie');

$router->urlCheck();

?>