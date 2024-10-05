<?php

namespace App\ORM;

use App\Entities\Type as TypeEntity;
use PDO;

class Type extends Model{
    
    protected $table = 'types';

    public function createType(\App\Entities\Type $newType){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (type_name) VALUES ('".$newType->getName()."')")){
            return true;
        }

        return false;
    }
}