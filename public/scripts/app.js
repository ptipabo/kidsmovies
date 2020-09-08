//import DomElement from './components/DomElement.js'

class DomElement{

    constructor(id){
        this.element = document.getElementById(id)
        this.elementClasses = this.element.className.split(' ');

    }

    getClass(classNumber = null){
        if(classNumber === null){
            return this.elementClasses
        }
        else{
            return this.elementClasses[classNumber]
        }
    }

    addClass(className){
        this.element.classList.add(className)
    }

    removeClass(className){
        this.element.classList.remove(className)
    }
}

//Permet d'afficher une liste de films, reçoit simplement en paramètres une liste de films
function showMovies(moviesList){
    for(i=0;i<moviesList.length;i++){
        let movieDiv = document.createElement('div')//On crée un nouveau film
        movieDiv.setAttribute('class', 'movie')//On lui dit qu'il est un film
        document.getElementById('mainContent').appendChild(movieDiv)//On l'ajoute dans la page
        
        movieLink = document.createElement('a')
        movieLink.setAttribute('class', 'movieLink')
        movieLink.setAttribute('title', moviesList[i].movieTitle)
        movieLink.setAttribute('href', moviesList[i].movieURL)
        movieDiv.appendChild(movieLink)

        movieImg = document.createElement('img')
        movieImg.setAttribute('class', 'moviePicture')
        movieImg.setAttribute('src', './img/'+moviesList[i].movieImg)
        movieDiv.appendChild(movieImg)

        movieTitle = document.createElement('h3')
        movieTitle.setAttribute('class', 'movieTitle')
        movieTitle.innerHTML = moviesList[i].movieTitle
        movieDiv.appendChild(movieTitle)

        movieDate = document.createElement('p')
        movieDate.setAttribute('class', 'movieDate')
        movieDate.innerHTML = moviesList[i].movieDate
        movieDiv.appendChild(movieDate)
    }
}

//Permet de trier une liste de films par date, suite, durée ou par titre (par défaut)
function orderBy(moviesList, orderType){
    //Tout d'abord On vide le contenu de la page afin de ne pas créer de doublons
    document.getElementById('mainContent').innerHTML = ''

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

function play(videoUrl){
    const divVideo = document.getElementById('videoPlayer')
    const iframe = document.getElementById('videoPlayed')

    iframe.setAttribute('src', videoUrl)
    divVideo.setAttribute('style','z-index:9998')

    divVideo.classList.remove('hidden')
}

function closePlayer(){
    const divVideo = document.getElementById('videoPlayer')
    const iframe = document.getElementById('videoPlayed')

    divVideo.classList.add('hidden')
    divVideo.removeAttribute('style')
    iframe.setAttribute('src', '')
}

function openInfo(charInfo){    
    const divChar = document.getElementById('charInfo')
    const charImg = document.getElementById('charImg')
    const charName = document.getElementById('charName')
    const charMovie = document.getElementById('charMovie')
    const charDesc = document.getElementById('charDesc')

    charImg.setAttribute('src', './img/characters/'+charInfo.charImg)
    charImg.setAttribute('alt', charInfo.charName)
    charName.innerHTML = charInfo.charName
    charMovie.innerHTML = 'Film : '+charInfo.charMovie
    charDesc.innerHTML = charInfo.charDesc
    
    charList = document.getElementsByClassName('charactersList')
    charList[0].classList.add('infoOpened')

    divChar.setAttribute('style','z-index:9998')
    divChar.removeAttribute('class')

    location.href = "#charInfo";
}

function closeInfo(){
    const divChar = document.getElementById('charInfo')

    charList = document.getElementsByClassName('charactersList')
    charList[0].classList.remove('infoOpened')

    divChar.classList.add('hidden')
    divChar.removeAttribute('style')

    charImg.setAttribute('src', '')
    charImg.removeAttribute('alt')
    charName.innerHTML = ''
    charMovie.innerHTML = ''
    charDesc.innerHTML = ''
}