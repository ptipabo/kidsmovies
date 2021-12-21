<?php

namespace App\Models;

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

    /**
     * @inheritdoc
     */
    public function all(): array
    {
        $rawData = parent::all();
        
        $movies = [];
        foreach($rawData as $data){
            $movie = $this->movieBuilder($data);
            $movies[] = $movie;
        }
        return $movies;
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $column, array $orderBy = null){
        $rawData = parent::findOneBy($column, $orderBy);

        $movie = $this->movieBuilder($rawData);
        return $movie;
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $column, array $orderBy = null){
        $rawData = parent::findBy($column, $orderBy);

        $movies = [];
        foreach($rawData as $data){
            $movie = $this->movieBuilder($data);
            $movies[] = $movie;
        }
        return $movies;
    }

    public function findBySlug(string $movieUrl): Movie{
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM $this->table WHERE movie_url=?");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$movieUrl]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        //Ensuite on enclenche et on renvoit toutes les données trouvées
        return $stmt->fetch();
    }

    public function findById(string $movieId): Movie{
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM $this->table WHERE movie_id=?");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$movieId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        //Ensuite on enclenche et on renvoit toutes les données trouvées
        return $stmt->fetch();
    }

    public function findBySuite(int $suiteId): array{
        $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE movie_suite={$suiteId} ORDER BY movie_date ASC");

        return $stmt->fetchAll();
    }

    public function createMovie(\App\Entities\Movie $newMovie){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (movie_img, movie_title, movie_story, movie_suite, movie_date, movie_length, movie_url) VALUES ('".$newMovie->getImg()."', '".$newMovie->getTitle()."', '".$newMovie->getStory()."', ".$newMovie->getSuite().", ".$newMovie->getDate().", ".$newMovie->getLength().", '".$newMovie->getSlug()."')")){
            return true;
        }

        return false;
    }

    public function updateMovie(\App\Entities\Movie $newMovie){
        if($this->db->getConnection()->query("UPDATE {$this->table} SET movie_img = '".$newMovie->getImg()."', movie_title = '".$newMovie->getTitle()."', movie_story = '".$newMovie->getStory()."', movie_suite = ".$newMovie->getSuite().", movie_date = ".$newMovie->getDate().", movie_length = ".$newMovie->getLength().", movie_url = '".$newMovie->getSlug()."' WHERE movie_id = ".$newMovie->getId().";")){
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

    /**
     * Builds a Movie object
     */
    private function movieBuilder($data): MovieEntity
    {
        $movie = new MovieEntity();
        $movie->setId($data->movie_id);
        $movie->setTitle($data->movie_title);
        $movie->setLength($data->movie_length);
        $movie->setStory($data->movie_story);
        $movie->setDate($data->movie_date);
        $movie->setImg($data->movie_img);
        $movie->setSuite($data->movie_suite);
        $movie->setSlug($data->movie_url);

        return $movie;
    }
}