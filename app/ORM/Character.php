<?php

namespace App\ORM;

use \App\Entities\Character as CharacterEntity;
use \App\Entities\Movie as MovieEntity;
use \App\Entities\MovieSuite as MovieSuiteEntity;

class Character extends Model{
    
    protected $table = 'characters';
    protected $findByMovie = 'char_movie';

    public function createCharacter(CharacterEntity $newCharacter){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (char_name, char_movie, char_img, char_desc) VALUES ('".$newCharacter->getName()."', '".$newCharacter->getMovie()."', '".$newCharacter->getImg()."', '".$newCharacter->getDesc()."')")){
            return true;
        }

        return false;
    }

    public function updateCharacter(CharacterEntity $newCharacter){
        if($this->db->getConnection()->query("UPDATE {$this->table} SET char_name = '".$newCharacter->getName()."', char_movie = ".$newCharacter->getMovie().", char_img = '".$newCharacter->getImg()."', char_desc = '".$newCharacter->getDesc()."' WHERE char_id = ".$newCharacter->getId().";")){
            return true;
        }
        return false;
    }

    public function findBySuite(MovieSuiteEntity $movieSuite)
    {
        $smtp = $this->db->getConnection()->query("SELECT * FROM movies WHERE movie_suite = {$movieSuite->getId()}");

        $rawData = $smtp->fetchAll();

        $moviesFromSuite = [];
        foreach($rawData as $data){
            $newMovie = $this->objectBuilder($data, 'movies');
            $moviesFromSuite[] = $newMovie;
        }

        $query = "SELECT * FROM {$this->table} WHERE";

        $movieCounter = 0;

        /** @var MovieEntity $movie */
        foreach ($moviesFromSuite as $movie){
            $query .= " char_movie = {$movie->getId()}";
            if(($movieCounter+1) < count($moviesFromSuite)){
                $query .= " OR";
            }else{
                $query .= " ORDER BY char_name ASC;";
            }
            $movieCounter++;
        }

        $smtp = $this->db->getConnection()->query($query);

        $rawData = $smtp->fetchAll();

        $charactersFromSuite = [];
        foreach($rawData as $data){
            $newCharacter = $this->objectBuilder($data, $this->table);
            $charactersFromSuite[] = $newCharacter;
        }
        return $charactersFromSuite;
    }

    public function findByMovie(MovieEntity $movie)
    {
        $smtp = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE char_movie={$movie->getId()};");

        $rawData = $smtp->fetchAll();

        $charactersFromMovie = [];
        foreach($rawData as $data){
            $newCharacter = $this->objectBuilder($data, $this->table);
            $charactersFromMovie[] = $newCharacter;
        }
        return $charactersFromMovie;
    }
}