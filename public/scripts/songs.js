import {addElement, removeElement} from './domElement.js';

let defaultPlayList;
let users;
let types;
let currentPlayList;
let youtubeApi;
let currentVideoId;
let nextVideoId;
let previousVideoId;
let playListPosition;
let enabledUserFilters = [];
let enabledTypeFilters = [];
let randomModeEnabled = false;
const $previousArrow = $('#previousVid');
const $nextArrow = $('#nextVid');
const $divVideo = $('#videoPlayer');
const $randomModeButton = $('#randomModeButton');
const $users = $('.usersList_user');
const $types = $('.contentTypesList_type');

// Events
export function initSongsEvents(){
    // When the video player or the close icon of the video player is clicked, the video player closes
    $divVideo.on('click', closePlayer);

    // When a song image is clicked, the video player opens
    $('.songItem').on('click', (event) => {
        playListPosition = event.target.id.split('-')[1];
        play(playListPosition);
    });

    $('.favourite').on('click', (event) => {
        let songId = event.target.id.split('_')[1];
        let userId = event.target.id.split('_')[2];

        if(checkFavourite(songId, userId) == true){
            removeFavourite(songId, userId);
        }else{
            addFavourite(songId, userId);
        }
    });
}

$previousArrow.on('click', () => {
    play(previousVideoId);
});

$nextArrow.on('click', () => {
    play(nextVideoId);
});

$randomModeButton.on('click', (event) => {
    let classList = event.target.className.split(/\s+/);
    let randomClassFound = false;
    for (let classCounter = 0;classCounter < classList.length;classCounter++){
        if(classList[classCounter] == 'randomModeEnabled'){
            randomClassFound = true;
            randomModeEnabled = false;
            $randomModeButton.removeClass('randomModeEnabled');
        }
    }
    if(randomClassFound == false){
        randomModeEnabled = true;
        $randomModeButton.addClass('randomModeEnabled');
    }

    $('#musicList').empty();
    if(randomModeEnabled == true){
        showSongs(shuffleArray(currentPlayList));
    }else{
        showSongs(sortArray(currentPlayList));
    }
});

$users.on('click', (event) => {
    let classList = event.target.className.split(/\s+/);
    let userId = classList[1].split('_')[1];
    filterByUser(userId);
});

$types.on('click', (event) => {
    let classList = event.target.className.split(/\s+/);
    let typeId = classList[1].split('_')[1];
    filterByType(typeId);
});

function checkFavourite(songId, userId){
    let response = false;
    $.ajax({url: '/api/checkfavourite', 
        data: {
            'songId': songId,
            'userId': userId
        },
        async: false,
        success: (result) => {
            response = result.success;
        }
    });

    return response;
}

function addFavourite(songId, userId){
    $.ajax({url: '/api/addfavourite', 
        data: {
            'songId': songId,
            'userId': userId
        },
        success: () => {
            document.location.reload();
        }
    });
}

function removeFavourite(songId, userId){
    $.ajax({url: '/api/removefavourite', 
        data: {
            'songId': songId,
            'userId': userId
        },
        success: () => {
            document.location.reload();
        }
    });
}

/**
 * Enable or disable the filter by type of content
 * 
 * @param {number} typeId
 * @param {boolean} randomMode
 * 
 */
export function filterByType(typeId){
    $('.type_'+typeId).toggleClass('isActive');
    let filteredPlayList = [];

    if($('.type_'+typeId).hasClass('isActive')){
        // Add this filter to the list of active filters
        enabledTypeFilters.push(typeId);
    }else{
        // Remove this filter from the list of active filters
        let tempTypeFiltersEnabled = [];
        enabledTypeFilters.forEach(filter => {
            if(filter != typeId){
                tempTypeFiltersEnabled.push(filter);
            }
        });
        enabledTypeFilters = tempTypeFiltersEnabled;
    }

    // Filter the current playlist to keep only the songs of all the type filters that are enabled
    enabledTypeFilters.forEach(type => {
        defaultPlayList.forEach(song => {
            if(song.movieType == type){
                filteredPlayList.push(song);
            }
        });
    });

    // If at least 1 user filter is enabled
    if(enabledUserFilters.length > 0){
        let doubleFilteredPlayList = [];

        let tempFilteredPlayList = [];
        // If there is no type filter selected anymore, we apply the user filters on the default playlist because otherwise it would be empty
        if(enabledTypeFilters.length == 0){
            tempFilteredPlayList = defaultPlayList;
        }else{
            tempFilteredPlayList = filteredPlayList;
        }

        // Filter the filteredPlaylist a second time to apply the current user filters
        for(let z = 0;z < tempFilteredPlayList.length;z++){
            usersFilterLoop: {
                for(let y = 0;y < enabledUserFilters.length;y++){
                    for(let i = 0;i < tempFilteredPlayList[z].users.length;i++){
                        if(tempFilteredPlayList[z].users[i].userId == enabledUserFilters[y]){
                            doubleFilteredPlayList.push(tempFilteredPlayList[z]);
                            break usersFilterLoop;
                        }
                    }
                }
            }
        }

        filteredPlayList = doubleFilteredPlayList;
    }

    if(enabledTypeFilters.length > 0 || enabledUserFilters.length > 0){
        currentPlayList = filteredPlayList;
    }else{
        currentPlayList = defaultPlayList;
    }

    $('#musicList').empty();
    if(randomModeEnabled == true){
        showSongs(shuffleArray(currentPlayList));
    }else{
        showSongs(sortArray(currentPlayList));
    }
}

