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

function addElement(tagName = null, tagParams = [], paramsValues = []){
    if(tagName === null){
        console.log("addElement() => ERROR : tagName is not defined !")
    }else{
        let newElement = document.createElement(tagName)
        if(tagParams.length === paramsValues.length){
            for(y=0;y<tagParams.length;y++){
                newElement.setAttribute(tagParams[y], paramsValues[y])
            }
        }else{
            console.log("addElement() => ERROR : the number of parameters doesn't match the number of parameters values !")
        }

        return newElement;
    }
}

//Permet d'afficher une liste de films, reçoit simplement en paramètres une liste de films
function showMovies(moviesList){
    for(i=0;i<moviesList.length;i++){
        let movieDiv = document.createElement('div')//On crée un nouveau film
        movieDiv.setAttribute('class', 'movie')//On lui dit qu'il est un film
        document.getElementById('mainContent').appendChild(movieDiv)//On l'ajoute dans la page
        
        movieLink = addElement('a', ['class', 'title', 'href'], ['movieLink', moviesList[i].movieTitle, moviesList[i].movieURL])
        movieDiv.appendChild(movieLink)

        movieImg = addElement('img', ['class', 'src'], ['moviePicture', './img/'+moviesList[i].movieImg])
        movieDiv.appendChild(movieImg)

        movieTitle = addElement('h3', ['class'], ['movieTitle'])
        movieTitle.innerHTML = moviesList[i].movieTitle
        movieDiv.appendChild(movieTitle)

        movieDate = addElement('p', ['class'], ['movieDate'])
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

function showSongs(musicList = null){
    if(musicList === null){
        console.log("showSongs() => ERROR : musicList is not defined !")
    }
    else{
        for(i=0;i<musicList.length;i++){
            let songDiv = document.createElement('div')//On crée une nouvelle chanson
            songDiv.setAttribute('class', 'listElement')//On lui dit qu'il est une chanson
            document.getElementById('mainContent').appendChild(songDiv)//On l'ajoute dans la page
            
            //h3(elementTitle) -> span(elementMovie)
            let songTitle = addElement('h3', ['class'], ['elementTitle'])
            songTitle.innerHTML = '<span class="elementMovie">'+musicList[i].songMovie+'</span>'+'<br />'+musicList[i].songTitle
            songDiv.appendChild(songTitle)

            //img(elementImg,title,src,onclick)
            let songImg = addElement('img',['class','title','src','onclick'],['elementImg', musicList[i].songTitle, 'https://img.youtube.com/vi/'+musicList[i].videoId+'/1.jpg', 'play("'+musicList[i].songVideo+'")'])
            songDiv.appendChild(songImg)
        }
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