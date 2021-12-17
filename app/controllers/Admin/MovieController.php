<?php

namespace App\controllers\Admin;

use App\Models\Movie;
use App\Entities\Movie as MovieEntity;
use App\controllers\Controller;
use App\Models\Moviesuite;
use App\Entities\Moviesuite as Suite;
use App\Models\Song;

class MovieController extends Controller{

    public function index(){
        $movies = (new Movie($this->getDB(), 'movie_title'))->all();
        $movieSuites = (new MovieSuite($this->getDB(), 'suite_title'))->all();
        
        return $this->view('admin.movie.index', compact('movies', 'movieSuites'));
    }

    public function create(){
        $movieSuites = (new Moviesuite($this->getDB(), 'suite_title'))->all();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])){
            $newMovie = new MovieEntity();
            $movieSuite = null;
            if($_POST['suiteChoice'] == 0 && isset($_POST['movieSuite']) && !empty($_POST['movieSuite'])){
                $newMovie->setSuite($_POST['movieSuite']);
            }else if ($_POST['suiteChoice'] == 1 && isset($_POST['newMovieSuite']) && !empty($_POST['newMovieSuite'])){
                $newMovieSuite = new Suite();
                $newMovieSuite->setTitle($_POST['newMovieSuite']);
                // Creates a new movie suite and associate it with this new movie
                if((new MovieSuite($this->getDB()))->createSuite($newMovieSuite)){
                    $movieSuite =  (new Moviesuite($this->getDB()))->findOneByTitle($newMovieSuite->getTitle());
                    $newMovie->setSuite($movieSuite->suite_id);
                }
            }
            if(isset($_POST['movieImg']) && !empty($_POST['movieImg']) 
                && isset($_POST['movieTitle']) && !empty($_POST['movieTitle'])
                && isset($_POST['movieStory']) && !empty($_POST['movieStory'])
                && isset($_POST['movieLength']) && !empty($_POST['movieLength'])
                && isset($_POST['movieDate']) && !empty($_POST['movieDate'])
                && isset($_POST['movieSlug']) && !empty($_POST['movieSlug'])){
                $newMovie->setImg(addslashes($_POST['movieImg']));
                $newMovie->setTitle(addslashes($_POST['movieTitle']));
                $newMovie->setStory(addslashes($_POST['movieStory']));
                $newMovie->setLength($_POST['movieLength']);
                $newMovie->setDate($_POST['movieDate']);
                $newMovie->setSlug(addslashes($_POST['movieSlug']));
            }

            if((new Movie($this->getDB()))->createMovie($newMovie)){
                header('Location: /admin/movies');
            }
        }

        return $this->view('admin.movie.create', compact('movieSuites'));
    }

    public function edit(int $id){
        /** @var MovieEntity $movie */
        $movie = (new Movie($this->getDB()))->findOneBy(['movie_id' => $id]);
        $songs = (new Song($this->getDB()))->findBy(['song_movie' => $id]);
        $movieSuites = (new Moviesuite($this->getDB(), 'suite_title'))->all();

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])){
            $newMovie = new MovieEntity();
            $movieSuite = null;
            var_dump($_POST);
            if($_POST['suiteChoice'] == 0 && isset($_POST['movieSuite']) && !empty($_POST['movieSuite'])){
                $newMovie->setSuite($_POST['movieSuite']);
            }else if ($_POST['suiteChoice'] == 1 && isset($_POST['newMovieSuite']) && !empty($_POST['newMovieSuite'])){
                $newMovieSuite = new Suite();
                $newMovieSuite->setTitle($_POST['newMovieSuite']);
                // Creates a new movie suite and associate it with this new movie
                if((new MovieSuite($this->getDB()))->createSuite($newMovieSuite)){
                    $movieSuite =  (new Moviesuite($this->getDB()))->findOneByTitle($newMovieSuite->getTitle());
                    $newMovie->setSuite($movieSuite->suite_id);
                }
            }
            if(isset($_POST['movieImg']) && !empty($_POST['movieImg']) 
                && isset($_POST['movieTitle']) && !empty($_POST['movieTitle'])
                && isset($_POST['movieStory']) && !empty($_POST['movieStory'])
                && isset($_POST['movieLength']) && !empty($_POST['movieLength'])
                && isset($_POST['movieDate']) && !empty($_POST['movieDate'])
                && isset($_POST['movieSlug']) && !empty($_POST['movieSlug'])){
                $newMovie->setId($id);
                $newMovie->setImg(addslashes($_POST['movieImg']));
                $newMovie->setTitle(addslashes($_POST['movieTitle']));
                $newMovie->setStory(addslashes($_POST['movieStory']));
                $newMovie->setLength($_POST['movieLength']);
                $newMovie->setDate($_POST['movieDate']);
                $newMovie->setSlug(addslashes($_POST['movieSlug']));
            }

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
}