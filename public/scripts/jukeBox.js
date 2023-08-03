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
    reloadRandomVideo();
});

$stopBtn.on('click', () => {
    closePlayer();
    $stopBtn.addClass('hidden');
});

function reloadRandomVideo() {
    changeVideo();
    closePlayer();
    openPlayer();
    if($stopBtn.hasClass('hidden')){
        $stopBtn.removeClass('hidden');
    }
}

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
    if(playList[videoToPlay].censored){
        let censoredBlock = addElement('div', ['className'], ['censoredBlock random']);
        let moviePicture = addElement('img', ['src'], [playList[videoToPlay].movieImg]);
        censoredBlock.append(moviePicture);
        $videoPlayerContainer.append(censoredBlock);
    }

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
    const newIframe = document.querySelector('#videoPlayer-jukeBox');
    // On vérifie si la vidéo à bien été trouvée (si ce n'est pas le cas, le title de l'iframe indique "YouTube video player" sinon il contiendrait le titre de la vidéo)
    if(newIframe.getAttribute('title') === 'YouTube video player'){
        console.log('Error : video not found => reloading player...');
        const missingVideo = playList[videoToPlay];
        // On enregistre l'id de la vidéo manquante dans les logs
        addLog(1, encodeURIComponent('Id : '+missingVideo.id+', Movie : '+missingVideo.movie+', Title : '+missingVideo.title+', Youtube ID : '+missingVideo.youtubeId));
        // On passe directement à la chanson suivante
        reloadRandomVideo();
    }
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

function addLog(eventType, message) {
    $.ajax({url: '/api/addlog', 
        data: {
            'event_type': eventType,
            'message': message
        }
    });
}