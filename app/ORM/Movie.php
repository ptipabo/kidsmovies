<?php

namespace App\ORM;

use PDO;
use App\Entities\Movie as MovieEntity;

class Movie extends Model{
    protected $table = 'movies';
    // These variables are there to provide prettier names in the final view code
    public $id = array();
    public $title = array();
    public $duration = array();
    public $story = array();
    public $year = array();
    public $img = array();
    public $sequel = array();
    public $slug = array();
    public $type = array();

    public function createMovie(\App\Entities\Movie $newMovie){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (movie_img, movie_title, movie_story, movie_suite, movie_date, movie_length, movie_url) VALUES ('".$newMovie->getImg()."', '".$newMovie->getTitle()."', '".$newMovie->getStory()."', ".$newMovie->getSuite().", ".$newMovie->getDate().", ".$newMovie->getLength().", '".$newMovie->getSlug()."', '".$newMovie->getType()."')")){
            return true;
        }

        return false;
    }

    public function updateMovie(\App\Entities\Movie $newMovie){
        if($this->db->getConnection()->query("UPDATE {$this->table} SET movie_img = '".$newMovie->getImg()."', movie_title = '".$newMovie->getTitle()."', movie_story = '".$newMovie->getStory()."', movie_suite = ".$newMovie->getSuite().", movie_date = ".$newMovie->getDate().", movie_length = ".$newMovie->getLength().", movie_url = '".$newMovie->getSlug()."', movie_type = ".$newMovie->getType()." WHERE movie_id = ".$newMovie->getId().";")){
            return true;
        }
        return false;
    }

    public function destroy($movieId){
        if($this->db->getConnection()->query("DELETE FROM {$this->table} WHERE movie_id={$movieId}")){
            return true;
        }

        return false;
    }
}