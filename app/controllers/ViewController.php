<?php

namespace App\Controllers;

use App\Models\Song;
use App\Models\Movie;
use App\Models\Character;

class ViewController extends Controller{

    //Permet d'afficher la page Home de l'application
    public function home(){

        //On récupère la liste de tous les films triés par titre
        $movies = new Movie($this->getDB(), 'movie_title');
        $movies = $movies->all();
        
        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = '[';
        for($i=0;$i < count($movies);$i++){
            $jsonConstruct .= '{
                "movieId":'.$movies[$i]->movie_id.',
                "movieImg":"'.$movies[$i]->movie_img.'",
                "movieTitle":"'.$movies[$i]->movie_title.'",
                "movieSuite":'.$movies[$i]->movie_suite.',
                "movieDate":'.$movies[$i]->movie_date.',
                "movieLength":'.$movies[$i]->movie_length.',
                "movieURL":"'.$movies[$i]->movie_url.'"
            }';

            if($i+1 === count($movies)){
                $jsonConstruct .= ']';
            }
            else{
                $jsonConstruct .= ',';
            }
        }
        $movies = $jsonConstruct;
        $this->view('content.home', compact('movies'));
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

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = '[';
        for($i=0;$i < count($songs);$i++){
            
            foreach($movies as $movie){
                if($movie->movie_id === $songs[$i]->song_movie){
                    $songMovie = $movie->movie_title;
                }
            }
            
            $jsonConstruct .= '{
                "songId":'.$songs[$i]->song_id.',
                "songMovie":"'.$songMovie.'",
                "movieTitle":"'.$songs[$i]->song_title.'",
                "movieVideo":'.$songs[$i]->song_video.'
            }';

            if($i+1 === count($songs)){
                $jsonConstruct .= ']';
            }
            else{
                $jsonConstruct .= ',';
            }
        }
        $songs = $jsonConstruct;

        $this->view('content.music', compact('songs'));
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