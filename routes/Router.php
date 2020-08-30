<?php

namespace Routes;

class Router{

    public $url;
    public $routes = [];

    public function __construct($url){
        $this->url = trim($url, '/');
    }

    public function setGetRoute(string $path, string $view){
        $this->routes['GET'][] = new Route($path, $view);
    }

    public function setPostRoute(string $path, string $view){
        $this->routes['POST'][] = new Route($path, $view);
    }

    public function urlCheck(){
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->routeMatches($this->url)){
                return $route->startRoute();
            }
        }

        return header('HTTP/1.0 404 Not Found');
    }
}