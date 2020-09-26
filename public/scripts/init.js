//import DomElement from './classes/DomElement.js';
import Movie from './classes/Movie.js';
//import Character from './classes/Character.js';

let videoList
let videoPlayedId
let nextVideoId
let youtubeApi
export let divMoviesList

export function setDivMoviesList(value){
    divMoviesList = value;
}

//On ajoute un écouteur d'évenement sur le champ "Trier par"
const sortByField = document.getElementById('sortByValue');
sortByField.addEventListener('change', () => {showMovies(orderBy(moviesList, sortByField.value))});

//On ajoute un écouteur d'évenement sur le champ "Rechercher un film"
const filterField = document.getElementById('filterValue');
filterField.addEventListener('change', () => {showMovies(movieFilter(filterField.value, moviesList))});

//On ajoute un écouteur d'évenement sur le champ "Masquer les suites"
const hideSeriesField = document.getElementById('hideSeries');
hideSeriesField.addEventListener('change', () => {showMovies(showHideSeries(moviesList))});

/*function addElement(tagName = null, tagParams = [], paramsValues = []){
    if(tagName === null || tagName === undefined){
        console.log("addElement() => ERROR : tagName is not defined !")
    }else{
        let newElement = document.createElement(tagName)
        if(tagParams.length === paramsValues.length){
            for(y=0;y<tagParams.length;y++){
                if(tagParams[y] !== ''){
                    newElement[tagParams[y]] = paramsValues[y]
                }
            }
        }else{
            console.log("addElement() => ERROR : the number of parameters doesn't match the number of parameters values !")
        }

        return newElement;
    }
}*/

//Permet de filtrer une liste de films
function movieFilter(filterString, moviesList){

    //Si le filtre est vide, on affiche la liste complète des films
    if(filterString === ''){
        return moviesList
    }
    else{        
        //On crée le tableau qui contiendra les films à afficher
        let moviesFiltered = []

        let keywords = filterString.toLowerCase().split(' ')

        //Pour chaque film...
        for(let i=0;i<moviesList.length;i++){
            let movieTest = 0
            //On vérifie chaque mot clé...
            for(let y=0;y<keywords.length;y++){
                if(moviesList[i].movieTitle.toLowerCase().includes(keywords[y])){
                    movieTest++
                }
            }

            //Si tous les mots clés se trouvent dans le nom du film, on l'ajoute à la liste
            if(movieTest === keywords.length){
                moviesFiltered.push(moviesList[i])
            }
        }

        return moviesFiltered
    }
}

//Permet d'afficher une liste de films, reçoit simplement en paramètres une liste de films
export function showMovies(moviesList){
    //Tout d'abord on vide le contenu de la page afin de ne pas créer de doublons
    divMoviesList.innerHTML = ''

    for(let i=0;i<moviesList.length;i++){
        let movie = new Movie(moviesList[i]);
        movie.displayMovie();
    }
}

//Permet de savoir si un lien d'image est toujours valide ou non
export function imgBadLink(e){
    e.setAttribute("src", "./img/image_not_found.jpg")
    e.removeAttribute('onerror')
    console.log(e.id)
}

//Permet de trier une liste de films par date, suite, durée ou par titre (par défaut)
function orderBy(moviesList, orderType){
    //Tout d'abord on vide le contenu de la page afin de ne pas créer de doublons
    divMoviesList.innerHTML = ''

    //"slice(0)" Permet de créer une copie (pas un clone) de la liste de films
    let listCopy = moviesList.slice(0)

    if(orderType === 'titleDesc'){
        listCopy.sort((b, a) => {
            if(a.movieTitle < b.movieTitle) { return -1; }
            if(a.movieTitle > b.movieTitle) { return 1; }
            return 0;
        });
        return listCopy
    }else if(orderType === 'dateAsc'){
        listCopy.sort((a, b) => {
            return a.movieDate - b.movieDate
        });
        return listCopy
    }else if(orderType === 'dateDesc'){
        listCopy.sort((b, a) => {
            return a.movieDate - b.movieDate
        });
        return listCopy
    }else if(orderType === 'lengthAsc'){
        listCopy.sort((a, b) => {
            return a.movieLength - b.movieLength;
        });
        return listCopy
    }else if(orderType === 'lengthDesc'){
        listCopy.sort((b, a) => {
            return a.movieLength - b.movieLength;
        });
        return listCopy
    }else if(orderType === 'suite'){
        listCopy.sort((a, b) => {
            return a.movieSuite - b.movieSuite
        });
        return listCopy
    }else{
        return moviesList
    }
}

