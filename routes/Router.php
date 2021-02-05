<?php

namespace Routes;

class Router{

    public $url;
    public $routes = [];

    public function __construct($url){
        $this->url = trim($url, '/');
    }

    /**
     * Adds a "GET" type route to the list of routes of the application
     */
    public function setGetRoute(string $path, string $view){
        $this->routes['GET'][] = new Route($path, $view);
    }

    /**
     * Adds a "POST" type route to the list of routes of the application
     */
    public function setPostRoute(string $path, string $view){
        $this->routes['POST'][] = new Route($path, $view);
    }

    /**
     * Checks if the current URL matches one of the routes of the application
     */
    public function urlCheck(){
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->routeMatches($this->url)){
                // If the URL matches this route, return the view of this route
                return $route->startRoute();
            }
        }

        // If none of the routes match the URL, returns a 404 error
        return header('HTTP/1.0 404 Not Found');
    }
}