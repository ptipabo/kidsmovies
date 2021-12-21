/**
 * Allows to switch easily from the movieSuite choice to the movieSuite creation and vice versa
 */
$('input[name="suiteChoice"]').on("click", function(e) {
    if($(this).val() == 0){
        $('#movieSuiteField').show();
        $('#movieSuiteField').attr('required', true);
        $('#newMovieSuiteField').hide();
        $('#newMovieSuiteField').attr('required', false);
    } else {
        $('#movieSuiteField').hide();
        $('#movieSuiteField').attr('required', false);
        $('#newMovieSuiteField').show();
        $('#newMovieSuiteField').attr('required', true);
    }
});

$('select[name="songMovie"]').on("change", function(e) {
    let pageUrl = window.location.pathname;
    let urlSplit = pageUrl.split('/');
    let currentSongId = parseInt(urlSplit[urlSplit.length-1]);
    getMovieSongs(e.target.value, currentSongId);
});

function getMovieSongs(movieId, currentSongId){
    $.ajax({url: '/api/getMovieSongs', 
        data: {
            'movieId': movieId
        },
        success: (res) => {
            updateSongsList(res['songsList'], currentSongId);
        }
    });
}

/**
 * Update the movie songs list on the edit and creation page of the amdin panel
 * 
 * @param {*} songsList 
 */
function updateSongsList(songsList, currentSongId) {
    $movieSongsList = $('#movieSongsList .admin-table');
    $movieSongsList.empty();
    $movieSongsList.html('<tr><th>Titre</th><th>Ordre</th></tr>');
    songsList.forEach(song => {
        if(song['id'] != currentSongId){
            $movieSongsList.append('<tr><td><a href="/admin/songs/edit/'+song['id']+'">'+song['title']+'</a></td><td>'+song['order']+'</td></tr>');
        }
    });
}

$('select[name="characterMovie"]').on("change", function(e) {
    let pageUrl = window.location.pathname;
    let urlSplit = pageUrl.split('/');
    let currentCharacterId = parseInt(urlSplit[urlSplit.length-1]);
    getMovieCharacters(e.target.value, currentCharacterId);
});

function getMovieCharacters(movieId, currentCharacterId){
    $.ajax({url: '/api/getMovieCharacters', 
        data: {
            'movieId': movieId
        },
        success: (res) => {
            updateCharactersList(res['charactersList'], currentCharacterId);
        }
    });
}

/**
 * Update the movie characters list on the edit and creation page of the amdin panel
 * 
 * @param {*} charactersList 
 */
function updateCharactersList(charactersList, currentCharacterId) {
    $movieCharactersList = $('#movieCharactersList .admin-table');
    $movieCharactersList.empty();
    $movieCharactersList.html('<tr><th>Nom</th></tr>');
    charactersList.forEach(character => {
        if(character['id'] != currentCharacterId){
            $movieCharactersList.append('<tr><td><a href="/admin/characters/edit/'+character['id']+'">'+character['name']+'</a></td></tr>');
        }
    });
}