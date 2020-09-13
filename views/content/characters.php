<script>
    //On transmet les données de PHP au Javascript
    const charList = <?= $params['characters'] ?>;
</script>

<div class="pageHeader">
    <h2>Personnages</h2>
</div>

<div id="mainContent">   
    <div id="charactersList">
        <!-- Contient la liste des personnages -->
    </div>
    <div id="charInfo" class="hidden">
        <img id="closeInfo" src="./img/close.png" title="Fermer" onclick="closeInfo()" />
        <img id="charImg" />
        <h3 id="charName"></h3>
        <p id="charMovie">Film : <a id="charMovieLink"></a></p>
        <p id="charDesc"></p>
    </div>
</div>

<script>
    //On affiche la liste des personnages
    showCharacters(charList);
</script>