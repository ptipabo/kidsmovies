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
    console.log(songsList);
    $movieSongsList = $('#movieSongsList .admin-table');
    $movieSongsList.empty();
    $movieSongsList.html('<tr><th>Titre</th><th>Ordre</th></tr>');
    songsList.forEach(song => {
        if(song['id'] != currentSongId){
            $movieSongsList.append('<tr><td>'+song['title']+'</td><td>'+song['order']+'</td></tr>');
        }
    });
}