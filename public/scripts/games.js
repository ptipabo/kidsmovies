import {getMusicsList} from './songs.js';
import {addElement} from './domElement.js';
import { videoList } from './init.js';

const $videoPlayerContainer = $('#videoPlayerContainer');
let playList = getMusicsList();
let videoToPlay = Math.floor(getRandomArbitrary(0, playList.length));
const $videoPlayerSection = $('#videoPlayerSection');
const $randomJukeboxBtn = $('#randomJukeboxBtn');

$('.randomizer').on('click', () => {
    videoToPlay = Math.floor(getRandomArbitrary(0, playList.length));
    //console.log(playList[videoToPlay]);
    showSingleSong(videoToPlay);
});

function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
}

let youtubeApi;

// If the youtubeApi is undefined
if(youtubeApi == undefined){
    // Get the iframe API from Youtube in a script tag
    youtubeApi = addElement('script', ['src'], ['http://www.youtube.com/iframe_api'])
    // Adds the script tag into the "videoPlayer" div for the link to the API start only at this point
    $videoPlayerSection.append(youtubeApi);
}

/**
 * Create a new video player if a div "videoPlayer-games" exists and if the Youtube API is loaded
 */
function openPlayer(){
    // Wait for the Youtube Player API to be ready
    onYouTubePlayerAPIReady();
}

$randomJukeboxBtn.on('click', ()=>{
    changeVideo();
    closePlayer();
    openPlayer();
});

/**
 * API Youtube : Create a Youtube video player when the Youtube API is loaded
 */
let player;
function onYouTubePlayerAPIReady() {
    player = new YT.Player('videoPlayer-games', {
        'videoId': playList[videoToPlay].youtubeId,
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
        changeVideo();        
        closePlayer();
        openPlayer();
    }
}

/**
 * Pick another video into the playlist
 */
function changeVideo(){
    //On sélectionne une autre vidéo au hasard
    let nextVideoId = Math.floor(getRandomArbitrary(0, playList.length));
        
    while(nextVideoId == videoToPlay){
        nextVideoId = Math.floor(getRandomArbitrary(0, playList.length));
    }

    videoToPlay = nextVideoId;
}

/**
 * Delete the current videoPlayer and initialize it back
 */
function closePlayer(){
    $videoPlayerContainer.html('');
    let newVideoPlayer = addElement('div', ['id'], ['videoPlayer-games']);
    $videoPlayerContainer.append(newVideoPlayer);
}