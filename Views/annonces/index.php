<h1>Page d'accueil des annonces</h1>

<?php foreach($annonces as $annonce): ?>
    <article>
        <h1><?= $annonce->titre ?></h1>
        <div><?= $annonce->created_at ?></div>
        <div><?= $annonce->description ?></div>
    </article>
<?php endforeach; ?>