<?php
    $game = $params['game'];
    $users = $params['users'];
    $characters = $params['characters'];
    $jsonCharactersList = json_encode($characters);
?>
<script type="module">
    import {setCharactersList} from '../../public/scripts/games.js';
    // In order to make the character's sheet work, we need to pass the characters data to JS
    setCharactersList(<?= $jsonCharactersList ?>);
</script>

<section class="section whiteBG">
    <div class="section-container">
        <h2 class="pageTitle"><?= $game->getTitle() ?></h2>
    </div>
</section>

<section class="section">
    <div class="section-container">
        <div id="games-stepA" class="games-stepA">
            <form>
                <div>
                    <h4>Qui va jouer ?</h4>
                    <?php foreach($users as $key => $user): ?>
                        <input type="checkbox" id="players-<?= $key ?>" value="<?= $key ?>" name="playersList"><label for="players-<?= $key ?>"><?= substr(strtoupper($user['name']), 0, 1) ?></label>
                    <?php endforeach; ?>
                </div>
                <div>
                    <h4>Niveau de difficulté :</h4>
                    <input type="radio" id="level-veryEasy" value="1" name="level"><label for="level-veryEasy">Très facile</label>
                    <input type="radio" id="level-easy" value="2" name="level" checked="checked"><label for="level-easy">Facile</label>
                    <input type="radio" id="level-medium" value="3" name="level"><label for="level-medium">Normal</label>
                    <input type="radio" id="level-hard" value="4" name="level"><label for="level-hard">Difficile</label>
                    <input type="radio" id="level-extreme" value="5" name="level"><label for="level-extreme">Extrême</label>
                </div>
                <button class="kidsMoviesBtn blueBG" id="startGame" disabled>Commencer</button>
            </form>
        </div>
        <?php if($game->getTitle() == 'Blind test'): ?>
            <div id="games-stepB" class="blindTest-stepB hidden">
                <div id="blindTest-stepB-container">
                    <div id="blindTest-stepB-videoPlayer">Vidéo</div>
                </div>
            </div>
        <?php elseif($game->getTitle() == 'Memory'): ?>
            <div id="games-stepB" class="memory-stepB hidden">
                <div id="memory-stepB-container"></div>
            </div>
        <?php endif; ?>
    </div>
    <script type="module" src="../../public/scripts/games.js"></script>
</section>