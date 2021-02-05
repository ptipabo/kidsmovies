<?php

namespace App\controllers;

use Database\ServerConnection;

abstract class Controller{

    protected $db;

    public function __construct(ServerConnection $db){
        $this->db = $db;
    }

    /**
     * Get the view of the route selected
     */
    protected function view(string $filePath, array $params = null){

        ob_start();

            $filePath = str_replace('.',DIRECTORY_SEPARATOR, $filePath);
            
            require VIEWS.$filePath.'.php';
            
        $content = ob_get_clean();

        require VIEWS.'layout.php';
    }

    /**
     * Make the connection to the database
     */
    protected function getDB(){
        return $this->db;
    }
}