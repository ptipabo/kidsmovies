<?php

namespace App\Controllers;

use App\Models\Song;
use App\Models\Movie;
use App\Models\Character;

class ViewController extends Controller{

    //Permet d'afficher la page Home de l'application
    public function home(){

        $movie = new Movie($this->getDB(), 'movie_title');
        $movies = $movie->all();

        $this->view('content.home', compact('movies'));
    }

    //Permet d'afficher la page Movie de l'application en lui passant l'id du film à afficher
    public function movie(string $movieUrl){

        $movie = new Movie($this->getDB());
        $movie = $movie->findByUrl($movieUrl);

        $movieId = $movie->movie_id;

        $characters = new Character($this->getDB(), 'char_name');
        $characters = $characters->findByMovie($movieId);

        $songs = new Song($this->getDB(), 'song_title');
        $songs = $songs->findByMovie($movieId);

        $this->view('content.movie', compact('movie', 'characters', 'songs'));
    }
}