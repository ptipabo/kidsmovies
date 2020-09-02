<?php

namespace App\Models;

use stdClass;

class Movie extends Model{
    protected $table = 'movies';

    public function findByUrl(string $movieUrl): stdClass{
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM $this->table WHERE movie_url=?");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$movieUrl]);
        //Ensuite on enclenche et on récupère toutes les données dans l'objet $movie
        return $stmt->fetch();
    }

    public function findById(string $movieId): stdClass{
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM $this->table WHERE movie_id=?");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$movieId]);
        //Ensuite on enclenche et on récupère toutes les données dans l'objet $movie
        return $stmt->fetch();
    }
}