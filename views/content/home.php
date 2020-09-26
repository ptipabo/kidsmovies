<script>
    const moviesList = <?= $params['movies'] ?>;
</script>

<section id="pageHeader">
    <h2>Films</h2>
    <div class="moviesListOptions">
        <label for="sortBy">Trier par : </label>
        <select name="sortBy" id="sortByValue">
            <option value="titleAsc">Ordre alphabétique (A > Z)</option>
            <option value="titleDesc">Ordre alphabétique (Z > A)</option>
            <option value="dateAsc">Date de sortie (Anciens > Récents)</option>
            <option value="dateDesc">Date de sortie (Récents > Anciens)</option>
            <option value="lengthAsc">Durée (Court > Longs)</option>
            <option value="lengthDesc">Durée (Longs > Court)</option>
            <option value="suite">Suites</option>
        </select>
    </div>
    <div class="moviesListOptions">
        <label for="filterBy">Rechercher un film : </label>
        <input type="text" name="filterBy" id="filterValue" value="" />
    </div>
    <div class="moviesListOptions">
        <label for="hideSeries">Masquer les suites : </label>
        <input type="checkbox" name="hideSeries" id="hideSeries" />
    </div>
</section>

<section id="mainContent">
    <div id="moviesList">
        <!--Contient la liste de tous les films-->
    </div>
</section>

<script type="module">
    import {showMovies, setDivMoviesList} from './public/scripts/init.js';
    setDivMoviesList(document.getElementById('moviesList'));
    showMovies(moviesList);
</script>