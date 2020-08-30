<?php

namespace Routes;

use Database\ServerConnection;

class Route{

    public $path;
    public $view;
    public $matches;

    public function __construct(string $path, string $view){
        $this->path = trim($path, '/');
        $this->view = $view;
    }

    //Permet de vérifier si l'url correspond à cette route
    public function routeMatches(string $url){
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        if(preg_match($pathToMatch, $url, $matches)){
            $this->matches = $matches;
            return true;
        }
        else{
            return false;
        }
    }

    //Permet d'enclencher cette route
    public function startRoute(){

        //D'abord on sépare le controleur à utiliser et sa méthode
        $view = explode('@', $this->view);
        //On crée notre controleur
        $controller = new $view[0](new ServerConnection('localhost', 'root', '', 'kidsmovies'));
        $method = $view[1];

        //On enclenche la méthode du controleur
        if(isset($this->matches[1])){
            return $controller->$method($this->matches[1]);
        }
        else{
            return $controller->$method();
        }
    }

}