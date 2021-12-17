<?php

namespace App\Models;

use PDO;
use Database\ServerConnection;

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
        if($this->orderBy !== null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} ORDER BY {$this->orderBy} ASC");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table}");
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        
        return $stmt->fetchAll();
    }

    /**
     * Get all the data from one entry in a table
     */
    public function findOneBy(array $column, array $orderBy = null){
        if($orderBy !== null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE ". key($column) ." = '". reset($column) ."' ORDER BY ". key($orderBy) ." ". reset($orderBy) ." LIMIT 1");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE ". key($column) ." = '". reset($column) ."' LIMIT 1");
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        
        return $stmt->fetchAll()[0];
    }

    /**
     * Get all the data from specified entries in a table
     */
    public function findBy(array $column, array $orderBy = null){
        if($orderBy !== null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE ". key($column) ." = '". reset($column) ."' ORDER BY ". key($orderBy) ." ". reset($orderBy) .";");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE ". key($column) ." = '". reset($column) ."';");
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        
        return $stmt->fetchAll();
    }

    public function findByMovie(string $movieId): array
    {
        if($this->orderBy !== null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE {$this->findByMovie}={$movieId} ORDER BY {$this->orderBy} ASC");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE {$this->findByMovie}={$movieId}");
        }
        return $stmt->fetchAll();
    }

    /* Voir fin de vidéo https://www.youtube.com/watch?v=BsHpNiDeB4w&list=PLeeuvNW2FHVgfbhZM3S8kqZOmnY7TEorW&index=12 + Créer méthode "query" (voir dans 2-3 vidéos précédentes comment faire)
    public function destroy(int $id): bool{
        return $this->query('DELETE FROM {$this->table} WHERE id = ?', $id)
    }*/
}