<?php

namespace Routes;

use App\Controllers\ViewController;
use Database\ServerConnection;

class Route{

    public $path;
    public $view;
    public $matches;

    public function __construct(string $path, string $view){
        $this->path = trim($path, '/');
        $this->view = $view;
    }

    /**
     * Check if the current URL matches this route
     */
    public function routeMatches(string $url):bool {
        // If the path of this route contains ":movieTitle", remove this part from the path to begin the matching test (in this case, it means that it's the movie page of the application)
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        // If this path (without movie title) matches the path of the movie page, add the current movie slug to the matches list of this route
        if(preg_match($pathToMatch, $url, $matches)){
            $this->matches = $matches;
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Use this route
     */
    public function startRoute(){
        // Split the controller to use and his method
        $view = explode('@', $this->view);

        // Create the controller object and store the method to use in a variable with a more suitable name
        $controller = new $view[0](new ServerConnection(DB_HOST, DB_USER, DB_PWD, DB_NAME));
        $method = $view[1];

        // Trigger the method of the controller (if it's the movie page, pass the current movie slug to the method)
        if(isset($this->matches[1])){
            return $controller->$method($this->matches[1]);
        }
        else{
            return $controller->$method();
        }
    }

}