/**
 * Enable or disable the filter by user's favourite songs
 * 
 * @param {number} userId 
 */
export function filterByUser(userId){
    $('.user_'+userId).toggleClass('isActive');
    let filteredPlayList = [];

    if($('.user_'+userId).hasClass('isActive')){
        // Add this filter to the list of active filters
        enabledUserFilters.push(userId);
    }else{
        // Remove this filter from the list of active filters
        let tempFiltersEnabled = [];
        enabledUserFilters.forEach(filter => {
            if(filter != userId){
                tempFiltersEnabled.push(filter);
            }
        });
        enabledUserFilters = tempFiltersEnabled;
    }

    // Filter the current playlist to keep only the songs of this filter
    for(let z = 0;z < defaultPlayList.length;z++){
        usersFilterLoop: {
            for(let y = 0;y < enabledUserFilters.length;y++){
                for(let i = 0;i < defaultPlayList[z].users.length;i++){
                    if(defaultPlayList[z].users[i].userId == enabledUserFilters[y]){
                        filteredPlayList.push(defaultPlayList[z]);
                        break usersFilterLoop;
                    }
                }
            }
        }
    }

    // If at least 1 type filter is enabled
    if(enabledTypeFilters.length > 0){
        let doubleFilteredPlayList = [];

        let tempFilteredPlayList = [];
        // If there is no type filter selected anymore, we apply the user filters on the default playlist because otherwise it would be empty
        if(enabledUserFilters.length == 0){
            tempFilteredPlayList = defaultPlayList;
        }else{
            tempFilteredPlayList = filteredPlayList;
        }

        // Filter the current playlist to keep only the songs of all the type filters that are enabled
        enabledTypeFilters.forEach(type => {
            tempFilteredPlayList.forEach(song => {
                if(song.movieType == type){
                    doubleFilteredPlayList.push(song);
                }
            });
        });

        filteredPlayList = doubleFilteredPlayList;
    }

    if(enabledUserFilters.length > 0 || enabledTypeFilters.length > 0){
        currentPlayList = filteredPlayList;
    }else{
        currentPlayList = defaultPlayList;
    }

    $('#musicList').empty();
    if(randomModeEnabled == true){
        showSongs(shuffleArray(currentPlayList));
    }else{
        showSongs(sortArray(currentPlayList));
    }
}

/**
 * Shuffle an array
 * 
 * 
 * @param {*} array 
 * @returns 
 */
function shuffleArray(array) {
    let currentIndex = array.length,  randomIndex;

    // While there remain elements to shuffle...
    while (currentIndex != 0) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        [array[currentIndex], array[randomIndex]] = [
        array[randomIndex], array[currentIndex]];
    }

    return array;
}

/**
 * Sort an array by alphabetical order from A to Z or Z to A
 * 
 * @param {*} array 
 * @param {boolean} sortFromAToZ
 * @returns 
 */
function sortArray(array, sortFromAToZ = true) {
    let sortedArray;
    
    if(sortFromAToZ == true){
        sortedArray = array.sort((a, b) => a.title.localeCompare(b.title));
    }else{
        sortedArray = array.sort((b, a) => a.title.localeCompare(b.title));
    }

    return sortedArray;
}

/**
 * Store the current playlist
 * 
 * @param {[object]} musicList 
 */
export function setMusicsList(musicList){
    defaultPlayList = musicList;
    currentPlayList = musicList;
    initSongsEvents();
}

/**
 * Store the current users list
 * 
 * @param {[object]} usersList 
 */
 export function setUsersList(usersList){
    users = usersList;
}

/**
 * Store the current types list
 * 
 * @param {[object]} typesList 
 */
export function setTypesList(typesList){
    types = typesList;
}

/**
 * Return the content of the playlist
 * 
 */
export function getMusicsList(){
    return defaultPlayList;
}

/**
 * Permet d'afficher la liste de toutes les chansons
 * 
 * @param {[object]} musicList
 */
