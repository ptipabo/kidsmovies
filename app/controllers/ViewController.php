<?php

namespace App\controllers;

use App\ORM\Song;
use App\Entities\Song as SongEntity;
use App\ORM\Movie;
use App\Entities\Movie as MovieEntity;
use App\ORM\Character;
use App\Entities\Character as CharacterEntity;
use App\ORM\Favourite;
use App\Entities\Favourite as FavouriteEntity;
use App\ORM\User;
use App\Entities\User as UserEntity;

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
        /** @var MovieEntity $movie */
        foreach($movies as $movie){
            $jsonConstruct[] = array(
                "movieId" => $movie->getId(),
                "movieImg" => $movie->getImg(),
                "movieTitle" => str_replace('"', '\"', $movie->getTitle()),
                "movieStory" => str_replace('"', '\"', $movie->getStory()),
                "movieSuite" => $movie->getSuite(),
                "movieDate" => $movie->getDate(),
                "movieLength" => $movie->getLength(),
                "movieUrl" => $movie->getSlug()
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
        /** @var MovieEntity $movie */
        $movie = $movieTable->findOneBy(['movie_url' => $movieSlug]);

        //On stock toutes les infos concernant ce film dans un tableau
        $movieDetails = [
            "id" => $movie->getId(),
            "img" => str_replace('"', '\"', $movie->getImg()),
            "title" => str_replace('"', '\"', $movie->getTitle()),
            "story" => str_replace('"', '\"', $movie->getStory()),
            "suiteId" => $movie->getSuite(),
            "date" => $movie->getDate(),
            "length" => $movie->getLength(),
            "slug" => $movie->getSlug()
        ];
        //$movieDetails = json_encode($jsonConstruct);

        //On récupère la liste des films liés à celui-ci (s'il y en a)
        $suiteMovies = $movieTable->findBy(['movie_suite' => $movie->getSuite()]);

        //On stock tous les films faisant partie de la même série que ce film dans un tableau
        $movieSuiteList = [];
        /** @var MovieEntity $suiteMovie */
        foreach($suiteMovies as $suiteMovie){
            $movieSuiteList[] = [
                "id" => $suiteMovie->getId(),
                "img" => $suiteMovie->getImg(),
                "title" => str_replace('"', '\"', $suiteMovie->getTitle()),
                "story" => str_replace('"', '\"', $suiteMovie->getStory()),
                "date" => $suiteMovie->getDate(),
                "length" => $suiteMovie->getLength(),
                "slug" => $suiteMovie->getSlug()
            ];
        }
        //$suiteList = json_encode($jsonConstruct);

        //On récupère la liste de toutes les musiques liées à ce film
        $songs = new Song($this->getDB());
        $songs = $songs->findBy(['song_movie' => $movie->getId()], ['song_order' => 'ASC']);

        //On stock la liste des musiques liées à ce film dans un tableau
        $movieSongs = [];
        /** @var SongEntity $song */
        foreach($songs as $song){
            $movieSongs[] = [
                "id" => $song->getId(),
                "movie" => str_replace('"', '\"', $movie->getTitle()),
                "movieImg" => $movie->getImg(),
                "title" => str_replace('"', '\"', $song->getTitle()),
                "youtubeId" => $song->getVideo(),
                "censored" => $song->isCensored(),
             ];
        }
        //$songs = json_encode($jsonConstruct);

        //On récupère la liste de tous les personnages liés à ce film
        $charactersTable = new Character($this->getDB());
        $characters = $charactersTable->findBy(['char_movie' => $movie->getId()], ['char_name' => 'ASC']);

        //On stock la liste des personnages liés à ce film dans un tableau
        $movieCharacters = [];
        /** @var CharacterEntity $character */
        foreach($characters as $character){
            $movieCharacters[] = [
                "id" => $character->getId(),
                "movie" => str_replace('"', '\"', $movie->getTitle()),
                "name" => str_replace('"', '\"', $character->getName()),
                "img" => $character->getImg(),
                "desc" => str_replace('"', '\"', $character->getDesc()),
                "slug" => $movieSlug
            ];
        }
        //$characters = json_encode($jsonConstruct);

        $this->view('content.movie', compact('movieDetails', 'movieSuiteList', 'movieSongs', 'movieCharacters'));
    }

    /**
     * Display the music page of the application
     */
    public function music(){
        //On récupère la liste de tous les favoris
        $favourites = new Favourite($this->getDB());
        $favourites = $favourites->all();

        //On récupère la liste de tous les users
        $users = new User($this->getDB());
        $users = $users->all();

        //On récupère la liste de toutes les musiques
        $songs = new Song($this->getDB(), 'song_title');
        $songs = $songs->all();

        //On récupère le titre du film correspondant à chaque musique
        $movies = new Movie($this->getDB());
        $movies = $movies->all();

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = [];
        /** @var UserEntity $user */
        foreach($users as $user){
            $jsonConstruct[] = [
                "id" => $user->getId(),
                "name" => str_replace('"', '\"', $user->getName()),
                "color" => $user->getColor(),
            ];
        }
        $users = $jsonConstruct;

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = [];
        /** @var SongEntity $song */
        foreach($songs as $song){
            /** @var MovieEntity $movie */
            foreach($movies as $movie){
                if($movie->getId() === $song->getMovie()){
                    $songMovie = $movie->getTitle();
                    $songMovieImg = $movie->getImg();
                }
            }

            $usersFiltered = [];

            /** @var FavouriteEntity $favourite */
            foreach($favourites as $favourite){
                if($favourite->getSong() == $song->getId()){
                    foreach($users as $user){
                        if($user['id'] == $favourite->getUser()){
                            $userName = $user['name'];
                            $userColor = $user['color'];
                        }
                    }

                    $usersFiltered[] = [
                        "userId" => $favourite->getUser(),
                        "userName" => $userName,
                        "userColor" => $userColor,
                    ];
                }
            }

            $jsonConstruct[] = [
                "id" => $song->getId(),
                "movie" => str_replace('"', '\"', $songMovie),
                "movieImg" => $songMovieImg,
                "title" => str_replace('"', '\"', $song->getTitle()),
                "youtubeId" => $song->getVideo(),
                "users" => $usersFiltered,
                "censored" => $song->isCensored(),
            ];
        }
        $songs = $jsonConstruct;

        $this->view('content.music', compact('songs', 'users'));
    }

    /**
     * Display the character page of the application
     */
    public function characters(){
        //On récupère la liste de tous les personnages
        $charactersTable = new Character($this->getDB(), 'char_movie');
        $characters = $charactersTable->all();

        //On récupère le titre du film correspondant à chaque musique
        $movies = new Movie($this->getDB());
        $movies = $movies->all();

        //On crée un fichier Json via PHP d'après le résultat de la requête
        $jsonConstruct = array();
        /** @var CharacterEntity $character */
        foreach($characters as $character){
            /** @var MovieEntity $movie */
            foreach($movies as $movie){
                if($movie->getId() === $character->getMovie()){
                    $charMovie = $movie->getTitle();
                    $movieSlug = $movie->getSlug();
                }
            }

            $jsonConstruct[] = array(
                "id" => $character->getId(),
                "movie" => str_replace('"', '\"',$charMovie),
                "name" => str_replace('"', '\"', $character->getName()),
                "img" => $character->getImg(),
                "desc" => str_replace('"', '\"', $character->getDesc()),
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
        /** @var SongEntity $song */
        foreach($songs as $song){
            /** @var MovieEntity $movie */
            foreach($movies as $movie){
                if($movie->getId() === $song->getMovie()){
                    $songMovie = $movie->getTitle();
                    $songMovieImg = $movie->getImg();
                }
            }

            $jsonConstruct[] = array(
                "id" => $song->getId(),
                "movie" => str_replace('"', '\"', $songMovie),
                "movieImg" => $songMovieImg,
                "title" => str_replace('"', '\"', $song->getTitle()),
                "youtubeId" => $song->getVideo(),
                "censored" => $song->isCensored(),
            );
        }
        $songs = $jsonConstruct;

        $this->view('content.games', compact('songs'));
    }
}