let charList;
const $charListDiv = $('#charactersList');
const $divChar = $('#charInfo');
const $charImg = $('#charInfoImg');
const $charName = $('#charName');
const $movieSuite = $('#charMovieLink');
const $charDesc = $('#charDesc');

// Events
$('.elementImg').on('click', (event) => {
    var characterId = event.target.id.split('-')[1];
    openInfo(charList[characterId]);
});

$('#closeInfo').on('click', closeInfo);

/**
 * Store the current characters list
 * 
 * @param {[object]} charactersList 
 */
export function setCharactersList(charactersList){
    charList = charactersList;
}

/**
 * Open a character's sheet
 * 
 * @param {[object]} charInfo
 */
function openInfo(charInfo){
    if(charInfo === undefined){
        console.log("openInfo() => ERROR : charInfo is not defined !")
    }else{
        // Check if a character's sheet is not already open
        if($charListDiv.hasClass('infoOpened')){
            closeInfo();
        }

        // Set all the character's info into the character's sheet
        $charImg.attr('src', './img/characters/'+charInfo.img);
        $charImg.attr('alt', charInfo.name);
        $charName.text(charInfo.name);
        $movieSuite.text(charInfo.suite);
        $charDesc.text(charInfo.desc);

        // Add a class to the characters list div to check if a character's sheet is already open or not
        $charListDiv.addClass('infoOpened');
        $charListDiv.css("width", "50%");

        // Make the character's sheet visible
        classRemove($divChar, 'hidden');

        // Move the screen view to the character's sheet
        location.href = "#charInfo";
    }
}

/**
 * Permet de fermer la fiche info d'un personnage
 */
function closeInfo(){
    classRemove($charListDiv, 'infoOpened');
    $charListDiv.removeAttr('style');

    $divChar.addClass('hidden');

    $charImg.src = '';
    $charImg.removeAttr('alt');
    $charName.innerHTML = '';
    $movieSuite.innerHTML = '';
    $charDesc.innerHTML = '';
}

/**
 * Remove a class from an element and remove the class attribute if there is no class left
 * 
 * @param {object} domElement
 * @param {string} classToRemove
 */
function classRemove(domElement, classToRemove){
    // Check if the domElement given is a Jquery object or a classic JS object
    if(domElement.attr('class')){
        if(domElement.attr('class').split(/\s+/).length <= 1){
            domElement.removeAttr('class');
        }
        else{
            domElement.removeClass(classToRemove);
        }
    }
    else{
        if(domElement.classList.length <= 1){
            domElement.removeAttribute('class');
        }
        else{
            domElement.classList.remove(classToRemove);
        }
    }
}

/*//Permet d'afficher la liste de tous les personnages
export function showCharacters(charList = null){
    if(charList === null){
        console.log("showCharacters() => ERROR : charList is not defined !")
    }
    else{
        for(i=0;i<charList.length;i++){
            let charDiv = addElement('div', ['className'], ['listElement'])//On crée un nouveau personnage
            document.getElementById('charactersList').appendChild(charDiv)//On l'ajoute dans la page
            
            //h3(elementTitle) -> span(elementMovie)
            let charName = addElement('h3', ['className'], ['elementTitle'])
            charName.innerHTML = '<span class="elementMovie">'+charList[i].charMovie+'</span>'+'<br />'+charList[i].charName
            charDiv.appendChild(charName)
            
            //img(elementImg,title,src,onclick)
            let charImg = addElement('img',['className', 'title', 'src', 'alt'],['elementImg', charList[i].charName, './img/characters/'+charList[i].charImg,charList[i].charName])//
            charImg.setAttribute('onclick', 'openInfo(charList['+i+'])')
            charDiv.appendChild(charImg)
        }
    }
}*/