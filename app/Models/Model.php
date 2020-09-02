<?php

namespace App\Models;

use Database\ServerConnection;

abstract class Model{

    protected $db;
    protected $table;
    protected $orderBy = null;
    protected $findByMovie = null;

    public function __construct(ServerConnection $db, string $orderBy = null){
        //On stock la connection à la base de données
        $this->db = $db;
        
        //Si on le souhaite, on peut trier les résultats selon les besoins
        if($orderBy !== null){
            $this->orderBy = $orderBy;
        }
    }

    public function all(): array{
        if($this->orderBy !== null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} ORDER BY {$this->orderBy} ASC");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table}");
        }

        return $stmt->fetchAll();
    }

    public function findByMovie(string $movieId): array{
        if($this->orderBy !== null){
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE {$this->findByMovie}={$movieId} ORDER BY {$this->orderBy} ASC");
        }
        else{
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} WHERE {$this->findByMovie}={$movieId}");
        }
        return $stmt->fetchAll();
    }
}