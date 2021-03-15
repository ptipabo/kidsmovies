<?php

namespace App\controllers\Admin;

use App\Models\Movie;
use App\controllers\Controller;

class MovieController extends Controller{

    public function index(){
        $rawData = (new Movie($this->getDB()))->all();
        $movies = new Movie;
        foreach($rawData as $data){
            $movies->id[] = $data->movie_id;
            $movies->title[] = $data->movie_title;
            $movies->duration[] = $data->movie_length;
            $movies->story[] = $data->movie_story;
            $movies->year[] = $data->movie_date;
            $movies->img[] = $data->movie_img;
            $movies->sequel[] = $data->movie_suite;
            $movies->slug[] = $data->movie_url;
        }
        return $this->view('admin.movie.index', compact('movies'));
    }

    public function destroy(int $id){
        $movie = new Movie($this->getDB());
        $result = $movie->destroy($id);

        if($result){
            return header('Location: /admin/movies');
        }
    }
}