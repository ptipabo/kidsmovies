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

    if(gameId == 1){
        showInDevError();
    } else if(gameId == 2){
        // First we update the player's name and its color
        updatePlayerName(usersList[playersList[playerTurn]]);
        
        // Then we build the memory grid based on the parameters selected by the user
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
        const minCharNeeded = Math.ceil((colsNumber * rowsNumber)/2);

        if(charList.length < minCharNeeded){
            alert('Erreur : Pas assez de personnages enregistrés pour pouvoir jouer à ce jeu! Il faut un minimum de '+minCharNeeded+' personnages pour que ce jeu puisse fonctionner correctement. Veuillez donc ajouter de nouveaux personnages puis réessayer.')
        }else{
            goToStepB();

            const randomCharList = shuffleArray(charList);
            const slicedArray = randomCharList.slice(0, minCharNeeded);
            let gameCards = slicedArray.concat(slicedArray);
            gameCards = shuffleArray(gameCards);

            const gameContainer = document.getElementById('memory-stepB-container');
            const gameDisabler = document.createElement('div');
            gameDisabler.classList.add('memory-disabler');
            const gameArea = document.createElement('table');
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
                    const cardId = e.currentTarget.parentNode.id.split('_')[1];
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
                                updatePlayerName(usersList[playersList[playerTurn]]);
                                */

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
                                    saveScore(usersList[finalResults[0][0]]['id'], finalResults[0][1], roundCounter, gameLevel, playersList.length);
                                    if(playersList.length > 1){
                                        endMsgContent += '<p>Scores des autres joueurs :</p>';
                                        endMsgContent += '<ul class="gameResults-list">';
                                        for(let i=1;i<finalResults.length;i++){
                                            saveScore(usersList[finalResults[i][0]]['id'], finalResults[i][1], roundCounter, gameLevel, playersList.length);
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
                                    updatePlayerName(usersList[playersList[playerTurn]]);
                                    playerScoreLocation.innerHTML = playerScores[playerTurn];
                                    firstCardSelected = null;
                                }, 2000)
                            }
                        }
                    }
                });
            }
        }
    }else if(gameId == 3){
        //showInDevError();
        // First we update the player's name and its color
        updatePlayerName(usersList[playersList[playerTurn]]);

        initLabyrinthGame();

        goToStepB();
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

function saveScore(userId, score, turnsNbr, difficultyMode, playersNbr) {
    $.ajax({url: '/api/addmemoryscore', 
    data: {
        'userId': userId,
        'score': score,
        'numberOfTurns': turnsNbr,
        'difficultyMode': difficultyMode,
        'numberOfPlayers': playersNbr
    }
});
}

/**
 * Hide the step A's elements and show the step B's content of the selected game
 */
function goToStepB(){
    if(!stepASection.classList.contains('hidden')){
        stepASection.classList.add('hidden');
    }
    if(stepBSection.classList.contains('hidden')){
        stepBSection.classList.remove('hidden');
    }
}

/**
 * Update the player's name and its color on a game
 */
function updatePlayerName(currentPlayer){
    playerNameLocation.innerHTML = currentPlayer['name'];
    if(!playerNameLocation.classList.contains('color-'+currentPlayer['color'])){
        playerNameLocation.classList.add('color-'+currentPlayer['color']);
    }
}

function showInDevError(){
    alert('Ce jeu est toujours en cours de développement, veuillez réessayer plus tard!');
    stop;
}

/**
 * Generate the start board of the Labyrinth game
 */
function initLabyrinthGame(){
    const rowsNumber = 9;
    const colsNumber = 9;

    const cornerImg = 'corner';
    const cornerIds = {
        tl : 0,
        tr : 6,
        bl : 42,
        br : 48
    };
    const cornerWalls = 20;
    const straightWalls = 12;
    const threeWaysWalls = 18;
    let walls = [];

    // We generate all the wall pieces
    for(let i=0;i<straightWalls;i++){
        walls.push('straight');
    }
    for(let i=0;i<cornerWalls;i++){
        walls.push(cornerImg); 
    }
    for(let i=0;i<threeWaysWalls;i++){
        walls.push('three-ways');
    }

    shuffleArray(walls);

    const firstCorner = walls[cornerIds.tl];
    const secondCorner = walls[cornerIds.tr];
    const thirdCorner = walls[cornerIds.bl];
    const fourthCorner = walls[cornerIds.br];

    walls[cornerIds.tl] = cornerImg;
    walls[cornerIds.tr] = cornerImg;
    walls[cornerIds.bl] = cornerImg;
    walls[cornerIds.br] = cornerImg;

    // for each image replaced by a corner, we replace 4 corner images by the four images that was removed to keep the good number of images of each type
    let substitutionCounter = 0;
    for(let i=0;i<walls.length;i++){
        if(i != cornerIds.tl && i != cornerIds.tr && i != cornerIds.bl && i != cornerIds.br){
            if(walls[i] == cornerImg){
                if(substitutionCounter == 0){
                    walls[i] = firstCorner;
                }else if(substitutionCounter == 1){
                    walls[i] = secondCorner;
                }else if(substitutionCounter == 2){
                    walls[i] = thirdCorner;
                }else if(substitutionCounter == 3){
                    walls[i] = fourthCorner;
                }
                substitutionCounter++;
            }
        }
    }

    let gridContent = '';

    let slotId = 0;
    const sides = [
        'turnRight',
        'turnLeft',
        'turnUp',
        'turnDown',
    ];
    let turnSide;
    let sideSelected = 0;
    for(let row=0; row<rowsNumber; row++){
        gridContent += '<tr class="labyrinth-row">';
        for(let col=0; col<colsNumber; col++){
            if(row == 0 || row == rowsNumber-1 || col == 0 || col == colsNumber-1){
                if((col == 0 && row == 0) 
                    || ((row == 0 || row == rowsNumber-1) && (col == 1 || col == 3 || col == 5 || col == 7))
                    || ((col == 0 || col == colsNumber-1) && (row == 1 || row == 3 || row == 5 || row == 7))
                    || (row == 0 && col == colsNumber-1) 
                    || (col == 0 && row == rowsNumber-1) 
                    || (col == colsNumber-1 && row == rowsNumber-1)){
                    gridContent += '<td id="outer-slot_'+row+'_'+col+'" class="labyrinth-cell labyrinth-outer slotRow_'+row+' slotCol_'+col+'"></td>';
                }else{
                    gridContent += '<td id="outer-slot_'+row+'_'+col+'" class="labyrinth-cell labyrinth-outer enabled slotRow_'+row+' slotCol_'+col+'"><img id="outer-card_'+row+'_'+col+'" class="labyrinth-walls outer enabled turnLeft cardRow_'+row+' cardCol_'+col+'" src="/img/games/'+walls[walls.length-1]+'.png" style="opacity:0"></td>';
                }
            }
            else{
                sideSelected = Math.round(Math.random()*3);
                turnSide = sides[sideSelected];
                gridContent += '<td id="slot_'+row+'_'+col+'" class="labyrinth-cell'+(slotId == cornerIds.tl ? ' boardCorner topLeft' : slotId == cornerIds.tr ? ' boardCorner topRight' : slotId == cornerIds.bl ? ' boardCorner bottomLeft' : slotId == cornerIds.br ? ' boardCorner bottomRight': '')+' slotRow_'+row+' slotCol_'+col+'"><img id="card_'+row+'_'+col+'" class="labyrinth-walls'+(slotId == cornerIds.tl ? ' turnRight' : slotId == cornerIds.tr ? ' turnDown' : slotId == cornerIds.bl ? ' turnUp' : slotId == cornerIds.br ? ' turnLeft': ' '+turnSide)+' cardRow_'+row+' cardCol_'+col+'" src="/img/games/'+walls[slotId]+'.png" style="opacity:1"></td>';
                slotId++;
            }
        }
        gridContent += '</tr>';
    }

    const gameArea = document.createElement('table');
    gameArea.classList.add('labyrinth-grid');
    gameArea.innerHTML = gridContent;

    const gameContainer = document.getElementById('labyrinth-stepB-container');

    gameContainer.appendChild(gameArea);

    // logic of the game
    $('.labyrinth-walls').on('dragstart', function(event) { 
        event.preventDefault();
    });
    const outerPieces = $('.labyrinth-walls.outer');
    const slotSize = 74;
    let mouseDown = false;
    let rowSelected;
    let colSelected;
    let previousPointerX;
    let previousPointerY;
    let pointerX;
    let pointerY;
    let pointerDifferenceX;
    let pointerDifferenceY;
    let topValue;
    let leftValue;
    let newTopPosition;
    let newLeftPosition;
    let dragActivated = false;
    let cardClicked = null;
    
    // JS alternative to css "hover" because we need to have the "opacity" styling rule editable directly into the DOM
    $('.labyrinth-walls.outer.enabled').on("mouseenter", (e) => {
        if(!dragActivated){
            e.target.style.opacity = 1;
        }
    })
    $('.labyrinth-walls.outer.enabled').on("mouseleave", (e) => {
        if(!dragActivated){
            e.target.style.opacity = 0;
        }
    })

    // Init all the events that will be used during the game
    outerPieces.each((key, piece) => {
        piece.addEventListener('mousedown', (e) => {
            mouseDown = true;
            cardClicked = e.currentTarget; 
            const cardId = cardClicked.id;
            const rowId = cardId.split('_')[1];
            const colId = cardId.split('_')[2];
            rowSelected = rowId;
            colSelected = colId;
            
            let direction = '';
            let lineId = 0;
            // The following lines are used to move the whole line or column when an outer wall from the same line/column is clicked
            if(colId == 0 || colId == colsNumber-1){
                direction = 'Row';
                lineId = rowId;
            }else if (rowId == 0 || rowId == rowsNumber-1){
                direction = 'Col';
                lineId = colId;
            }
            const cardsToMove = $('.card'+direction+'_'+lineId);
            cardsToMove.each((key, card) => {
                if(card.style.opacity != 0){
                    card.style.position = 'relative';
                    card.style.top = 0;
                    card.style.left = 0;
                }
            });
        });
    });
    document.addEventListener('mouseup', () => {
        mouseDown = false;

        // If the mouse didn't move when it was down, consider it as a simple click
        if(dragActivated){
            dragActivated = false;

            if(colSelected == 0){// If the selected card is an outer wall from the left side
                runMovingLogic('left');
            }else if(colSelected == 8){// If the selected card is an outer wall from the right side
                runMovingLogic('right');
            }else if(rowSelected == 0){// If the selected card is an outer wall from the top side
                runMovingLogic('top');
            }else if(rowSelected == 8){// If the selected card is an outer wall from the bottom side
                runMovingLogic('bottom');
            }
        }else{
            if(cardClicked.classList.contains('turnLeft')){
                outerPieces.removeClass('turnLeft');
                outerPieces.addClass('turnUp');
            }else if(cardClicked.classList.contains('turnUp')){
                outerPieces.removeClass('turnUp');
                outerPieces.addClass('turnRight');
            }else if(cardClicked.classList.contains('turnRight')){
                outerPieces.removeClass('turnRight');
                outerPieces.addClass('turnDown');
            }else if(cardClicked.classList.contains('turnDown')){
                outerPieces.removeClass('turnDown');
                outerPieces.addClass('turnLeft');
            }
        }
    });
    // event triggered when an outer card is moving, the cards that are on the same row or column will make the same displacement
    document.addEventListener('mousemove', (e) => {
        if(mouseDown){
            dragActivated = true;
            previousPointerX = pointerX;
            previousPointerY = pointerY;
            pointerX = e.pageX;
	        pointerY = e.pageY;
            pointerDifferenceX = pointerX < 0 && previousPointerX > 0 ? pointerX-previousPointerX : previousPointerX-pointerX;
            pointerDifferenceY = pointerY < 0 && previousPointerY > 0 ? pointerY-previousPointerY : previousPointerY-pointerY;
            
            if(rowSelected == 0 || rowSelected == rowsNumber-1){
                const colCards = $('.cardCol_'+colSelected);
                colCards.each((key, card) => {
                    if(card.style.opacity != 0){
                        topValue = parseInt(card.style.top.split('px')[0]);
                        newTopPosition = topValue - pointerDifferenceY;
                        if((rowSelected == 0 && newTopPosition >= 0 && newTopPosition <= slotSize) || (rowSelected != 0 && newTopPosition <= 0 && newTopPosition >= slotSize*-1)){
                            card.style.top = newTopPosition + 'px';
                        }
                    }
                });
            }else if(colSelected == 0 || colSelected == colsNumber-1){
                const rowCards = $('.cardRow_'+rowSelected);
                rowCards.each((key, card) => {
                    if(card.style.opacity != 0){
                        leftValue = parseInt(card.style.left.split('px')[0]);
                        newLeftPosition = leftValue - pointerDifferenceX;
                        if((colSelected == 0 && newLeftPosition >= 0 && newLeftPosition <= slotSize) || (colSelected != 0 && newLeftPosition <= 0 && newLeftPosition >= slotSize*-1)){
                            card.style.left = newLeftPosition + 'px';
                        }
                    }
                });
            }
        }
    });

    /**
     * Trigger the switch of sources and direction between each cards of a row or a column depending of the side of the board specified
     * 
     * @param {*} side 
     */
    function runMovingLogic(side){
        if(side){
            let outerWallPostition;
            let currentLine;
            let cardMaxMove;
            let slotLineClass;
            let linesNumber;
            let keyToCopy;
            if(side == 'left'){
                currentLine = $('.cardRow_' + rowSelected);
                outerWallPostition = parseInt(currentLine[0].style.left.split('px')[0]);
                cardMaxMove = slotSize;
                slotLineClass = '.slotRow_' + rowSelected;
                linesNumber = colsNumber;
                keyToCopy = -1;
            }else if (side == 'right'){
                currentLine = $('.cardRow_' + rowSelected);
                outerWallPostition = parseInt(currentLine[8].style.left.split('px')[0]);
                cardMaxMove = (-1*slotSize);
                slotLineClass = '.slotRow_' + rowSelected;
                linesNumber = colsNumber;
                keyToCopy = 1;
            }else if (side == 'top'){
                currentLine = $('.cardCol_' + colSelected);
                outerWallPostition = parseInt(currentLine[0].style.top.split('px')[0]);
                cardMaxMove = slotSize;
                slotLineClass = '.slotCol_' + colSelected;
                linesNumber = rowsNumber;
                keyToCopy = -1;
            }else if (side == 'bottom'){
                currentLine = $('.cardCol_' + colSelected);
                outerWallPostition = parseInt(currentLine[8].style.top.split('px')[0]);
                cardMaxMove = (-1*slotSize);
                slotLineClass = '.slotCol_' + colSelected;
                linesNumber = rowsNumber;
                keyToCopy = 1;
            }
        
            // If the selected card is pushed to the maximum possible position 
            if(outerWallPostition == cardMaxMove){
                // First, we copy the current row cards
                let currentLineCopy = new Array();
        
                for(let i = 0;i < currentLine.length;i++ ){
                    currentLineCopy.push({
                        source: JSON.parse(JSON.stringify(currentLine[i].src)),
                        classes: JSON.parse(JSON.stringify(currentLine[i].classList))
                    });
                }

                let newOuterPieceId;
                if(side == 'left' || side == 'top'){
                    newOuterPieceId = currentLineCopy.length-2;
                }else if(side == 'right' || side == 'bottom'){
                    newOuterPieceId = 1;
                }
                
                // We store the data of the card that has been ejected from the board and we save its direction
                const newOuterPiece = currentLineCopy[newOuterPieceId];
                const newOuterPieceDirection = getCardDirection(newOuterPiece);
                
                // We update the cards from the concerned row into the board (excluding the outerwalls)
                $(slotLineClass).each((key, slot) => {
                    if(key > 0 && key < linesNumber-1){
                        slot.firstChild.src = currentLineCopy[key+keyToCopy].source;
                        let cardDirection = getCardDirection(currentLineCopy[key+keyToCopy]);
                        slot.firstChild.classList.remove('turnLeft', 'turnUp', 'turnRight', 'turnDown');
                        slot.firstChild.classList.add(cardDirection);
                    }
                });
        
                // update of all the outer pieces with the new piece that has been ejected from the board
                $('.labyrinth-cell.labyrinth-outer.enabled').each((key, slot) => {
                    slot.firstChild.src = newOuterPiece.source;
                    slot.firstChild.classList.remove('turnLeft', 'turnUp', 'turnRight', 'turnDown');
                    slot.firstChild.classList.add(newOuterPieceDirection);
                });
            }
            // We reset the position of each card of the row selected to start a new turn
            currentLine.each((key, card) => {
                if(side == 'left' || side == 'right'){
                    card.style.left = 0;
                    if(side == 'left'){
                        if(key == 0){
                            card.style.opacity = 0;
                        }
                    }else{
                        if(key == 8){
                            card.style.opacity = 0;
                        }
                    }
                }else if(side == 'top' || side == 'bottom'){
                    card.style.top = 0;
                    if(side == 'top'){
                        if(key == 0){
                            card.style.opacity = 0;
                        }
                    }else{
                        if(key == 8){
                            card.style.opacity = 0;
                        }
                    }
                }
            });
        }
    }

    /**
     * Get the direction of a labyrinth game card
     */
    function getCardDirection(card){
        let cardClasses = Object.values(card.classes);
        let cardDirection;
        if(cardClasses.find((element) => element == 'turnLeft')){
            cardDirection = 'turnLeft';
        }else if (cardClasses.find((element) => element == 'turnUp')){
            cardDirection = 'turnUp';
        }else if (cardClasses.find((element) => element == 'turnRight')){
            cardDirection = 'turnRight';
        }else if (cardClasses.find((element) => element == 'turnDown')){
            cardDirection = 'turnDown';
        }
        return cardDirection;
    }
}