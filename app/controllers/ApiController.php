<?php

namespace App\controllers;

use App\ORM\Logs;
use App\Entities\Logs as LogsEntity;
use App\ORM\Song;
use App\Entities\Song as SongEntity;
use App\ORM\Movie;
use App\ORM\Character;
use App\Entities\Character as CharacterEntity;
use App\Entities\MemoryScore as MemoryScoreEntity;
use App\ORM\Favourite;
use App\ORM\MemoryScore;
use App\ORM\User;
use DateTime;

class ApiController extends Controller{

    /**
     * Checks if a song is in the favourites of a user or not
     */
    public function checkFavourite(){
        if(isset($_GET['userId']) && isset($_GET['songId'])){
            $songId = $_GET['songId'];
            $userId = $_GET['userId'];
            //Connexion to the "favourites" table
            $favouritesRepo = new Favourite($this->getDB());
            $favouriteFound = $favouritesRepo->checkFavourite($songId, $userId);

            if($favouriteFound > 0){
                header('Content-type: application/json');
                echo json_encode( ['success' => true, 'error' => ''] );
            }else{
                header('Content-type: application/json');
                echo json_encode( ['success' => false, 'error' => 'No data found for these parameters.'] );
            }
        }else{
            $this->sendMissingDataResponse();
        }
    }

    /**
     * Add a song to the favourites of a user
     */
    public function addFavourite(){
        if(isset($_GET['userId']) && isset($_GET['songId'])){
            $songId = $_GET['songId'];
            $userId = $_GET['userId'];
            //Connexion to the "favourites" table
            $favouritesRepo = new Favourite($this->getDB());
            $favouriteFound = $favouritesRepo->addFavourite($songId, $userId);

            $this->sendResponse($favouriteFound);
        }else{
            $this->sendMissingDataResponse();
        }
    }

    /**
     * Remove a song from the favourites of a user
     */
    public function removeFavourite(){
        if(isset($_GET['userId']) && isset($_GET['songId'])){
            $songId = $_GET['songId'];
            $userId = $_GET['userId'];
            //Connexion to the "favourites" table
            $favouritesRepo = new Favourite($this->getDB());
            $favouriteFound = $favouritesRepo->removeFavourite($songId, $userId);

            $this->sendResponse($favouriteFound);
        }else{
            $this->sendMissingDataResponse();
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
            $this->sendMissingDataResponse();
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
            $this->sendMissingDataResponse();
        }
    }

    /**
     * Add the score of a player to the memory game scores
     */
    public function addMemoryScore(){
        if(isset($_GET['userId']) && isset($_GET['score']) && isset($_GET['numberOfTurns']) && isset($_GET['difficultyMode']) && isset($_GET['numberOfPlayers'])){
            $newScore = new MemoryScoreEntity();
            $newScore->setUser($_GET['userId']);
            $newScore->setDate(new DateTime());
            $newScore->setScore($_GET['score']);
            $newScore->setNumberOfTurns($_GET['numberOfTurns']);
            $newScore->setDifficultyMode($_GET['difficultyMode']);
            $newScore->setNumberOfPlayers($_GET['numberOfPlayers']);

            //Connexion to the "memory_score" table
            $memoryScoreRepo = new MemoryScore($this->getDB());
            $scoreSaved = $memoryScoreRepo->addScore($newScore);

            $this->sendResponse($scoreSaved);
            
        }else{
            $this->sendMissingDataResponse();
        }
    }

    public function addLog(){
        if(isset($_GET['event_type']) && isset($_GET['message'])){
            $newLog = new LogsEntity();
            $newLog->setEventType($_GET['event_type']);
            $newLog->setMessage($_GET['message']);
            $newLog->setTimestamp(new DateTime('now'));

            //Connexion to the "memory_score" table
            $logsRepo = new Logs($this->getDB());
            $logSaved = $logsRepo->addLog($newLog);

            $this->sendResponse($logSaved);
            
        }else{
            $this->sendMissingDataResponse();
        }
    }

    /**
     * Send a response in json format
     */
    private function sendResponse(bool $response)
    {
        if($response == true){
            header('Content-type: application/json');
            echo json_encode( ['success' => true, 'error' => ''] );
        }else{
            header('Content-type: application/json');
            echo json_encode( ['success' => false, 'error' => 'Operation failed.'] );
        }
    }

    /**
     * Send a "Missing data" response in json format
     */
    private function sendMissingDataResponse()
    {
        header('Content-type: application/json');
        echo json_encode( ['success' => false, 'error' => 'Missing GET data.'] );
    }
}