export function showSongs(musicList = null){
    if(musicList === null){
        console.log("showSongs() => ERROR : musicList is not defined !")
    }
    else{
        for(var i=0;i<musicList.length;i++){
            let songDiv = addElement('div', ['className'], ['listElement'])//On crée une nouvelle chanson

            document.getElementById('musicList').appendChild(songDiv)//On l'ajoute dans la page
            
            let songTitle = addElement('h3');
            songTitle.innerHTML = '<span>'+musicList[i].movie+'</span>'+'<br />'+musicList[i].title;
            songDiv.appendChild(songTitle);

            let songImg = addElement('img',['className','id','title', 'src', 'alt'],['songItem', 'song-'+i, musicList[i].title, 'https://img.youtube.com/vi/'+musicList[i].youtubeId+'/1.jpg', musicList[i].title]);
            songDiv.appendChild(songImg);

            let usersList = addElement('ul',['className'], ['song_usersList']);
            songDiv.appendChild(usersList);

            users.forEach(user => {
                let userDetected = false;
                musicList[i].users.forEach(songUser => {
                    if(songUser.userId == user.id){
                        userDetected = true;
                    }
                });
                let newItem = addElement('li', ['className', 'id', 'title'], [(userDetected ? 'songUser' : 'notSongUser')+' border favourite userColor_'+user.color, 'favData_'+musicList[i].id+'_'+user.id, (userDetected ? 'Retirer des' : 'Ajouter aux')+' favoris de '+user.name ]);
                newItem.innerHTML = user.name[0];
                usersList.appendChild(newItem);
            });
        }

        initSongsEvents();
    }
}

/**
 * Set everything to correctly display the video player and its controls
 * 
 * @param {number} playListPosition 
 */
export function play(playListPosition){
    // Permet d'empècher le déclenchement de l'événement du div parent
    if(!e){
        var e = window.event;
        e.cancelBubble = true;
    }

    // Permet d'empècher le déclenchement de l'événement du div enfant
    if(e.stopPropagation){
        e.stopPropagation();
    }

    const $iframe = $('iframe');

    // If an iframe is already opened, it closes
    if($iframe[0]){
        closePlayer();
    }

    // Store the youtube id of the video to display
    currentVideoId = currentPlayList[playListPosition].youtubeId

    // Set the links of the "previous" and "next" arrows
    // If the current video is the first of the playList, the "previous" video is the last of the playList
    if(parseInt(playListPosition) == 0){
        previousVideoId = parseInt(currentPlayList.length)-1;
    }else{
        previousVideoId = parseInt(playListPosition)-1;
    }

    // If the current video is the last of the playlist, the "next" video is the first of the playList
    if(parseInt(playListPosition)+1 >= currentPlayList.length){
        nextVideoId = 0;
    }else{
        nextVideoId = parseInt(playListPosition)+1;
    }

    // Wait for the Youtube Player API to be ready
    onYouTubePlayerAPIReady();
    
    // Display the "videoPlayer" div
    $divVideo.removeClass('hidden');

    let $censoredBlock = $('#censoredBlock')[0];
    if(currentPlayList[playListPosition].censored != 0) {
        removeCensoredImg();
        let movieImg = addElement('img',['id', 'src', 'alt'],['censoredBlock-img', currentPlayList[playListPosition].movieImg, currentPlayList[playListPosition].title]);
        $censoredBlock.appendChild(movieImg);
        $censoredBlock.classList.remove('hidden');
    }
    else {
        $censoredBlock.classList.add('hidden');
        removeCensoredImg();
    }
}

/**
 * Remove the previous image from the censored block
 */
function removeCensoredImg(){
    if($('#censoredBlock img')[0]) {
        removeElement('censoredBlock-img');
    }
}

/**
 * Closes the video player
 */
function closePlayer(){
    // Hide the "videoPlayer" div
    $divVideo.addClass('hidden');
    removeElement('videoPlayed');

    // Then create a new "videoPlayed" div to reset the video player
    let newPlayer = addElement('div', ['id'], ['videoPlayed']);
    $divVideo.append(newPlayer);
}

// If the youtubeApi is defined
if(youtubeApi == undefined){
    // Get the iframe API from Youtube in a script tag
    youtubeApi = addElement('script', ['src'], ['http://www.youtube.com/iframe_api'])
    // Adds the script tag into the "videoPlayer" div for the link to the API start only at this point
    $divVideo.append(youtubeApi);
}

/**
 * API Youtube : Create a Youtube video player when the Youtube API is loaded
 */
let player;
function onYouTubePlayerAPIReady() {
    player = new YT.Player('videoPlayed', {
        'videoId': currentVideoId,
        'events': {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

/**
 * API Youtube : L'API appellera cette fonction quand le lecteur sera prêt
 */
function onPlayerReady(event) {
    event.target.playVideo();
}

/**
 * API Youtube : Quand la vidéo en cours de lecture est terminée
 */
function onPlayerStateChange(event) {        
    if(event.data === 0) {
        closePlayer()
        //On lance la vidéo suivante
        play(nextVideoId)
    }
}