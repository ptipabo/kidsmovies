<?php

namespace App\Models;

use App\Entities\MovieSuite as MovieSuiteEntity;
use PDO;

class Moviesuite extends Model{
    
    protected $table = 'moviesuite';

    public function all(): array
    {
        $rawData = parent::all();

        $movieSuites = [];
        foreach($rawData as $data){
            $suite = new MovieSuiteEntity();
            $suite->setId($data->suite_id);
            $suite->setTitle($data->suite_title);
            $movieSuites[] = $suite;
        }

        return $movieSuites;
    }

    public function findOneByTitle(string $suiteTitle){
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM ".$this->table." WHERE suite_title=?");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$suiteTitle]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        //Ensuite on enclenche et on renvoit toutes les données trouvées
        return $stmt->fetch();
    }

    public function createSuite(\App\Entities\MovieSuite $newMovieSuite){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (suite_title) VALUES ('".$newMovieSuite->getTitle()."')")){
            return true;
        }

        return false;
    }
}