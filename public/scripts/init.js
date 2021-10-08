import Movie from './classes/Movie.js';
//import Character from './classes/Character.js';

export let videoList
export let divMoviesList = document.getElementById('moviesList');

/**
 * 
 * @param {*} value 
 */
export function setDivMoviesList(value){
    divMoviesList = value;
}

// Adds a "change" event on the "Order by" field
if(document.getElementById('sortByValue')){
    const sortByField = document.getElementById('sortByValue');

    sortByField.addEventListener('change',
        () => {
            if(divMoviesList){
                showMovies(
                    orderBy(moviesList, sortByField.value)
                )
            }
        }
    );
}

//console.log(document.getElementsByClassName('game-randomizerButton'));

/*if(document.getElementsByClassName('game-randomizerButton')){
    console.log('test');
    document.getElementsByClassName('game-randomizerButton')[0].on('click', () => {
        console.log('Hellow!')
    });
}*/

// Adds a "change" event on the "Search a movie" field
if(document.getElementById('filterValue')){
    const filterField = document.getElementById('filterValue');
    filterField.addEventListener('keyup',
        () => {
            if(divMoviesList){
                showMovies(
                    movieFilter(filterField.value, moviesList)
                )
            }
        }
    );
}

//Adds a "change" event on the "Hide sequels" field
if(document.getElementById('hideSeries')){
    const hideSeriesField = document.getElementById('hideSeries');
    hideSeriesField.addEventListener('change',
        () => {
            if(divMoviesList){
                showMovies(
                    showHideSeries(moviesList)
                )
            }
        }
    );
}

/**
 * Filter a list of movies by keywords
 * 
 * @param {string} filterString 
 * @param {[object]} moviesList 
 */
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

/**
 * Display a list of movies
 * 
 * @param {[object]} moviesList 
 */
export function showMovies(moviesList){
    //Firstly we remove the current content of the page to not create double content
    divMoviesList.innerHTML = ''

    if(moviesList.length > 1){
        for(let i=0;i<moviesList.length;i++){
            let movie = new Movie(moviesList[i]);
            movie.displayMovie();
        }
    }
    else{
        divMoviesList.innerHTML = "<p class=\"errorMsg\">Désolé Donald, mais je n'ai rien compris...</p>"
    }
}

/**
 * Check if the link of a picture is still good or not
 * 
 * @param {event} e 
 */
export function imgBadLink(e){
    e.setAttribute("src", "./img/image_not_found.jpg")
    e.removeAttribute('onerror')
}

/**
 * Order a movies list by date of release, sequel, duration or title (by default)
 * 
 * @param {[object]} moviesList 
 * @param {string} orderType 
 */
function orderBy(moviesList, orderType){

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

/**
 * Display or hide the sequels of movies that has it
 * 
 * @param {[object]} moviesList 
 */
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

/**
 * Display all the info from a movie
 * 
 * @param {[object]} moviesList 
 * @param {string} movieUrl 
 */
function showMovie(moviesList, movieUrl){
    for(i=0;i<moviesList.length;i++){
        if(moviesList[i].movieUrl === movieUrl){
            let movie = Movie(moviesList[i]);
            movie.getSuiteList(moviesList).movieDetails();
            return;
        }
    }
}

/**
 * Permet de convertir des minutes en heures
 * 
 * @param {number} timeInMinutes 
 */
function minToHour(timeInMinutes){
    let timeInHours = Math.floor(timeInMinutes/60)
    let minutesLeft = timeInMinutes - (timeInHours*60)

    if(minutesLeft<10){
        minutesLeft = '0'+minutesLeft
    }

    return timeInHours+'h'+minutesLeft
}