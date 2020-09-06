<?php

namespace App\Controllers;

use App\Models\Song;
use App\Models\Movie;
use App\Models\Character;

class ViewController extends Controller{

    //Permet d'afficher la page Home de l'application
    public function home(){

        //On récupère la liste de tous les films triés par titre
        $movieByTitle = new Movie($this->getDB(), 'movie_title');
        $movieByTitle = $movieByTitle->all();

        //On récupère la liste de tous les films triés par date
        $movieByDate = new Movie($this->getDB(), 'movie_date');
        $movieByDate = $movieByDate->all();

        //On récupère la liste de tous les films triés par série de films
        $movieBySuite = new Movie($this->getDB(), 'movie_suite');
        $movieBySuite = $movieBySuite->all();

        //On récupère la liste de tous les films triés par série de films
        $movieByLength = new Movie($this->getDB(), 'movie_length');
        $movieByLength = $movieByLength->all();

        $this->view('content.home', compact('movieByTitle','movieByDate','movieBySuite','movieByLength'));
    }

    //Permet d'afficher la page Movie de l'application en lui passant le titre (préformaté dans la base de données) du film à afficher
    public function movie(string $movieUrl){

        //On crée un objet qui se connectera à la table movies
        $movies = new Movie($this->getDB());
        //On récupère les infos concernant ce film via son "titre-url"
        $movie = $movies->findByUrl($movieUrl);
        //On récupère la liste des films liés à celui-ci (s'il y en a)
        $suite = $movies->findBySuite($movie->movie_suite);

        //On récupère la liste de tous les personnages liés à ce film
        $characters = new Character($this->getDB(), 'char_name');
        $characters = $characters->findByMovie($movie->movie_id);

        //On récupère la liste de toutes les musiques liées à ce film
        $songs = new Song($this->getDB(), 'song_title');
        $songs = $songs->findByMovie($movie->movie_id);

        $this->view('content.movie', compact('movie', 'suite', 'songs', 'characters'));
    }

    //Permet d'afficher la page Music de l'application
    public function music(){
        //On récupère la liste de toutes les musiques
        $songs = new Song($this->getDB(), 'song_movie');
        $songs = $songs->all();

        //On récupère le titre du film correspondant à chaque musique
        $movies = new Movie($this->getDB());
        $movies = $movies->all();

        $this->view('content.music', compact('songs', 'movies'));
    }

    //Permet d'afficher la page Music de l'application
    public function characters(){
        //On récupère la liste de tous les personnages
        $characters = new Character($this->getDB(), 'char_movie');
        $characters = $characters->all();

        //On récupère le titre du film correspondant à chaque musique
        $movies = new Movie($this->getDB());
        $movies = $movies->all();

        $this->view('content.characters', compact('characters', 'movies'));
    }
}