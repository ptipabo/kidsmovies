<?php

namespace App\ORM;

use App\Entities\Song as SongEntity;

class Song extends Model{
    
    protected $table = 'songs';
    protected $findByMovie = 'song_movie';

    public function createSong(\App\Entities\Song $newSong){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (song_title, song_movie, song_video, song_censored, song_order) VALUES ('".$newSong->getTitle()."', '".$newSong->getMovie()."', '".$newSong->getVideo()."', ".($newSong->isCensored() ? 1 : 0).", ".$newSong->getOrder().")")){
            return true;
        }

        return false;
    }

    public function updateSong(\App\Entities\Song $newSong){
        if($this->db->getConnection()->query("UPDATE {$this->table} SET song_title = '".$newSong->getTitle()."', song_movie = ".$newSong->getMovie().", song_video = '".$newSong->getVideo()."', song_censored = ".($newSong->isCensored() ? 1 : 0).", song_order = '".$newSong->getOrder()."' WHERE song_id = ".$newSong->getId().";")){
            return true;
        }
        return false;
    }

    public function destroy($songId){
        if($this->db->getConnection()->query("DELETE FROM {$this->table} WHERE song_id={$songId}")){
            return true;
        }

        return false;
    }
}