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