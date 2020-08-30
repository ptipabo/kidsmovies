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
    public function movie(int $id){

        //prepare() permet simplement d'éviter les injections sql
        $stmtA = $this->db->getConnection()->prepare('SELECT * FROM movies WHERE movie_id=?');
        //On indique ensuite au statement qu'il doit remplacer le "?" par la variable $id
        $stmtA->execute([$id]);
        //Ensuite on enclenche et on récupère toutes les données dans l'objet $movie
        $movie = $stmtA->fetch();

        $stmtB = $this->db->getConnection()->prepare('SELECT * FROM characters WHERE char_movie=?');
        $stmtB->execute([$id]);
        $characters = $stmtB->fetchAll();

        $this->view('content.movie', compact('movie', 'characters'));
    }
}