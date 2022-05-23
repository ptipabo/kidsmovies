<?php

namespace App\ORM;

use PDO;
use App\Entities\MemoryScore as MemoryScoreEntity;

class MemoryScore extends Model{
    
    protected $table = 'memory_score';

    public function getPlayerScores(int $userId): int{
        //prepare() permet simplement d'éviter les injections sql
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM $this->table WHERE user_id=?");
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmt->execute([$userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        //Ensuite on enclenche et on renvoit toutes les données trouvées
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addScore(MemoryScoreEntity $newScore): bool{
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (user_id, memory_score_date, memory_score_score, memory_score_numberofturns, memory_score_difficultymode, memory_score_numberofplayers) VALUES (".$newScore->getUser().", '".$newScore->getDate()->format('Y-m-d H:i:s')."', ".$newScore->getScore().", ".$newScore->getNumberOfTurns().", ".$newScore->getDifficultyMode().", ".$newScore->getNumberOfPlayers().")")){
            return true;
        }
        return false;
    }

    public function destroy(int $scoreId){
        if($this->db->getConnection()->query("DELETE FROM {$this->table} WHERE memory_score_id={$scoreId}")){
            return true;
        }

        return false;
    }
}