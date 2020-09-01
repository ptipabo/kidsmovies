<?php

namespace App\Controllers;

class ViewController extends Controller{

    //Permet d'afficher la page Home de l'application
    public function home(){

        $stmt = $this->db->getConnection()->query('SELECT * FROM movies ORDER BY movie_title ASC');
        $movies = $stmt->fetchAll();

        $this->view('content.home', compact('movies'));
    }

    //Permet d'afficher la page Movie de l'application en lui passant l'id du film à afficher
    public function movie(string $movieTitle){

        $movieName = str_replace('-', ' ', $movieTitle);

        //prepare() permet simplement d'éviter les injections sql
        $stmtA = $this->db->getConnection()->prepare('SELECT * FROM movies WHERE movie_title=?');
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmtA->execute([$movieName]);
        //Ensuite on enclenche et on récupère toutes les données dans l'objet $movie
        $movie = $stmtA->fetch();

        $movieId = $movie->movie_id;

        $stmtB = $this->db->getConnection()->prepare('SELECT * FROM characters WHERE char_movie=?');
        $stmtB->execute([$movieId]);
        $characters = $stmtB->fetchAll();

        $stmtC = $this->db->getConnection()->prepare('SELECT * FROM songs WHERE song_movie=?');
        $stmtC->execute([$movieId]);
        $songs = $stmtC->fetchAll();

        $this->view('content.movie', compact('movie', 'characters', 'songs'));
    }
}