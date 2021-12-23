<?php

namespace App\ORM;

use \App\Entities\Character as CharacterEntity;

class Character extends Model{
    
    protected $table = 'characters';
    protected $findByMovie = 'char_movie';

    public function createCharacter(\App\Entities\Character $newCharacter){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (char_name, char_movie, char_img, char_desc) VALUES ('".$newCharacter->getName()."', '".$newCharacter->getMovie()."', '".$newCharacter->getImg()."', '".$newCharacter->getDesc()."')")){
            return true;
        }

        return false;
    }

    public function updateCharacter(\App\Entities\Character $newCharacter){
        if($this->db->getConnection()->query("UPDATE {$this->table} SET char_name = '".$newCharacter->getName()."', char_movie = ".$newCharacter->getMovie().", char_img = '".$newCharacter->getImg()."', char_desc = '".$newCharacter->getDesc()."' WHERE char_id = ".$newCharacter->getId().";")){
            return true;
        }
        return false;
    }
}