<?php

namespace App\Models;

use App\Entities\User as UserEntity;

class User extends Model{
    
    protected $table = 'users';

    /**
     * @inheritdoc
     */
    public function all(): array
    {
        $rawData = parent::all();
        
        $users = [];
        foreach($rawData as $data){
            $user = $this->userBuilder($data);
            $users[] = $user;
        }
        return $users;
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $column, array $orderBy = null){
        $rawData = parent::findOneBy($column, $orderBy);

        $user = $this->userBuilder($rawData);
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $column, array $orderBy = null){
        $rawData = parent::findBy($column, $orderBy);

        $users = [];
        foreach($rawData as $data){
            $user = $this->userBuilder($data);
            $users[] = $user;
        }
        return $users;
    }

    /**
     * Builds a Song object
     */
    private function userBuilder($data): UserEntity
    {
        $user = new UserEntity;
        $user->setId($data->user_id);
        $user->setName($data->user_name);
        $user->setColor($data->user_color);

        return $user;
    }
}