import {addElement, removeElement} from './domElement.js';

let playList;
let youtubeApi;
let currentVideoId;
let nextVideoId;
let previousVideoId;
let playListPosition;
const $previousArrow = $('#previousVid');
const $nextArrow = $('#nextVid');
const $divVideo = $('#videoPlayer');

// Events
// When the video player or the close icon of the video player is clicked, the video player closes
$divVideo.on('click', closePlayer);

// When a song image is clicked, the video player opens
$('.songItem').on('click', (event) => {
    playListPosition = event.target.id.split('-')[1];
    play(playListPosition);
});

$previousArrow.on('click', () => {
    play(previousVideoId);
});

$nextArrow.on('click', () => {
    play(nextVideoId);
});

/**
 * Store the current playlist
 * 
 * @param {[object]} musicList 
 */
export function setMusicsList(musicList){
    playList = musicList;
}

/**
 * Return the content of the playlist
 * 
 */
export function getMusicsList(){
    return playList;
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
    currentVideoId = playList[playListPosition].youtubeId

    // Set the links of the "previous" and "next" arrows
    // If the current video is the first of the playList, the "previous" video is the last of the playList
    if(playListPosition == 0){
        previousVideoId = playList.length-1;
    }else{
        previousVideoId = playListPosition-1;
    }

    // If the current video is the last of the playlist, the "next" video is the first of the playList
    if(playListPosition+1 >= playList.length){
        nextVideoId = 0;
    }else{
        nextVideoId = playListPosition+1;
    }

    // Wait for the Youtube Player API to be ready
    onYouTubePlayerAPIReady();
    
    // Display the "videoPlayer" div
    $divVideo.removeClass('hidden');
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
    console.log('The player is ready!');
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

/*//Permet d'afficher la liste de toutes les chansons
export function showSongs(musicList = null){
    if(musicList === null){
        console.log("showSongs() => ERROR : musicList is not defined !")
    }
    else{
        for(var i=0;i<musicList.length;i++){
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
}*/