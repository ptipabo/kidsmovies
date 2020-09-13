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

//Permet de filtrer une liste de films
function movieFilter(filterString, moviesList){

    //Tout d'abord on vide le contenu de la page afin de ne pas créer de doublons
    document.getElementById('mainContent').innerHTML = ''

    //Si le filtre est vide, on affiche la liste complète des films
    if(filterString === ''){
        return moviesList
    }
    else{        
        //On crée le tableau qui contiendra les films à afficher
        let moviesFiltered = []

        //Pour chaque film...
        for(let i=0;i<moviesList.length;i++){
            //Si le titre du film est identique au contenu du champ de filtre (totalement ou en partie)
            if(searchFor(filterString, moviesList[i].movieTitle)){
                //On ajoute ce film à la liste des films filtrés
                moviesFiltered.push(moviesList[i])
            }
        }

        return moviesFiltered
    }
}

//Permet de vérifier si une chaine de caractères en contient une autre (dans le même ordre de caractères)
function searchFor(filter, target){
    //On sépare tous les caractères de la chaine de caractère à chercher et de la chaine de caractère à analyser (tout en les mettant en bas de casse pour simplifier la comparaison)
    const lettersToSearch = filter.toLowerCase().split('')
    const targetLetters = target.toLowerCase().split('')

    //On reconstruit les chaines de caractère progressivement afin de pouvoir les comparer dynamiquement
    let reconstructA = lettersToSearch[0];
    let reconstructB = targetLetters[0];

    //Pour chaque caractère à comparer...
    for(let i=0;i<lettersToSearch.length;i++){
        //Si la chaine A correspond à la chaine B...
        if(reconstructA === reconstructB){

            //Si cette boucle est la dernière, on renvoie true
            if((i+1) >= lettersToSearch.length){
                return true
            }else{//Sinon on ajoute le caractère suivant et on passe à la boucle suivante
                reconstructA += lettersToSearch[i+1]
                reconstructB += targetLetters[i+1]
            }
        }
        else{//Si elle ne correspond pas, on renvoie false
            return false
        }
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
    //Tout d'abord on vide le contenu de la page afin de ne pas créer de doublons
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
        let suiteTitle = document.createElement('h3')
        suiteTitle.setAttribute('class', 'suiteListTitle')
        suiteTitle.innerHTML = 'Dans la même série de films :'
        let suiteUl = document.createElement('ul')
        movieDetails.appendChild(suiteTitle)
        movieDetails.appendChild(suiteUl)

        for(i=0;i<suiteList.length;i++){
            if(suiteList[i].movieTitle !== movieInfo.movieTitle){
                let newSuiteMovie = document.createElement('li')
                let newMovieLink = document.createElement('a')
                newMovieLink.innerHTML = suiteList[i].movieTitle
                newMovieLink.setAttribute('href', './'+suiteList[i].movieUrl)
                newMovieLink.setAttribute('title', suiteList[i].movieTitle)
                newSuiteMovie.appendChild(newMovieLink)
                suiteUl.appendChild(newSuiteMovie)
            }
        }
    }
    
}

//Permet d'afficher la liste de toutes les chansons
function showSongs(musicList = null){
    if(musicList === null){
        console.log("showSongs() => ERROR : musicList is not defined !")
    }
    else{
        for(i=0;i<musicList.length;i++){
            let songDiv = document.createElement('div')//On crée une nouvelle chanson
            songDiv.setAttribute('class', 'listElement')//On lui dit qu'il est une chanson

            document.getElementById('musicList').appendChild(songDiv)//On l'ajoute dans la page
            
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

//Permet d'ouvrir le lecteur d'une chanson
function play(videoUrl){
    const divVideo = document.getElementById('videoPlayer')
    const iframe = document.getElementById('videoPlayed')

    iframe.setAttribute('src', videoUrl)
    divVideo.setAttribute('style','z-index:9998')

    divVideo.classList.remove('hidden')
}

//Permet de fermer le lecteur d'une chanson
function closePlayer(){
    const divVideo = document.getElementById('videoPlayer')
    const iframe = document.getElementById('videoPlayed')

    divVideo.classList.add('hidden')
    divVideo.removeAttribute('style')
    iframe.setAttribute('src', '')
}

//Permet d'afficher la liste de tous les personnages
function showCharacters(charList = null){
    if(charList === null){
        console.log("showCharacters() => ERROR : charList is not defined !")
    }
    else{
        for(i=0;i<charList.length;i++){
            let charDiv = document.createElement('div')//On crée un nouveau personnage
            charDiv.setAttribute('class', 'listElement')//On lui dit qu'il est un personnage
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