<?php

namespace App\Models;

class Character extends Model{
    
    protected $table = 'characters';
    protected $findByMovie = 'char_movie';

}