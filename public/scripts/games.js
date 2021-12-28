const usersFields = document.getElementsByName('playersList');
const levels = document.getElementsByName('level');
const startBtn = document.getElementById('startGame');
const stepASection = document.getElementById('games-stepA');
const stepBSection = document.getElementById('games-stepB');
const pathName = window.location.pathname;
const gameId = pathName.split('/').at(-1);
let charList;
let playersList = [];
let finalPlayersList = [];
let gameLevel = 0;

usersFields.forEach((userField) => {
    userField.addEventListener('click', () => {
        // If the user is checked, add it to the players list
        if(userField.checked){
            playersList.push(userField.value);
        }else{// else, remove it from the players list
            let playerIndex = playersList.indexOf(userField.value);
            if (playerIndex > -1) {
                playersList.splice(playerIndex, 1);
            }
        }

        // The start button is active only if at least 1 player wants to play
        if(startBtn.disabled){
            if(playersList.length >= 1){
                startBtn.disabled = false;
            }
        }else{
            if(playersList.length < 1){
                startBtn.disabled = true;
            }
        }
    });
});

startBtn.addEventListener('click', (event) => {
    event.preventDefault();
    // Refresh the list of players to get them in the correct order
    finalPlayersList = [];
    usersFields.forEach((userField) => {
        if(userField.checked){
            finalPlayersList.push(userField.value);
        }
    });
    let breakLoop = false;
    levels.forEach((level) => {
        if(!breakLoop && level.checked){
            gameLevel = level.value;
            breakLoop = true;
        }
    });

    initGame();
    /*console.log(finalPlayersList);
    console.log(gameLevel);*/
});

function initGame(){
    if(gameId == 2){
        // this value is used to always have an even number of minimum character's number
        let addValue = parseInt(gameLevel)-1;
        let colsNumber = parseInt(gameLevel)+addValue+3;

        // count the minimum number of characters needed to make the game work
        let minCharNeeded = Math.ceil((colsNumber * colsNumber)/2);
        console.log(minCharNeeded);
        if(charList.length < minCharNeeded){
            alert('Erreur : Pas assez de personnages enregistrés pour pouvoir jouer à ce jeu! Il faut un minimum de '+minCharNeeded+' personnages pour que ce jeu puisse fonctionner correctement. Veuillez donc ajouter de nouveaux personnages puis réessayer.')
        }else{
            if(!stepASection.classList.contains('hidden')){
                stepASection.classList.add('hidden');
            }
            if(stepBSection.classList.contains('hidden')){
                stepBSection.classList.remove('hidden');
            }
        }

        let randomCharList = shuffleArray(charList);
        let slicedArray = randomCharList.slice(0, minCharNeeded);
        let gameCards = slicedArray.concat(slicedArray);
        gameCards = shuffleArray(gameCards);
        console.log(gameCards);

        let gameContainer = document.getElementById('memory-stepB-container');
        let gameArea = document.createElement('table');
        let tableContent = '';
        let charCounter = 0;
        
        for(let i=0; i<colsNumber; i++){
            tableContent += '<tr>';
            for(let y=0; y<colsNumber; y++){
                tableContent += '<td><img id="character_'+charCounter+'" src="/img/characters/'+gameCards[charCounter]['img']+'" alt="Image not found"></td>';
                charCounter++;
            }
            tableContent += '</tr>';
        }

        gameArea.innerHTML = tableContent;

        gameContainer.appendChild(gameArea);
    }
}

/**
 * Store the current characters list
 * 
 * @param {[object]} charactersList 
 */
 export function setCharactersList(charactersList){
    charList = charactersList;
}

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