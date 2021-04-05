import {getMusicsList} from './songs.js';
import {addElement} from './domElement.js';
import { videoList } from './init.js';

let playList = getMusicsList();
let videoToPlay = Math.floor(getRandomArbitrary(0, playList.length));
let youtubeApi;
const $videoPlayerSection = $('#videoPlayerSection');
const $videoPlayerContainer = $('#videoPlayerContainer');
const $playBtn = $('#randomJukeboxBtn');
const $stopBtn = $('#randowJukeboxBtnStop');

// Events
$playBtn.on('click', ()=>{
    changeVideo();
    closePlayer();
    openPlayer();
    if($stopBtn.hasClass('hidden')){
        $stopBtn.removeClass('hidden');
    }
});

$stopBtn.on('click', () => {
    closePlayer();
    $stopBtn.addClass('hidden');
});

/**
 * Select a number between a min and a max value
 * 
 * @param {number} min 
 * @param {number} max 
 * @returns 
 */
function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
}

// If the youtubeApi is undefined
if(youtubeApi == undefined){
    // Get the iframe API from Youtube in a script tag
    youtubeApi = addElement('script', ['src'], ['http://www.youtube.com/iframe_api'])
    // Adds the script tag into the "videoPlayer" div for the link to the API start only at this point
    $videoPlayerSection.append(youtubeApi);
}

/**
 * Create a new video player if a div "videoPlayer-jukeBox" exists and if the Youtube API is loaded
 */
function openPlayer(){
    // Wait for the Youtube Player API to be ready
    onYouTubePlayerAPIReady();
}

/**
 * Delete the current videoPlayer and initialize it back
 */
 function closePlayer(){
    $videoPlayerContainer.html('');
    let newVideoPlayer = addElement('div', ['id'], ['videoPlayer-jukeBox']);
    $videoPlayerContainer.append(newVideoPlayer);
}

/**
 * API Youtube : Create a Youtube video player when the Youtube API is loaded
 */
let player;
function onYouTubePlayerAPIReady() {
    player = new YT.Player('videoPlayer-jukeBox', {
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