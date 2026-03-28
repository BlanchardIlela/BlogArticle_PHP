<?php

use App\Connexion;
use App\Table\PostTable;

$pdo = Connexion::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);

if (!empty($_POST)) {
    dd('Traiter les données !');
}
?>

<h1>Editer l'article <?= $post->getName() ?></h1>

<form action="" method="POST">
    <div class="form-group">
        <label for="name">
            <input type="text" class="form-control" name="name" id="" value="<?= htmlentities($post->getName() )?>">
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>