//Permet d'afficher ou masquer les suites éventuelles des films qui en possèdent
function showHideSeries(moviesList){
    let hideSeries = document.getElementById('hideSeries');
    let moviesFiltered = []
    //Si le bouton de masquage des suites est activé...
    if(hideSeries.checked === true){
        //Pour chaque film de la liste complète...
        for(let i=0;i<moviesList.length;i++){            
            //On crée une variable qui comptera le nombre d'éléments ayant le même id de série(ou suite)
            let matches = 0
            
            //Tout d'abord on doit s'assurer que le premier film d'une série sera bien le plus ancien
            //On crée donc un array qui récoltera tous les films d'une même série
            let sameSuite = []
            
            //Pour chaque film de la liste complète...
            for(let z=0;z<moviesList.length;z++){
                //On récolte tous les films de la série du film en cours de traitement
                if(moviesList[z].movieSuite === moviesList[i].movieSuite){
                    sameSuite.push(moviesList[z].movieDate)
                }
            }

            //On place le plus ancien de cette suite de films en premier dans la liste(car c'est forcément celui-là qui sera inséré dans moviesFiltered) 
            sameSuite.sort((a, b) => {
                return a - b
            });

            //Si le film en cours de traitement n'est pas le plus ancien de sa série, on fait comme si il était déjà dans moviesFiltered et on ne l'insère donc pas
            if(sameSuite[0] !== moviesList[i].movieDate){
                matches++
            }
            
            //Si le compteur n'a détecté aucun doublon, il ajoute ce film à la nouvelle liste
            if(matches === 0){
                moviesFiltered.push(moviesList[i])
            }
        }

        return moviesFiltered
    }else{
        return moviesList
    }
}

//Permet d'afficher toutes les infos d'un film
function showMovie(moviesList, movieUrl){
    for(i=0;i<moviesList.length;i++){
        if(moviesList[i].movieUrl === movieUrl){
            let movie = Movie(moviesList[i]);
            movie.getSuiteList(moviesList).movieDetails();
            return;
        }
    }
}

//Permet de convertir des minutes en heures
/*function minToHour(timeInMinutes){
    let timeInHours = Math.floor(timeInMinutes/60)
    let minutesLeft = timeInMinutes - (timeInHours*60)

    if(minutesLeft<10){
        minutesLeft = '0'+minutesLeft
    }

    return timeInHours+'h'+minutesLeft
}*/

//Permet de stocker la liste des vidéos en cours
function setMusicList(musicList){
    videoList = musicList
}

//Permet d'afficher la liste de toutes les chansons
function showSongs(musicList = null){
    if(musicList === null){
        console.log("showSongs() => ERROR : musicList is not defined !")
    }
    else{
        for(i=0;i<musicList.length;i++){
            let songDiv = addElement('div', ['className'], ['listElement'])//On crée une nouvelle chanson

            document.getElementById('musicList').appendChild(songDiv)//On l'ajoute dans la page
            
            //h3(elementTitle) -> span(elementMovie)
            let songTitle = addElement('h3')
            songTitle.innerHTML = '<span>'+musicList[i].songMovie+'</span>'+'<br />'+musicList[i].songTitle
            songDiv.appendChild(songTitle)

            //img(elementImg,title,src,onclick)
            let songImg = addElement('img',['title', 'src', 'alt'],[musicList[i].songTitle, 'https://img.youtube.com/vi/'+musicList[i].videoId+'/1.jpg', musicList[i].songTitle])//"'+musicList[i].videoId+'"
            songImg.setAttribute('onclick', 'play('+i+')')
            songDiv.appendChild(songImg)
        }
    }
}

//Permet d'ouvrir le lecteur d'une chanson
function play(videoInternalId){
    console.log(videoInternalId)
    //Permet d'empècher le déclenchement de l'événement du div parent
    if(!e){
        var e = window.event;
        e.cancelBubble = true;
    }

    //Permet d'empècher le déclenchement de l'événement du div enfant
    if(e.stopPropagation){
        e.stopPropagation();
    }

    const divVideo = document.getElementById('videoPlayer')
    const previousArrow = document.getElementById('previousVid')
    const nextArrow = document.getElementById('nextVid')
    const iframe = document.getElementsByTagName('iframe')

    if(iframe[0]){
        closePlayer()
    }

    //On stock l'id youtube de la vidéo à afficher
    videoPlayedId = videoList[videoInternalId].videoId

    if(videoInternalId === 0){
        previousArrow.setAttribute('onclick', 'play('+(videoList.length-1)+')')
    }else{
        previousArrow.setAttribute('onclick', 'play('+(videoInternalId-1)+')')
    }

    //Si cette vidéo est la dernière de la liste, on indique au script que la vidéo qui suivra sera la première de la liste
    if(videoInternalId+1 < videoList.length){
        nextVideoId = videoInternalId+1
    }else{
        nextVideoId = 0
    }

    nextArrow.setAttribute('onclick', 'play('+nextVideoId+')')

    if(youtubeApi !== undefined){
        onYouTubePlayerAPIReady()
    }else{
        //On récupère l'API iframe de Youtube dans une balise script
        youtubeApi = addElement('script', ['src'], ['http://www.youtube.com/iframe_api'])
        //On ajoute cette balise script dans le div "videoPlayer" afin que le lien vers l'API ne se fasse qu'à partir de ce moment-ci
        divVideo.appendChild(youtubeApi)
    }
    
    //On affiche le div "videoPlayer" et on le place en avant-plan
    divVideo.style.zIndex = '9997'
    divVideo.classList.remove('hidden')
}

