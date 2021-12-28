<?php

namespace App\ORM;

use App\Entities\Game as GameEntity;

class Game extends Model{
    
    protected $table = 'games';

    public function createGame(\App\Entities\Game $newGame){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (game_title, game_img, game_desc) VALUES ('".$newGame->getTitle()."', '".$newGame->getImg()."', '".$newGame->getDesc()."')")){
            return true;
        }

        return false;
    }

    public function updateGame(\App\Entities\Game $newGame){
        if($this->db->getConnection()->query("UPDATE {$this->table} SET game_title = '".$newGame->getTitle()."', game_img = ".$newGame->getImg().", game_desc = '".$newGame->getDesc()."' WHERE game_id = ".$newGame->getId().";")){
            return true;
        }
        return false;
    }

    public function destroy($gameId){
        if($this->db->getConnection()->query("DELETE FROM {$this->table} WHERE game_id={$gameId}")){
            return true;
        }

        return false;
    }
}