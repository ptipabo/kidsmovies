<?php

namespace App\Models;

class Song extends Model{
    
    protected $table = 'songs';
    protected $findByMovie = 'song_movie';

}