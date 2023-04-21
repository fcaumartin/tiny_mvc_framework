<h1>
    <?= $message ?>
</h1>

Lorem ipsum dolor at omnis libero harum eos eum ex quod consequatur?

<hr>

<h3>Liste des clients</h3>

<?php foreach ($liste as $v): ?>

    <div>
        
        <?= $v->nom ?>

    </div>

    
<?php endforeach; ?>
    
<hr>

<a href="<?= url("crud/index") ?>">crud sur la table client</a>