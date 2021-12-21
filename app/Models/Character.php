<?php

namespace App\Models;

use \App\Entities\Character as CharacterEntity;

class Character extends Model{
    
    protected $table = 'characters';
    protected $findByMovie = 'char_movie';

    /**
     * @inheritdoc
     */
    public function all(): array
    {
        $rawData = parent::all();
        
        $characters = [];
        foreach($rawData as $data){
            $character = $this->characterBuilder($data);
            $characters[] = $character;
        }
        return $characters;
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $column, array $orderBy = null){
        $rawData = parent::findOneBy($column, $orderBy);

        $character = $this->characterBuilder($rawData);
        return $character;
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $column, array $orderBy = null){
        $rawData = parent::findBy($column, $orderBy);

        $characters = [];
        foreach($rawData as $data){
            $character = $this->characterBuilder($data);
            $characters[] = $character;
        }
        return $characters;
    }

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

    /**
     * Builds a Song object
     */
    private function characterBuilder($data): CharacterEntity
    {
        $character = new CharacterEntity;
        $character->setId($data->char_id);
        $character->setMovie($data->char_movie);
        $character->setName($data->char_name);
        $character->setImg($data->char_img);
        $character->setDesc($data->char_desc);

        return $character;
    }
}