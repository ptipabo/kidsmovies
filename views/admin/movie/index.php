<h1>Administration des films</h1>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Titre</th>
            <th>Année de sortie</th>
            <th>Durée (en minutes)</th>
            <th>Image</th>
            <th>Synopsis</th>
            <th>Suite</th>
            <th>Slug</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $movies = $params['movies'];
        for($i=0;$i<count($movies->id);$i++) : ?>
            <tr>
                <td><?= $movies->id[$i] ?></td>
                <td><?= $movies->title[$i] ?></td>
                <td><?= $movies->year[$i] ?></td>
                <td><?= $movies->duration[$i] ?></td>
                <td><?= $movies->img[$i] ?></td>
                <td></td>
                <td><?= $movies->sequel[$i] ?></td>
                <td><?= $movies->slug[$i] ?></td>
                <td>
                    <a href="#" class="editButton">Modifier</a>
                    <a href="#" class="deleteButton">Supprimer</a>
                </td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>