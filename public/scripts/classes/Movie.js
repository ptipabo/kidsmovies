import {DomElement} from 'DomElement.js';

export default class Movie extends DomElement{
    
    movieId;
    movieTitle;
    movieImg;
    movieStory;
    movieLength;
    movieDate;
    movieSuite;

    constructor(movieId, movieTitle = null, movieImg = null,movieStory = null, movieLength = null, movieDate = null, movieSuite = null){
        this.movieId = movieId;
        this.movieTitle = movieTitle;
        this.movieImg = movieImg;
        this.movieStory = movieStory;
        this.movieLength = movieLength;
        this.movieDate = movieDate;
        this.movieSuite = movieSuite;
    }

    displayMovie(){

    }

    /*getMovieId(){
        return this.movieId;
    }

    getMovieTitle(){
        return this.movieTitle;
    }

    getMovieImg(){
        return this.movieImg;
    }

    getMovieStory(){
        return this.movieStory;
    }

    getMovieLength(){
        return this.movieLength;
    }

    getMovieDate(){
        return this.movieDate;
    }

    getMovieSuite(){
        return this.movieSuite;
    }

    setMovieId(value){
        this.movieId = value;
    }

    setMovieTitle(value){
        this.movieTitle = value;
    }

    setMovieImg(value){
        this.movieImg = value;
    }

    setMovieStory(value){
        this.movieStory = value;
    }

    setMovieLength(value){
        this.movieLength = value;
    }

    setMovieDate(value){
        this.movieDate = value;
    }

    setMovieSuite(value){
        this.movieSuite = value;
    }*/
}