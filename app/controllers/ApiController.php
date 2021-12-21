<?php

namespace App\controllers;

use App\Models\Song;
use App\Entities\Song as SongEntity;
use App\Models\Movie;
use App\Models\Character;
use App\Entities\Character as CharacterEntity;
use App\Models\Favourite;
use App\Models\User;

class ApiController extends Controller{

    /**
     * Checks if a song is in the favourites of a user or not
     */
    public function checkFavourite(){
        if(isset($_GET['userId']) && isset($_GET['songId'])){
            $songId = $_GET['songId'];
            $userId = $_GET['userId'];
            //On récupère la liste de tous les favoris
            $favourites = new Favourite($this->getDB());
            $favouriteFound = $favourites->checkFavourite($songId, $userId);

            if($favouriteFound > 0){
                header('Content-type: application/json');
                echo json_encode( ['success' => true, 'error' => ''] );
            }else{
                header('Content-type: application/json');
                echo json_encode( ['success' => false, 'error' => 'No data found for these parameters.'] );
            }
        }else{
            header('Content-type: application/json');
                echo json_encode( ['success' => false, 'error' => 'Missing GET data : userId and/or songId not defined.'] );
        }
    }

    /**
     * Add a song to the favourites of a user
     */
    public function addFavourite(){
        if(isset($_GET['userId']) && isset($_GET['songId'])){
            $songId = $_GET['songId'];
            $userId = $_GET['userId'];
            //On récupère la liste de tous les favoris
            $favourites = new Favourite($this->getDB());
            $favouriteFound = $favourites->addFavourite($songId, $userId);

            if($favouriteFound == true){
                header('Content-type: application/json');
                echo json_encode( ['success' => true, 'error' => ''] );
            }else{
                header('Content-type: application/json');
                echo json_encode( ['success' => false, 'error' => 'Operation failed.'] );
            }
        }else{
            header('Content-type: application/json');
                echo json_encode( ['success' => false, 'error' => 'Missing GET data : userId and/or songId not defined.'] );
        }
    }

    /**
     * Remove a song from the favourites of a user
     */
    public function removeFavourite(){
        if(isset($_GET['userId']) && isset($_GET['songId'])){
            $songId = $_GET['songId'];
            $userId = $_GET['userId'];
            //On récupère la liste de tous les favoris
            $favourites = new Favourite($this->getDB());
            $favouriteFound = $favourites->removeFavourite($songId, $userId);

            if($favouriteFound == true){
                header('Content-type: application/json');
                echo json_encode( ['success' => true, 'error' => ''] );
            }else{
                header('Content-type: application/json');
                echo json_encode( ['success' => false, 'error' => 'Operation failed.'] );
            }
        }else{
            header('Content-type: application/json');
            echo json_encode( ['success' => false, 'error' => 'Missing GET data : userId and/or songId not defined.'] );
        }
    }

    public function getMovieSongs(){
        if(isset($_GET['movieId'])){
            $songsList = (new Song($this->getDB()))->findBy(['song_movie' => $_GET['movieId']], ['song_order' => 'ASC']);

            $songsListFinal = [];

            /** @var SongEntity $song */
            foreach($songsList as $song){
                $newSong = [];
                $newSong['id'] = $song->getId();
                $newSong['title'] = $song->getTitle();
                $newSong['video'] = $song->getVideo();
                $newSong['censored'] = $song->isCensored();
                $newSong['order'] = $song->getOrder();
                $songsListFinal[] = $newSong;
            }
            
            header('Content-type: application/json');
            echo json_encode( ['success' => true, 'songsList' => $songsListFinal, 'error' => ''] );
        }else{
            header('Content-type: application/json');
            echo json_encode( ['success' => false, 'error' => 'Missing GET data : movieId not defined.'] );
        }
    }

    public function getMovieCharacters(){
        if(isset($_GET['movieId'])){
            $charactersList = (new Character($this->getDB()))->findBy(['char_movie' => $_GET['movieId']], ['char_name' => 'ASC']);

            $charactersListFinal = [];

            /** @var CharacterEntity $character */
            foreach($charactersList as $character){
                $newCharacter = [];
                $newCharacter['id'] = $character->getId();
                $newCharacter['name'] = $character->getName();
                $newCharacter['img'] = $character->getImg();
                $newCharacter['desc'] = $character->getDesc();
                $charactersListFinal[] = $newCharacter;
            }
            
            header('Content-type: application/json');
            echo json_encode( ['success' => true, 'charactersList' => $charactersListFinal, 'error' => ''] );
        }else{
            header('Content-type: application/json');
            echo json_encode( ['success' => false, 'error' => 'Missing GET data : movieId not defined.'] );
        }
    }
}