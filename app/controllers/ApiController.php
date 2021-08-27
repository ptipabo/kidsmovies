<?php

namespace App\controllers;

use App\Models\Song;
use App\Models\Movie;
use App\Models\Character;
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
}