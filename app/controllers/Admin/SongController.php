<?php

namespace App\controllers\Admin;

use App\Models\Song;
use App\Entities\Song as SongEntity;
use App\Models\Movie;
use App\controllers\Controller;

class SongController extends Controller{

    public function index(){
        $songs = (new Song($this->getDB(), 'song_title'))->all();
        $movies = (new Movie($this->getDB(), 'movie_title'))->all();

        return $this->view('admin.song.index', compact('songs', 'movies'));
    }

    public function create(){
        $movies = (new Movie($this->getDB(), 'movie_title'))->all();

        return $this->view('admin.song.create', compact('movies'));
    }

    public function edit(int $id){
        /** @var SongEntity $song */
        $song = (new Song($this->getDB()))->findOneBy(['song_id' => $id]);
        $movies = (new Movie($this->getDB(), 'movie_title'))->all();

        return $this->view('admin.song.edit', compact('song', 'movies'));
    }
}