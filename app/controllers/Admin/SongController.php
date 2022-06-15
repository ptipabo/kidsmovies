<?php

namespace App\controllers\Admin;

use App\ORM\Song;
use App\Entities\Song as SongEntity;
use App\ORM\Movie;
use App\controllers\Controller;

class SongController extends Controller{

    public function index(){
        $songs = (new Song($this->getDB(), ['song_title' => 'ASC']))->all();
        $movies = (new Movie($this->getDB(), ['movie_title' => 'ASC']))->all();

        return $this->view('admin.song.index', compact('songs', 'movies'));
    }

    public function create(){
        $movies = (new Movie($this->getDB(), ['movie_title' => 'ASC']))->all();

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])){
            $newSong = $this->fetchData($_POST);

            if((new Song($this->getDB()))->createSong($newSong)){
                header('Location: /admin/songs');
            }
        }

        return $this->view('admin.song.create', compact('movies'));
    }

    public function edit(int $id){
        $songsTable = new Song($this->getDB());
        /** @var SongEntity $song */
        $song = $songsTable->findOneBy(['song_id' => $id]);
        $movieSongs = $songsTable->findBy(['song_movie' => $song->getMovie()], ['song_order' => 'ASC']);
        $movies = (new Movie($this->getDB(), ['movie_title' => 'ASC']))->all();

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])){
           $newSong = $this->fetchData($_POST, $id);

            if((new Song($this->getDB()))->updateSong($newSong)){
                header('Location: /admin/songs');
            }
        }

        return $this->view('admin.song.edit', compact('song', 'movieSongs', 'movies'));
    }

    public function destroy(int $id){
        $song = new Song($this->getDB());
        $result = $song->destroy($id);

        if($result){
            return header('Location: /admin/songs');
        }
    }

    /**
     * Store all the data from a form to a Song object
     */
    private function fetchData($request, int $id = null): SongEntity
    {
        $newSong = new SongEntity();
        if(isset($request['songMovie']) && !empty($request['songMovie'])){
            $newSong->setMovie($request['songMovie']);
        }

        if(isset($request['songTitle']) && !empty($request['songTitle']) 
            && isset($request['songVideo']) && !empty($request['songVideo'])
            && isset($request['songOrder'])){
            if($id){
                $newSong->setId($id);
            }
            $newSong->setTitle(addslashes($request['songTitle']));
            $newSong->setVideo(addslashes($request['songVideo']));
            $newSong->setCensored(isset($request['songCensored']) ? true : false);
            $newSong->setOrder(addslashes($request['songOrder']));
        }

        return $newSong;
    }
}