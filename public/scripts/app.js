let videoList
let videoPlayedId
let nextVideoId
let youtubeApi

function addElement(tagName = null, tagParams = [], paramsValues = []){
    if(tagName === null){
        console.log("addElement() => ERROR : tagName is not defined !")
    }else{
        let newElement = document.createElement(tagName)
        if(tagParams.length === paramsValues.length){
            for(y=0;y<tagParams.length;y++){
                if(tagParams[y] === 'innerHTML'){
                    newElement.innerHTML = paramsValues[y]
                }else{
                    newElement.setAttribute(tagParams[y], paramsValues[y])
                }
            }
        }else{
            console.log("addElement() => ERROR : the number of parameters doesn't match the number of parameters values !")
        }

        return newElement;
    }
}

//Permet de filtrer une liste de films
function movieFilter(filterString, moviesList){

    //Tout d'abord on vide le contenu de la page afin de ne pas créer de doublons
    const divMoviesList = document.getElementById('moviesList')
    divMoviesList.innerHTML = ''

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
            for(let y=0;y<keywords.length;y++){
                if(moviesList[i].movieTitle.toLowerCase().includes(keywords[y])){
                    //On ajoute ce film à la liste des films filtrés
                    moviesFiltered.push(moviesList[i])
                }
            }
        }

        return moviesFiltered
    }
}

//Permet d'afficher une liste de films, reçoit simplement en paramètres une liste de films
function showMovies(moviesList){
    for(i=0;i<moviesList.length;i++){
        let movieDiv = addElement('div', ['class'], ['movie'])//On crée un nouveau film
        const divMoviesList = document.getElementById('moviesList')
        divMoviesList.appendChild(movieDiv)//On l'ajoute dans la page
        
        movieLink = addElement('a', ['title', 'href'], [moviesList[i].movieTitle, moviesList[i].movieURL])
        movieDiv.appendChild(movieLink)

        movieImg = addElement('img', ['src'], ['./img/'+moviesList[i].movieImg])
        movieDiv.appendChild(movieImg)

        movieTitle = addElement('h3')
        movieTitle.innerHTML = moviesList[i].movieTitle
        movieDiv.appendChild(movieTitle)

        movieDate = addElement('p')
        movieDate.innerHTML = moviesList[i].movieDate
        movieDiv.appendChild(movieDate)
    }
}

//Permet de trier une liste de films par date, suite, durée ou par titre (par défaut)
function orderBy(moviesList, orderType){
    //Tout d'abord on vide le contenu de la page afin de ne pas créer de doublons
    const divMoviesList = document.getElementById('moviesList')
    divMoviesList.innerHTML = ''

    //"slice(0)" Permet de créer une copie (pas un clone) de la liste de films
    let listCopy = moviesList.slice(0)

    if(orderType === 'date'){
        
        listCopy.sort((a, b) => {
            return a.movieDate - b.movieDate
        });
        return listCopy
    }else if(orderType === 'suite'){
        listCopy.sort((a, b) => {
            return a.movieSuite - b.movieSuite
        });
        return listCopy
    }else if(orderType === 'length'){
        listCopy.sort((a, b) => {
            return a.movieLength - b.movieLength;
        });
        return listCopy
    }else{
        return moviesList
    }
}

//Permet d'afficher toutes les infos d'un film
function showMovie(movieInfo,suiteList){
    const movieImg = document.getElementById('moviePageImg')
    const movieTitle = document.getElementById('movieTitle')
    const movieDate = document.getElementById('movieDate')
    const movieLength = document.getElementById('movieLength')
    const movieStory = document.getElementById('movieStory')

    movieImg.setAttribute('src', './img/'+movieInfo.movieImg)
    movieTitle.innerHTML = movieInfo.movieTitle
    movieDate.innerHTML = '<span>Année de sortie : </span> '+movieInfo.movieDate
    movieLength.innerHTML = '<span>Durée du film : </span> '+movieInfo.movieLength+' minutes'
    movieStory.innerHTML = '<span>Synopsis : </span><br/>'+movieInfo.movieStory

    if(suiteList.length > 1){
        const movieDetails = document.getElementById('movieDetails')
        let suiteTitle = addElement('h3', ['class', 'innerHTML'], ['suiteListTitle', 'Dans la même série de films :'])
        let suiteUl = addElement('ul')
        movieDetails.appendChild(suiteTitle)
        movieDetails.appendChild(suiteUl)

        for(i=0;i<suiteList.length;i++){
            if(suiteList[i].movieTitle !== movieInfo.movieTitle){
                let newSuiteMovie = addElement('li')
                let newMovieLink = addElement('a', ['innerHTML', 'href', 'title'], [suiteList[i].movieTitle, './'+suiteList[i].movieUrl, suiteList[i].movieTitle])
                newSuiteMovie.appendChild(newMovieLink)
                suiteUl.appendChild(newSuiteMovie)
            }
        }
    }
}

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
            let songDiv = addElement('div', ['class'], ['listElement'])//On crée une nouvelle chanson

            document.getElementById('musicList').appendChild(songDiv)//On l'ajoute dans la page
            
            //h3(elementTitle) -> span(elementMovie)
            let songTitle = addElement('h3')
            songTitle.innerHTML = '<span>'+musicList[i].songMovie+'</span>'+'<br />'+musicList[i].songTitle
            songDiv.appendChild(songTitle)

            //img(elementImg,title,src,onclick)
            let songImg = addElement('img',['title','src','onclick'],[musicList[i].songTitle, 'https://img.youtube.com/vi/'+musicList[i].videoId+'/1.jpg', 'play('+i+')'])//"'+musicList[i].videoId+'"
            songDiv.appendChild(songImg)
        }
    }
}

