import {Movie} from 'Movie.js';

export default class Character extends Movie{

    constructor(charId, movieId, charName = null, charDesc = null, charImg = null){
        this.movieId = movieId;
        this.charId = charId;
        this.charImg = charImg;
        this.charName = charName;
        this.charDesc = charDesc;
    }
}