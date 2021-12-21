<?php

namespace App\controllers\Admin;

use App\Models\Song;
use App\Entities\Song as SongEntity;
use App\Models\Movie;
use App\controllers\Controller;
use App\Models\Character;
use App\Entities\Character as CharacterEntity;

class CharacterController extends Controller{

    public function index(){
        $characters = (new Character($this->getDB(), 'char_name'))->all();
        $movies = (new Movie($this->getDB(), 'movie_title'))->all();

        return $this->view('admin.character.index', compact('characters', 'movies'));
    }

    public function create(){
        $movies = (new Movie($this->getDB(), 'movie_title'))->all();

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])){
            $newCharacter = $this->fetchData($_POST);

            if((new Character($this->getDB()))->createCharacter($newCharacter)){
                header('Location: /admin/characters');
            }
        }

        return $this->view('admin.character.create', compact('movies'));
    }

    public function edit(int $id){
        $charactersTable = new Character($this->getDB());
        /** @var CharacterEntity $character */
        $character = $charactersTable->findOneBy(['char_id' => $id]);
        $movieCharacters = $charactersTable->findBy(['char_movie' => $character->getMovie()], ['char_name' => 'ASC']);
        $movies = (new Movie($this->getDB(), 'movie_title'))->all();

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])){
           $newCharacter = $this->fetchData($_POST, $id);

            if((new Character($this->getDB()))->updateCharacter($newCharacter)){
                header('Location: /admin/characters');
            }
        }

        return $this->view('admin.character.edit', compact('character', 'movieCharacters', 'movies'));
    }

    public function destroy(int $id){
        $song = new Song($this->getDB());
        $result = $song->destroy($id);

        if($result){
            return header('Location: /admin/characters');
        }
    }

    /**
     * Store all the data from a form to a Character object
     */
    private function fetchData($request, int $id = null): CharacterEntity
    {
        $newCharacter = new CharacterEntity();
        if(isset($request['characterMovie']) && !empty($request['characterMovie'])){
            $newCharacter->setMovie($request['characterMovie']);
        }

        if(isset($request['characterName']) && !empty($request['characterName']) 
            && isset($request['characterImg']) && !empty($request['characterImg'])
            && isset($request['characterDesc']) && !empty($request['characterDesc'])){
            if($id){
                $newCharacter->setId($id);
            }
            $newCharacter->setName(addslashes($request['characterName']));
            $newCharacter->setImg(addslashes($request['characterImg']));
            $newCharacter->setDesc(addslashes($request['characterDesc']));
        }

        return $newCharacter;
    }
}