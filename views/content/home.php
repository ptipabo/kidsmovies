<script>
    const moviesList = <?= $params['movies'] ?>
</script>

<div class="pageHeader">
    <h2>Films</h2>
    <div class="sortBy">
        <label for="sortBy">Trier par : </label>
        <select name="sortBy" onchange="showMovies(orderBy(moviesList, this.value))">
            <option value="title">Ordre alphabétique</option>
            <option value="date">Date de sortie</option>
            <option value="suite">Suites</option>
            <option value="length">Durée</option>
        </select>
    </div>
    <div class="filterBy">
        <label for="filterBy">Rechercher un film : </label>
        <input type="text" name="filterBy" id="filterValue" value="" onchange="showMovies(movieFilter(this.value, moviesList))" />
    </div>
</div>
<div id="mainContent">
</div>
<script>
    showMovies(moviesList);
</script>