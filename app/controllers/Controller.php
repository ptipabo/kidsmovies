<?php

namespace App\Controllers;

use Database\ServerConnection;

class Controller{

    protected $db;

    public function __construct(ServerConnection $db){
        $this->db = $db;
    }

    public function view(string $filePath, array $params = null){

        ob_start();

            $filePath = str_replace('.',DIRECTORY_SEPARATOR, $filePath);
            
            require VIEWS.$filePath.'.php';
            
        $content = ob_get_clean();

        require VIEWS.'layout.php';
    }
}