//Permet de fermer le lecteur d'une chanson
function closePlayer(){
    const divVideo = document.getElementById('videoPlayer')

    //On masque le div "videoPlayer" et on le vide entièrement
    divVideo.classList.add('hidden')
    divVideo.removeAttribute('style')
    //divVideo.innerHTML = ''
    removeElement('videoPlayed')

    //Ensuite on recrée le div "videoPlayed" afin de réinitialiser le lecteur de vidéo
    let newPlayer = addElement('div', ['id'], ['videoPlayed'])
    divVideo.appendChild(newPlayer)
}

//Permet de retirer un élément de la page html
function removeElement(elementId) {
    let element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

//Permet d'afficher la liste de tous les personnages
function showCharacters(charList = null){
    if(charList === null){
        console.log("showCharacters() => ERROR : charList is not defined !")
    }
    else{
        for(i=0;i<charList.length;i++){
            let charDiv = addElement('div', ['className'], ['listElement'])//On crée un nouveau personnage
            document.getElementById('charactersList').appendChild(charDiv)//On l'ajoute dans la page
            
            //h3(elementTitle) -> span(elementMovie)
            let charName = addElement('h3', ['className'], ['elementTitle'])
            charName.innerHTML = '<span class="elementMovie">'+charList[i].charMovie+'</span>'+'<br />'+charList[i].charName
            charDiv.appendChild(charName)
            
            //img(elementImg,title,src,onclick)
            let charImg = addElement('img',['className', 'title', 'src', 'alt'],['elementImg', charList[i].charName, './img/characters/'+charList[i].charImg,charList[i].charName])//
            charImg.setAttribute('onclick', 'openInfo(charList['+i+'])')
            charDiv.appendChild(charImg)
        }
    }
}

//Permet d'ouvrir la fiche info d'un personnage
function openInfo(charInfo){
    
    if(charInfo === undefined){
        console.log("openInfo() => ERROR : charInfo is not defined !")
    }else{
        //On vérifie tout d'abord si une fiche personnage n'est pas déjà ouverte
        let charList = document.getElementById('charactersList')

        if(charList.classList.contains('infoOpened')){
            closeInfo()
        }

        const divChar = document.getElementById('charInfo')
        const charImg = document.getElementById('charInfoImg')
        const charName = document.getElementById('charName')
        const movieLink = document.getElementById('charMovieLink')
        const charDesc = document.getElementById('charDesc')

        //On intègre toutes les infos du personnage dans la fiche
        charImg.src = './img/characters/'+charInfo.charImg
        charImg.alt = charInfo.charName
        charName.innerHTML = charInfo.charName
        movieLink.href = './'+charInfo.movieUrl
        movieLink.title = charInfo.charMovie
        movieLink.innerHTML = charInfo.charMovie
        charDesc.innerHTML = charInfo.charDesc

        //On ajoute une classe à la liste des personnages afin de savoir si une fiche personnage est ouverte ou non
        charList.classList.add('infoOpened')
        charList.style.width = '50%'

        //On rend la fiche personnage visible et on la place au premier plan
        divChar.style.zIndex = '9998'
        divChar.removeAttribute('class')

        //On déplace la vue jusqu'à la fiche personnage
        location.href = "#charInfo";
    }
}

//Permet de fermer la fiche info d'un personnage
function closeInfo(){
    const divChar = document.getElementById('charInfo')
    const charImg = document.getElementById('charInfoImg')
    const charName = document.getElementById('charName')
    const movieLink = document.getElementById('charMovieLink')
    const charDesc = document.getElementById('charDesc')

    let charList = document.getElementById('charactersList')
    charList.classList.remove('infoOpened')
    charList.removeAttribute('style')

    divChar.classList.add('hidden')
    divChar.removeAttribute('style')

    charImg.src = ''
    charImg.removeAttribute('alt')
    charName.innerHTML = ''
    movieLink.innerHTML = ''
    movieLink.removeAttribute('href')
    movieLink.removeAttribute('title')
    charDesc.innerHTML = ''
}

//API Youtube : Crée un lecteur vidéo Youtube
var player;
function onYouTubePlayerAPIReady() {
    player = new YT.Player('videoPlayed', {
        'videoId': videoPlayedId,
        'events': {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

//API Youtube : L'API appellera cette fonction quand le lecteur sera prêt
function onPlayerReady(event) {
    console.log('Test')
    event.target.playVideo();
}

//API Youtube : Quand la vidéo en cours de lecture est terminée
function onPlayerStateChange(event) {        
    if(event.data === 0) {
        closePlayer()
        console.log('Démarrage vidéo '+(nextVideoId)+'...')      
        //On lance la vidéo suivante
        play(nextVideoId)
    }
}