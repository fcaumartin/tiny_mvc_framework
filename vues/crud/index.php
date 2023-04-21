<h1>Liste des clients</h1>
<a href="<?= url("crud/create") ?>">Ajouter</a>
<hr>
<?php foreach ($liste as $client): ?>
    <div>
        <?= $client->nom ?>
        <a href="<?= url("crud/update/") . $client->id ?>">update</a>
        <a href="<?= url("crud/delete/") . $client->id ?>">delete</a>
    </div>
<?php endforeach; ?>