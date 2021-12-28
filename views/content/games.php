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
                <h3 class="game-title"><a href="/games/<?= $game['id'] ?>" title="<?= $game['title'] ?>"><?= $game['title'] ?></a></h3>
                <img src="./img/<?= $game['img'] ?>" alt="<?= $game['title'] ?>">
                <?php if($game['desc']): ?>
                    <div class="game-desc">
                        <?= $game['desc'] ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>