//Permet d'ouvrir le lecteur d'une chanson
function play(videoInternalId){
    const divVideo = document.getElementById('videoPlayer')

    //On stock l'id youtube de la vidéo à afficher
    videoPlayedId = videoList[videoInternalId].videoId

    console.log('Vidéo en cours de lecture : '+videoInternalId)

    //Si cette vidéo est la dernière de la liste, on indique au script que la vidéo qui suivra sera la première de la liste
    if(videoInternalId+1 < videoList.length){
        nextVideoId = videoInternalId+1
    }else{
        nextVideoId = 0
    }

    if(youtubeApi !== undefined){
        onYouTubePlayerAPIReady()
    }else{
        //On récupère l'API iframe de Youtube dans une balise script
        youtubeApi = addElement('script', ['src'], ['http://www.youtube.com/iframe_api'])
        //On ajoute cette balise script dans le div "videoPlayer" afin que le lien vers l'API ne se fasse qu'à partir de ce moment-ci
        divVideo.appendChild(youtubeApi)
    }
    
    //On affiche le div "videoPlayer" et on le place en avant-plan
    divVideo.setAttribute('style','z-index:9998')
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
            let charDiv = addElement('div', ['class'], ['listElement'])//On crée un nouveau personnage
            document.getElementById('charactersList').appendChild(charDiv)//On l'ajoute dans la page
            
            //h3(elementTitle) -> span(elementMovie)
            let charName = addElement('h3', ['class'], ['elementTitle'])
            charName.innerHTML = '<span class="elementMovie">'+charList[i].charMovie+'</span>'+'<br />'+charList[i].charName
            charDiv.appendChild(charName)
            
            //img(elementImg,title,src,onclick)
            let charImg = addElement('img',['class','title','src','onclick'],['elementImg', charList[i].charName, './img/characters/'+charList[i].charImg, 'openInfo(charList['+i+'])'])
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
        const charImg = document.getElementById('charImg')
        const charName = document.getElementById('charName')
        const movieLink = document.getElementById('charMovieLink')
        const charDesc = document.getElementById('charDesc')

        //On intègre toutes les infos du personnage dans la fiche
        charImg.setAttribute('src', './img/characters/'+charInfo.charImg)
        charImg.setAttribute('alt', charInfo.charName)
        charName.innerHTML = charInfo.charName
        movieLink.setAttribute('href','./'+charInfo.movieUrl)
        movieLink.setAttribute('title', charInfo.charMovie)
        movieLink.innerHTML = charInfo.charMovie
        charDesc.innerHTML = charInfo.charDesc

        //On ajoute une classe à la liste des personnages afin de savoir si une fiche personnage est ouverte ou non
        charList.classList.add('infoOpened')
        charList.setAttribute('style', 'width:50%')

        //On rend la fiche personnage visible et on la place au premier plan
        divChar.setAttribute('style','z-index:9998')
        divChar.removeAttribute('class')

        //On déplace la vue jusqu'à la fiche personnage
        location.href = "#charInfo";
    }
}

//Permet de fermer la fiche info d'un personnage
function closeInfo(){
    const divChar = document.getElementById('charInfo')
    const charImg = document.getElementById('charImg')
    const charName = document.getElementById('charName')
    const movieLink = document.getElementById('charMovieLink')
    const charDesc = document.getElementById('charDesc')

    let charList = document.getElementById('charactersList')
    charList.classList.remove('infoOpened')
    charList.removeAttribute('style')

    divChar.classList.add('hidden')
    divChar.removeAttribute('style')

    charImg.setAttribute('src', '')
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