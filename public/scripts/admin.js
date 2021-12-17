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