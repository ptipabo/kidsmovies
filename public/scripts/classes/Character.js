import Movie from './Movie.js';

export default class Character extends Movie{

    charId;
    charImg;
    charName;
    charDesc;

    constructor(charId, movieId, charName = null, charDesc = null, charImg = null){
        super(movieId);
        super.movieId = movieId;
        this.charId = charId;
        this.charImg = charImg;
        this.charName = charName;
        this.charDesc = charDesc;
    }
}