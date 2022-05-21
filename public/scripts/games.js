const usersFields = document.getElementsByName('playersList');
const levels = document.getElementsByName('level');
const startBtn = document.getElementById('startGame');
const stepASection = document.getElementById('games-stepA');
const stepBSection = document.getElementById('games-stepB');
const playerNameLocation = document.getElementById('playerName');
const roundCounterLocation = document.getElementById('roundCounter');
const playerScoreLocation = document.getElementById('playerScore');
const pathName = window.location.pathname;
const gameId = pathName.split('/').at(-1);
let gameCells;
let charList;
let usersList;
let playersList = [];
let finalPlayersList = [];
let gameLevel = 0;
let firstCardSelected = null;
let playerScores = [];
let playerTurn = 0;
let comboBonus = 1;

usersFields.forEach((userField) => {
    userField.addEventListener('click', () => {
        // If the user is checked, add it to the players list
        if(userField.checked){
            userField.nextElementSibling.classList.add('isActive');
            playersList.push(userField.value);
        }else{// else, remove it from the players list
            let playerIndex = playersList.indexOf(userField.value);
            if (playerIndex > -1) {
                userField.nextElementSibling.classList.remove('isActive');
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

    playersList = finalPlayersList;

    initGame();
});

function initGame(){
    for(let player of playersList){
        playerScores.push(0);
    }

    if(gameId == 2){
        playerNameLocation.innerHTML = usersList[playersList[playerTurn]]['name'];
        if(!playerNameLocation.classList.contains('color-'+usersList[playersList[playerTurn]]['color'])){
            playerNameLocation.classList.add('color-'+usersList[playersList[playerTurn]]['color']);
        }

        let colsNumber;
        let rowsNumber;
        let cellWidth;
        switch(gameLevel){
            case '1':
                colsNumber = 4;
                rowsNumber = 3;
                cellWidth = 'A';
                break;
            case '2':
                colsNumber = 6;
                rowsNumber = 5;
                cellWidth = 'B';
                break;
            case '3':
                colsNumber = 9;
                rowsNumber = 6;
                cellWidth = 'C';
                break;
            case '4':
                colsNumber = 10;
                rowsNumber = 9;
                cellWidth = 'D';
                break;
            case '5':
                colsNumber = 12;
                rowsNumber = 11;
                cellWidth = 'D';
                break;
            default:
                colsNumber = 8;
                rowsNumber = 4;
                cellWidth = 'A';
        }

        // count the minimum number of characters needed to make the game work
        let minCharNeeded = Math.ceil((colsNumber * rowsNumber)/2);

        if(charList.length < minCharNeeded){
            alert('Erreur : Pas assez de personnages enregistrés pour pouvoir jouer à ce jeu! Il faut un minimum de '+minCharNeeded+' personnages pour que ce jeu puisse fonctionner correctement. Veuillez donc ajouter de nouveaux personnages puis réessayer.')
        }else{
            if(!stepASection.classList.contains('hidden')){
                stepASection.classList.add('hidden');
            }
            if(stepBSection.classList.contains('hidden')){
                stepBSection.classList.remove('hidden');
            }

            let randomCharList = shuffleArray(charList);
            let slicedArray = randomCharList.slice(0, minCharNeeded);
            let gameCards = slicedArray.concat(slicedArray);
            gameCards = shuffleArray(gameCards);

            let gameContainer = document.getElementById('memory-stepB-container');
            let gameDisabler = document.createElement('div');
            gameDisabler.classList.add('memory-disabler');
            let gameArea = document.createElement('table');
            gameArea.classList.add('memory-table');
            let tableContent = '';
            let charCounter = 0;
            
            for(let i=0; i<rowsNumber; i++){
                tableContent += '<tr>';
                for(let y=0; y<colsNumber; y++){
                    tableContent += '<td id="card_'+charCounter+'" class="memory-cell level'+cellWidth+'"><img class="memory-backCard" src="/img/games/memory-backCard.jpg"><img id="character_'+charCounter+'" class="memory-card" src="/img/characters/'+gameCards[charCounter]['img']+'" alt="Image not found"></td>';
                    charCounter++;
                }
                tableContent += '</tr>';
            }

            gameDisabler.innerHTML = '.';
            gameArea.innerHTML = tableContent;
            let roundCounter = 1;
            
            gameContainer.appendChild(gameDisabler);
            gameContainer.appendChild(gameArea);

            gameCells = document.getElementsByClassName('memory-backCard');
            for(let cell of gameCells){
                cell.addEventListener('click', (e) => {
                    let cardId = e.path[1].id.split('_')[1];
                    //let test = document.querySelector('#card_'+cardId)
                    e.target.style.display = 'none';
                    // check if the first card already has been selected or not
                    if(!firstCardSelected){
                        firstCardSelected = cardId;
                    }else{
                        // check if the second card is not the same as the first card
                        if(firstCardSelected != cardId){
                            // if the characters are the same on both cards, the player obtain 1 point
                            if(gameCards[firstCardSelected]['id'] == gameCards[cardId]['id']){
                                playerScores[playerTurn] = playerScores[playerTurn]+(1*comboBonus);
                                comboBonus++;
                                // if it's not the last player to play, it's the next player's turn
                                /*
                                if(playerNameLocation.classList.contains('color-'+usersList[playersList[playerTurn]]['color'])){
                                    playerNameLocation.classList.remove('color-'+usersList[playersList[playerTurn]]['color']);
                                }
                                if(playerTurn < playersList.length-1){
                                    playerTurn++;
                                }else{// else it's the first player to play
                                    playerTurn = 0;
                                }
                                playerNameLocation.innerHTML = usersList[playersList[playerTurn]]['name'];
                                if(!playerNameLocation.classList.contains('color-'+usersList[playersList[playerTurn]]['color'])){
                                    playerNameLocation.classList.add('color-'+usersList[playersList[playerTurn]]['color']);
                                }*/

                                playerScoreLocation.innerHTML = playerScores[playerTurn];

                                // Check if these cards were the last ones to be found
                                let remainingCards = 0;
                                for(let card of gameCells){
                                    if(card.style.display != 'none'){
                                        remainingCards++;
                                    }
                                }

                                if(remainingCards < 1){
                                    let endMessage = document.createElement('div');
                                    endMessage.classList.add('gameResults');
                                    let finalResults = [];
                                    for(let score of playerScores){
                                        finalResults.push([playersList[playerScores.indexOf(score)],score]);
                                    }
                                    finalResults.sort((a, b) => {
                                        return a[1] - b[1];
                                    });
                                    finalResults = finalResults.reverse();
                                    
                                    let endMsgContent = '<p>GAGANT : <span class="player-info color-'+usersList[finalResults[0][0]]['color']+'">'+usersList[finalResults[0][0]]['name']+'</span> avec <span class="player-info">'+finalResults[0][1]+'</span> points en '+roundCounter+' tours, Félicitations!</p>';
                                    if(playersList.length > 1){
                                        endMsgContent += '<p>Scores des autres joueurs :</p>';
                                        endMsgContent += '<ul class="gameResults-list">';
                                        for(let i=1;i<finalResults.length;i++){
                                            endMsgContent += '<li>'+usersList[finalResults[i][0]]['name']+' => '+finalResults[i][1]+'</li>'
                                        }
                                        endMsgContent += '</ul>';
                                    }
                                    endMsgContent += '<a href="/games/2" class="kidsMoviesBtn greenBG">Rejouer</a>'

                                    endMessage.innerHTML = endMsgContent;
                                    stepBSection.appendChild(endMessage);
                                }else{
                                    firstCardSelected = null;
                                }
                            }else{
                                comboBonus = 1;
                                let disabler = document.getElementsByClassName('memory-disabler')[0];
                                disabler.style.display = 'block';
                                // Wait 2 seconds then hide the cards again
                                setTimeout(() => {
                                    document.getElementById('card_'+firstCardSelected).firstChild.style.display = 'block';
                                    e.target.style.display = 'block';
                                    disabler.style.display = 'none';
                                    if(playerNameLocation.classList.contains('color-'+usersList[playersList[playerTurn]]['color'])){
                                        playerNameLocation.classList.remove('color-'+usersList[playersList[playerTurn]]['color']);
                                    }
                                    // if it's not the last player to play, it's the next player turn
                                    if(playerTurn < playersList.length-1){
                                        playerTurn++;
                                    }else{// else it's the first player to play
                                        roundCounter++;
                                        playerTurn = 0;
                                    }
                                    roundCounterLocation.innerHTML = roundCounter+'<sup>'+(roundCounter === 1?'er':'ème')+'</sup>';
                                    playerNameLocation.innerHTML = usersList[playersList[playerTurn]]['name'];
                                    if(!playerNameLocation.classList.contains('color-'+usersList[playersList[playerTurn]]['color'])){
                                        playerNameLocation.classList.add('color-'+usersList[playersList[playerTurn]]['color']);
                                    }
                                    playerScoreLocation.innerHTML = playerScores[playerTurn];
                                    firstCardSelected = null;
                                }, 2000)
                            }
                        }
                    }
                });
            }
        }
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

/**
 * Store the current users list
 * 
 * @param {[object]} usersList 
 */
 export function setUsersList(users){
    usersList = users;
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