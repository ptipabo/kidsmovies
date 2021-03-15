<?php

namespace App\controllers;

use App\Models\Song;
use App\Models\Movie;
use App\Models\Character;

class ViewController extends Controller{

    /**
     * Display the homepage of the application
     */
    public function home(){
        //On récupère la liste de tous les films triés par titre
        $movies = new Movie($this->getDB(), 'movie_title');
        $movies = $movies->all();
        
        //On crée un array d'après le résultat de la requête qui sera ensuite converti en JSON pour passer les données au JS
        $jsonConstruct = array();
        for($i=0;$i < count($movies);$i++){
            $jsonConstruct[] = array(
                "movieId" => $movies[$i]->movie_id,
                "movieImg" => $movies[$i]->movie_img,
                "movieTitle" => str_replace('"', '\"', $movies[$i]->movie_title),
                "movieStory" => str_replace('"', '\"', $movies[$i]->movie_story),
                "movieSuite" => $movies[$i]->movie_suite,
                "movieDate" => $movies[$i]->movie_date,
                "movieLength" => $movies[$i]->movie_length,
                "movieUrl" => $movies[$i]->movie_url
            );
        }
        $movies = json_encode($jsonConstruct);

        $this->view('content.home', compact('movies'));
    }

    /**
     * Display the movie page of the application and pass the slug of the movie to display to it
     */
    public function movie(string $movieSlug){
        //On se connecte à la table des films via un objet de type film (auquel on indique qu'on voudra récupèrer les films triés d'après leurs titres)
        $movieTable = new Movie($this->getDB(), 'movie_title');
        //On récupère les infos concernant le film indiqué dans l'url
        $movie = $movieTable->findBySlug($movieSlug);

        //On stock toutes les infos concernant ce film dans un tableau
        $movieDetails = array(
            "id" => $movie->movie_id,
            "img" => str_replace('"', '\"', $movie->movie_img),
            "title" => str_replace('"', '\"', $movie->movie_title),
            "story" => str_replace('"', '\"', $movie->movie_story),
            "suiteId" => $movie->movie_suite,
            "date" => $movie->movie_date,
            "length" => $movie->movie_length,
            "slug" => $movie->movie_url
        );
        //$movieDetails = json_encode($jsonConstruct);

        //On récupère la liste des films liés à celui-ci (s'il y en a)
        $suiteMovies = $movieTable->findBySuite($movie->movie_suite);

        //On stock tous les films faisant partie de la même série que ce film dans un tableau
        $movieSuiteList = array();
        for($i=0;$i < count($suiteMovies);$i++){
            $movieSuiteList[] = array(
                "id" => $suiteMovies[$i]->movie_id,
                "title" => str_replace('"', '\"', $suiteMovies[$i]->movie_title),
                "story" => str_replace('"', '\"', $suiteMovies[$i]->movie_story),
                "date" => $suiteMovies[$i]->movie_date,
                "length" => $suiteMovies[$i]->movie_length,
                "slug" => $suiteMovies[$i]->movie_url
            );
        }
        //$suiteList = json_encode($jsonConstruct);

        //On récupère la liste de toutes les musiques liées à ce film
        $songs = new Song($this->getDB(), 'song_title');
        $songs = $songs->findByMovie($movie->movie_id);

        //On stock la liste des musiques liées à ce film dans un tableau
        $movieSongs = array();
        for($i=0;$i < count($songs);$i++){
            $videoId = explode('/', $songs[$i]->song_video);

            $movieSongs[] = array(
                "id" => $songs[$i]->song_id,
                "movie" => str_replace('"', '\"', $movie->movie_title),
                "title" => str_replace('"', '\"', $songs[$i]->song_title),
                "link" => $songs[$i]->song_video,
                "youtubeId" => $videoId[4]
            ) ;
        }
        //$songs = json_encode($jsonConstruct);

        //On récupère la liste de tous les personnages liés à ce film
        $characters = new Character($this->getDB(), 'char_name');
        $characters = $characters->findByMovie($movie->movie_id);

        //On stock la liste des personnages liés à ce film dans un tableau
        $movieCharacters = array();
        for($i=0;$i < count($characters);$i++){
            $movieCharacters[] = array(
                "id" => $characters[$i]->char_id,
                "movie" => str_replace('"', '\"', $movie->movie_title),
                "name" => str_replace('"', '\"', $characters[$i]->char_name),
                "img" => $characters[$i]->char_img,
                "desc" => str_replace('"', '\"', $characters[$i]->char_desc),
                "slug" => $movieSlug
            );
        }
        //$characters = json_encode($jsonConstruct);

        $this->view('content.movie', compact('movieDetails', 'movieSuiteList', 'movieSongs', 'movieCharacters'));
    }

