<?php

namespace App\ORM;

use App\Entities\MovieSuite as MovieSuiteEntity;
use PDO;

class Moviesuite extends Model{
    
    protected $table = 'moviesuite';

    public function createSuite(\App\Entities\MovieSuite $newMovieSuite){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (suite_title) VALUES ('".$newMovieSuite->getTitle()."')")){
            return true;
        }

        return false;
    }
}