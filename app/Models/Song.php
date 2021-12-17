<?php

namespace App\Models;

use App\Entities\Song as SongEntity;

class Song extends Model{
    
    protected $table = 'songs';
    protected $findByMovie = 'song_movie';

    /**
     * @inheritdoc
     */
    public function all(): array
    {
        $rawData = parent::all();
        
        $songs = [];
        foreach($rawData as $data){
            $song = $this->songBuilder($data);
            $songs[] = $song;
        }
        return $songs;
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $column, array $orderBy = null){
        $rawData = parent::findOneBy($column, $orderBy);

        $song = $this->songBuilder($rawData);
        return $song;
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $column, array $orderBy = null){
        $rawData = parent::findBy($column, $orderBy);

        $songs = [];
        foreach($rawData as $data){
            $song = $this->songBuilder($data);
            $songs[] = $song;
        }
        return $songs;
    }

    /**
     * Builds a Song object
     */
    private function songBuilder($data): SongEntity
    {
        $song = new SongEntity;
        $song->setId($data->song_id);
        $song->setMovie($data->song_movie);
        $song->setTitle($data->song_title);
        $song->setVideo($data->song_video);
        $song->setCensored($data->song_censored);
        $song->setOrder($data->song_order);

        return $song;
    }
}