    /**
     * Display the music page of the application
     */
    public function music(){
        //On récupère la liste de toutes les musiques
        $songs = new Song($this->getDB(), 'song_movie');
        $songs = $songs->all();

        //On récupère le titre du film correspondant à chaque musique
        $movies = new Movie($this->getDB());
        $movies = $movies->all();

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = array();
        for($i=0;$i < count($songs);$i++){
            
            foreach($movies as $movie){
                if($movie->movie_id === $songs[$i]->song_movie){
                    $songMovie = $movie->movie_title;
                }
            }
            
            $videoId = explode('/', $songs[$i]->song_video);

            $jsonConstruct[] = array(
                "id" => $songs[$i]->song_id,
                "movie" => str_replace('"', '\"', $songMovie),
                "title" => str_replace('"', '\"', $songs[$i]->song_title),
                "link" => $songs[$i]->song_video,
                "youtubeId" => $videoId[4]
            );
        }
        $songs = $jsonConstruct;

        $this->view('content.music', compact('songs'));
    }

    /**
     * Display the character page of the application
     */
    public function characters(){
        //On récupère la liste de tous les personnages
        $characters = new Character($this->getDB(), 'char_movie');
        $characters = $characters->all();

        //On récupère le titre du film correspondant à chaque musique
        $movies = new Movie($this->getDB());
        $movies = $movies->all();

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = array();
        for($i=0;$i < count($characters);$i++){
            
            foreach($movies as $movie){
                if($movie->movie_id === $characters[$i]->char_movie){
                    $charMovie = $movie->movie_title;
                    $movieSlug = $movie->movie_url;
                }
            }

            $jsonConstruct[] = array(
                "id" => $characters[$i]->char_id,
                "movie" => str_replace('"', '\"',$charMovie),
                "name" => str_replace('"', '\"', $characters[$i]->char_name),
                "img" => $characters[$i]->char_img,
                "desc" => str_replace('"', '\"', $characters[$i]->char_desc),
                "slug" => $movieSlug
            );
        }
        $characters = $jsonConstruct;

        $this->view('content.characters', compact('characters'));
    }

    /**
     * Display the games page of the application
     */
    public function games(){
        //On récupère la liste de toutes les musiques
        $songs = new Song($this->getDB(), 'song_movie');
        $songs = $songs->all();

        //On récupère le titre du film correspondant à chaque musique
        $movies = new Movie($this->getDB());
        $movies = $movies->all();

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = array();
        for($i=0;$i < count($songs);$i++){
            
            foreach($movies as $movie){
                if($movie->movie_id === $songs[$i]->song_movie){
                    $songMovie = $movie->movie_title;
                }
            }
            
            $videoId = explode('/', $songs[$i]->song_video);

            $jsonConstruct[] = array(
                "id" => $songs[$i]->song_id,
                "movie" => str_replace('"', '\"', $songMovie),
                "title" => str_replace('"', '\"', $songs[$i]->song_title),
                "link" => $songs[$i]->song_video,
                "youtubeId" => $videoId[4]
            );
        }
        $songs = $jsonConstruct;

        $this->view('content.games', compact('songs'));
    }
}