<?php

namespace App\controllers\Admin;

use App\ORM\Movie;
use App\Entities\Movie as MovieEntity;
use App\controllers\Controller;
use App\ORM\Moviesuite;
use App\Entities\Moviesuite as Suite;
use App\ORM\Song;

class MovieController extends Controller{

    public function index(){
        $movies = (new Movie($this->getDB(), 'movie_title'))->all();
        $movieSuites = (new MovieSuite($this->getDB(), 'suite_title'))->all();
        
        return $this->view('admin.movie.index', compact('movies', 'movieSuites'));
    }

    public function create(){
        $movieSuites = (new Moviesuite($this->getDB(), 'suite_title'))->all();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])){
            $newMovie = $this->fetchData($_POST);

            if((new Movie($this->getDB()))->createMovie($newMovie)){
                header('Location: /admin/movies');
            }
        }

        return $this->view('admin.movie.create', compact('movieSuites'));
    }

    public function edit(int $id){
        /** @var MovieEntity $movie */
        $movie = (new Movie($this->getDB()))->findOneBy(['movie_id' => $id]);
        $songs = (new Song($this->getDB()))->findBy(['song_movie' => $id], ['song_order' => 'ASC']);
        $movieSuites = (new Moviesuite($this->getDB(), 'suite_title'))->all();

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])){
            $newMovie = $this->fetchData($_POST, $id);

            if((new Movie($this->getDB()))->updateMovie($newMovie)){
                header('Location: /admin/movies');
            }
        }

        return $this->view('admin.movie.edit', compact('movie', 'songs', 'movieSuites'));
    }

    public function destroy(int $id){
        $movie = new Movie($this->getDB());
        $result = $movie->destroy($id);

        if($result){
            return header('Location: /admin/movies');
        }
    }

    /**
     * Store all the data from a form to a Movie object
     */
    private function fetchData($request, int $id = null): MovieEntity
    {
        $newMovie = new MovieEntity();
        $movieSuite = null;
        if($request['suiteChoice'] == 0 && isset($request['movieSuite']) && !empty($request['movieSuite'])){
            $newMovie->setSuite($request['movieSuite']);
        }else if ($request['suiteChoice'] == 1 && isset($request['newMovieSuite']) && !empty($request['newMovieSuite'])){
            $newMovieSuite = new Suite();
            $newMovieSuite->setTitle($request['newMovieSuite']);
            // Creates a new movie suite and associate it with this new movie
            if((new MovieSuite($this->getDB()))->createSuite($newMovieSuite)){
                $movieSuite =  (new Moviesuite($this->getDB()))->findOneByTitle($newMovieSuite->getTitle());
                $newMovie->setSuite($movieSuite->suite_id);
            }
        }
        if(isset($request['movieImg']) && !empty($request['movieImg']) 
            && isset($request['movieTitle']) && !empty($request['movieTitle'])
            && isset($request['movieStory']) && !empty($request['movieStory'])
            && isset($request['movieLength']) && !empty($request['movieLength'])
            && isset($request['movieDate']) && !empty($request['movieDate'])
            && isset($request['movieSlug']) && !empty($request['movieSlug'])){
            if($id){
                $newMovie->setId($id);
            }
            $newMovie->setImg(addslashes($request['movieImg']));
            $newMovie->setTitle(addslashes($request['movieTitle']));
            $newMovie->setStory(addslashes($request['movieStory']));
            $newMovie->setLength($request['movieLength']);
            $newMovie->setDate($request['movieDate']);
            $newMovie->setSlug(addslashes($request['movieSlug']));
        }

        return $newMovie;
    }
}