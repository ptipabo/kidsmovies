<?php

namespace App\ORM;

use PDO;
use Database\ServerConnection;
use App\Entities\Movie as MovieEntity;
use App\Entities\Character as CharacterEntity;
use App\Entities\Song as SongEntity;
use App\Entities\Favourite as FavouriteEntity;
use App\Entities\MovieSuite as MovieSuiteEntity;
use App\Entities\User as UserEntity;
use App\Entities\Game as GameEntity;
use App\Entities\MemoryScore as MemoryScoreEntity;

abstract class Model{

    protected $db;
    protected $table;
    protected $orderBy = null;
    protected $findByMovie = null;

    public function __construct(ServerConnection $db = null, string $orderBy = null){
        //On stock la connection à la base de données
        $this->db = $db;
        
        //Si on le souhaite, on peut trier les résultats selon les besoins
        if($orderBy !== null){
            $this->orderBy = $orderBy;
        }
    }

    /**
     * Get all the data from a database table
     */
    public function all(): array
    {
        if($this->orderBy != null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} ORDER BY {$this->orderBy} ASC");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table}");
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        
        $rawData = $stmt->fetchAll();

        $newObjects = [];
        foreach($rawData as $data){
            $newObject = $this->objectBuilder($data, $this->table);
            $newObjects[] = $newObject;
        }
        return $newObjects;
    }

    /**
     * Get all the data from one entry in a table
     */
    public function findOneBy(array $column, array $orderBy = null){
        if($orderBy != null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE ". key($column) ." = '". reset($column) ."' ORDER BY ". key($orderBy) ." ". reset($orderBy) ." LIMIT 1");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE ". key($column) ." = '". reset($column) ."' LIMIT 1");
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        
        $rawData = $stmt->fetchAll()[0];

        $newObject = $this->objectBuilder($rawData, $this->table);
        return $newObject;
    }

    /**
     * Get all the data from specified entries in a table
     */
    public function findBy(array $column, array $orderBy = null){
        if($orderBy != null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE ". key($column) ." = '". reset($column) ."' ORDER BY ". key($orderBy) ." ". reset($orderBy) .";");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE ". key($column) ." = '". reset($column) ."';");
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        
        $rawData = $stmt->fetchAll();

        $newObjects = [];
        foreach($rawData as $data){
            $newObject = $this->objectBuilder($data, $this->table);
            $newObjects[] = $newObject;
        }
        return $newObjects;
    }

    /**
     * Builds an object with a given type
     */
    protected function objectBuilder($data, $objectType)
    {
        switch($objectType){
            case 'movies':
                $object = new MovieEntity();
                $object->setId($data->movie_id);
                $object->setTitle($data->movie_title);
                $object->setLength($data->movie_length);
                $object->setStory($data->movie_story);
                $object->setDate($data->movie_date);
                $object->setImg($data->movie_img);
                $object->setSuite($data->movie_suite);
                $object->setSlug($data->movie_url);
                break;
            case 'characters':
                $object = new CharacterEntity;
                $object->setId($data->char_id);
                $object->setSuite($data->char_suite);
                $object->setName($data->char_name);
                $object->setImg($data->char_img);
                $object->setDesc($data->char_desc);
                break;
            case 'songs':
                $object = new SongEntity;
                $object->setId($data->song_id);
                $object->setMovie($data->song_movie);
                $object->setTitle($data->song_title);
                $object->setVideo($data->song_video);
                $object->setCensored($data->song_censored);
                $object->setOrder($data->song_order);
                break;
            case 'favourites':
                $object = new FavouriteEntity;
                $object->setId($data->favourite_id);
                $object->setSong($data->song_id);
                $object->setUser($data->user_id);
                break;
            case 'moviesuite':
                $object = new MovieSuiteEntity();
                $object->setId($data->suite_id);
                $object->setTitle($data->suite_title);
                break;
            case 'users':
                $object = new UserEntity;
                $object->setId($data->user_id);
                $object->setName($data->user_name);
                $object->setColor($data->user_color);
                break;
            case 'games':
                $object = new GameEntity;
                $object->setId($data->game_id);
                $object->setTitle($data->game_title);
                $object->setImg($data->game_img);
                $object->setDesc($data->game_desc);
                break;
            case 'memory_score':
                $object = new MemoryScoreEntity;
                $object->setId($data->memory_score_id);
                $object->setUser($data->memory_score_user);
                $object->setDate($data->memory_score_date);
                $object->setScore($data->memory_score_score);
                $object->setNumberOfTurns($data->memory_score_numberofturns);
                $object->setDifficultyMode($data->memory_score_difficultymode);
                $object->setNumberOfTurns($data->memory_score_numberofplayers);
                break;
            default:
                $object = null;
        }

        return $object;
    }

    /*public function findByMovie(string $movieId): array
    {
        if($this->orderBy != null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE {$this->findByMovie}={$movieId} ORDER BY {$this->orderBy} ASC");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE {$this->findByMovie}={$movieId}");
        }
        return $stmt->fetchAll();
    }*/

    /* Voir fin de vidéo https://www.youtube.com/watch?v=BsHpNiDeB4w&list=PLeeuvNW2FHVgfbhZM3S8kqZOmnY7TEorW&index=12 + Créer méthode "query" (voir dans 2-3 vidéos précédentes comment faire)
    public function destroy(int $id): bool{
        return $this->query('DELETE FROM {$this->table} WHERE id = ?', $id)
    }*/
}