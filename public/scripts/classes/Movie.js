import {addElement} from '../domElement.js';
import {divMoviesList, imgBadLink} from '../init.js';

export default class Movie{
    
    movieId;
    movieUrl;
    movieTitle;
    movieImg;
    movieStory;
    movieLength;
    movieDate;
    movieSuite;
    suiteList;

    /**
     * 
     * @param {object} movieInfo  
     */
    constructor(movieInfo){
        this.movieId = movieInfo.movieId;
        this.movieUrl = movieInfo.movieUrl;
        this.movieTitle = movieInfo.movieTitle;
        this.movieImg = movieInfo.movieImg;
        this.movieStory = movieInfo.movieStory;
        this.movieLength = movieInfo.movieLength;
        this.movieDate = movieInfo.movieDate;
        this.movieSuite = movieInfo.movieSuite;
    }

    /**
     * Permet de détecter et stocker toutes les suites éventuelles d'un film parmi une liste de films
     * @param array moviesList {objectList {movieId, movieSuite}}
     */
    getSuiteList(moviesList){
        for(let i=0;i<moviesList.length;i++){
            if(moviesList[i].movieSuite === this.movieSuite){
                suiteList.push(moviesList[i].movieId);
            }
        }
    }

    /**
     * Permet d'afficher l'image, le titre et l'année du film dans un lien cliquable
     */
    displayMovie(){
        let movieDiv = addElement('div', ['className'], ['movie'])//On crée un nouveau film
        divMoviesList.appendChild(movieDiv)//On l'ajoute dans la page
        
        let movieLink = addElement('a', ['href','title'], [this.movieUrl, this.movieTitle])
        movieDiv.appendChild(movieLink)

        let movieImg = addElement('img', ['src', 'alt', 'id'], [this.movieImg, this.movieTitle, 'movieImg_'+this.movieUrl])
        movieImg.addEventListener('error', () => {imgBadLink(document.getElementById('movieImg_'+this.movieUrl))})
        movieDiv.appendChild(movieImg)

        let movieTitle = addElement('h3')
        movieTitle.innerHTML = this.movieTitle
        movieDiv.appendChild(movieTitle)

        let movieDate = addElement('p')
        movieDate.innerHTML = this.movieDate
        movieDiv.appendChild(movieDate)
    }

    /**
     * Permet d'afficher tous les détails d'un film de manière formatée
     */
    movieDetails(){//movieInfo,suiteList){
        const movieImg = document.getElementById('moviePageImg')
        const movieTitle = document.getElementById('movieTitle')
        const movieDate = document.getElementById('movieDate')
        const movieLength = document.getElementById('movieLength')
        const movieStory = document.getElementById('movieStory')
    
        //let lengthInHours = minToHour(this.movieLength)
    
        movieImg.src = this.movieImg
        movieImg.setAttribute('onerror', 'imgBadLink(this)')
        movieTitle.innerHTML = this.movieTitle
        movieDate.innerHTML = '<span>Année de sortie : </span> '+this.movieDate
        movieLength.innerHTML = '<span>Durée du film : </span> '+this.movieLength
        movieStory.innerHTML = '<span>Synopsis : </span><br/>'+this.movieStory
    
        if(suiteList.length > 1){
            const movieDetails = document.getElementById('movieDetails')
            let suiteTitle = addElement('h3', ['className', 'innerHTML'], ['suiteListTitle', 'Dans la même série de films :'])
            let suiteUl = addElement('ul')
            movieDetails.appendChild(suiteTitle)
            movieDetails.appendChild(suiteUl)
    
            for(let i=0;i<suiteList.length;i++){
                if(suiteList[i].movieTitle !== this.movieTitle){
                    let newSuiteMovie = addElement('li')
                    let newMovieLink = addElement('a', ['innerHTML', 'href', 'title'], [suiteList[i].movieTitle, './'+suiteList[i].movieUrl, suiteList[i].movieTitle])
                    newSuiteMovie.appendChild(newMovieLink)
                    suiteUl.appendChild(newSuiteMovie)
                }
            }
        }
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