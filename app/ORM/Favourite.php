<?php

namespace App\ORM;

use PDO;
use App\Entities\Favourite as FavouriteEntity;

class Favourite extends Model{
    
    protected $table = 'favourites';

    public function checkFavourite(int $songId, int $userId): int{
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM $this->table WHERE song_id=? AND user_id=?");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$songId, $userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        //Ensuite on enclenche et on renvoit toutes les données trouvées
        return count($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function addFavourite(int $songId, int $userId): bool{
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("INSERT INTO $this->table (song_id, user_id) VALUES (?, ?)");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$songId, $userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        //Ensuite on enclenche et on renvoit toutes les données trouvées
        return true;
    }

    public function removeFavourite(int $songId, int $userId): bool{
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("DELETE FROM $this->table WHERE song_id=? AND user_id=?");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$songId, $userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        //Ensuite on enclenche et on renvoit toutes les données trouvées
        return true;
    }
}