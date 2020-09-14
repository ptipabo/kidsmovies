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
                "movieStory":"'.$movies[$i]->movie_story.'",
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

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = '[{
            "movieId":'.$movie->movie_id.',
            "movieImg":"'.str_replace('"', '\"', $movie->movie_img).'",
            "movieTitle":"'.str_replace('"', '\"', $movie->movie_title).'",
            "movieStory":"'.str_replace('"', '\"', $movie->movie_story).'",
            "movieSuite":"'.str_replace('"', '\"', $movie->movie_suite).'",
            "movieDate":"'.$movie->movie_date.'",
            "movieLength":"'.$movie->movie_length.'"
        }]';
        $movieDetails = $jsonConstruct;

        //On récupère la liste des films liés à celui-ci (s'il y en a)
        $suite = $movies->findBySuite($movie->movie_suite);

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = '[';
        for($i=0;$i < count($suite);$i++){

            $jsonConstruct .= '{
                "movieId":'.$suite[$i]->movie_id.',
                "movieTitle":"'.str_replace('"', '\"', $suite[$i]->movie_title).'",
                "movieStory":"'.str_replace('"', '\"', $suite[$i]->movie_story).'",
                "movieDate":"'.$suite[$i]->movie_date.'",
                "movieLength":"'.$suite[$i]->movie_length.'",
                "movieUrl":"'.$suite[$i]->movie_url.'"
            }';

            if($i+1 === count($suite)){
                $jsonConstruct .= ']';
            }
            else{
                $jsonConstruct .= ',';
            }
        }
        $suite = $jsonConstruct;

        //On récupère la liste de toutes les musiques liées à ce film
        $songs = new Song($this->getDB(), 'song_title');
        $songs = $songs->findByMovie($movie->movie_id);

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = '[';
        if(count($songs) !== 0){
            for($i=0;$i < count($songs);$i++){
                
                $videoId = explode('/', $songs[$i]->song_video);

                $jsonConstruct .= '{
                    "songId":'.$songs[$i]->song_id.',
                    "songMovie":"'.str_replace('"', '\"', $movie->movie_title).'",
                    "songTitle":"'.str_replace('"', '\"', $songs[$i]->song_title).'",
                    "songVideo":"'.$songs[$i]->song_video.'",
                    "videoId":"'.$videoId[4].'"
                }';

                if($i+1 === count($songs)){
                    $jsonConstruct .= ']';
                }
                else{
                    $jsonConstruct .= ',';
                }
            }
        }else{
            $jsonConstruct .= ']';
        }

        $songs = $jsonConstruct;

        //On récupère la liste de tous les personnages liés à ce film
        $characters = new Character($this->getDB(), 'char_name');
        $characters = $characters->findByMovie($movie->movie_id);

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = '[';
        if(count($characters) !== 0){
            for($i=0;$i < count($characters);$i++){

                $jsonConstruct .= '{
                    "charId":'.$characters[$i]->char_id.',
                    "charMovie":"'.str_replace('"', '\"', $movie->movie_title).'",
                    "charName":"'.str_replace('"', '\"', $characters[$i]->char_name).'",
                    "charImg":"'.$characters[$i]->char_img.'",
                    "charDesc":"'.str_replace('"', '\"', $characters[$i]->char_desc).'",
                    "movieUrl":"'.$movieUrl.'"
                }';

                if($i+1 === count($characters)){
                    $jsonConstruct .= ']';
                }
                else{
                    $jsonConstruct .= ',';
                }
            }
        }else{
            $jsonConstruct .= ']';
        }

        $characters = $jsonConstruct;

        $this->view('content.movie', compact('movieDetails', 'suite', 'songs', 'characters'));
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
            
            $videoId = explode('/', $songs[$i]->song_video);

            $jsonConstruct .= '{
                "songId":'.$songs[$i]->song_id.',
                "songMovie":"'.str_replace('"', '\"', $songMovie).'",
                "songTitle":"'.str_replace('"', '\"', $songs[$i]->song_title).'",
                "songVideo":"'.$songs[$i]->song_video.'",
                "videoId":"'.$videoId[4].'"
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

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = '[';
        for($i=0;$i < count($characters);$i++){
            
            foreach($movies as $movie){
                if($movie->movie_id === $characters[$i]->char_movie){
                    $charMovie = $movie->movie_title;
                    $movieUrl = $movie->movie_url;
                }
            }

            $jsonConstruct .= '{
                "charId":'.$characters[$i]->char_id.',
                "charMovie":"'.str_replace('"', '\"',$charMovie).'",
                "charName":"'.str_replace('"', '\"', $characters[$i]->char_name).'",
                "charImg":"'.$characters[$i]->char_img.'",
                "charDesc":"'.str_replace('"', '\"', $characters[$i]->char_desc).'",
                "movieUrl":"'.$movieUrl.'"
            }';

            if($i+1 === count($characters)){
                $jsonConstruct .= ']';
            }
            else{
                $jsonConstruct .= ',';
            }
        }
        $characters = $jsonConstruct;

        $this->view('content.characters', compact('characters'));
    }
}