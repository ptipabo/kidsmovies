<?php
    $games = $params['games'];
?>

<section class="section whiteBG">
    <div class="section-container">
        <h2 class="pageTitle">Jeux</h2>
    </div>
</section>

<section class="section whiteBG">
    <div class="section-container d-flex">
        <?php
        foreach ($games as $game): ?>
            <div class="gameBlock">
                <div class="gameBlock__btn">
                    <h3 class="game-title"><?= $game['title'] ?></h3>
                    <img src="./img/games/<?= $game['img'] ?>" alt="<?= $game['title'] ?>">
                    <?php if($game['desc']): ?>
                        <div class="game-desc">
                            <?= $game['desc'] ?>
                        </div>
                    <?php endif; ?>
                    <a href="/games/<?= $game['id'] ?>" title="<?= $game['title'] ?>" class="gameOpenLink">.</a>
                </div>
                <?php if (isset($game['highScores'])): ?>
                    <?php $nbrToDisplay = 10; ?>
                    <div class="gameBlock__highScores">
                        <?php for($i=1;$i<=5;$i++): ?>
                            <h3>Classement Solo - Niveau <?= $i ?></h3>
                            <table class="gameBlock__highScores-table">
                                <tr class="gameBlock__highScores-table-row">
                                    <th class="gameBlock__highScores-table-cell gameBlock__highScores-table-cell--head">Joueur</th>
                                    <th class="gameBlock__highScores-table-cell gameBlock__highScores-table-cell--head">Score</th>
                                    <th class="gameBlock__highScores-table-cell gameBlock__highScores-table-cell--head">Nombre de tours</th>
                                </tr>
                                <?php
                                $scoreCounter = 0;
                                foreach ($game['highScores'] as $score): ?>
                                    <?php if ($score['playersNumber'] == 1): ?>
                                        <?php
                                            if($scoreCounter > $nbrToDisplay){
                                                break;
                                            }
                                            if ($score['level'] == $i): ?>
                                            <tr class="gameBlock__highScores-table-row">
                                                <td class="gameBlock__highScores-table-cell"><?= $score['player'] ?></td>
                                                <td class="gameBlock__highScores-table-cell"><?= $score['score'] ?></td>
                                                <td class="gameBlock__highScores-table-cell"><?= $score['roundsNumber'] ?></td>
                                            </tr>
                                        <?php endif;
                                        $scoreCounter++;
                                    endif;
                                endforeach; ?>
                            </table>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>