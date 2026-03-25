<?php

use App\Connexion;
use App\Table\PostTable;

$title = "Administration";
$pdo = Connexion::getPDO();
$link = $router->url('admin_posts');
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

?>


<table class="table">
    <thead>
        <th>Titre</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
            <tr>
                <td>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>">
                        <?= htmlentities($post->getName()) ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?> " class="btn btn-primary">
                        Editer
                    </a>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?> " class="btn btn-danger"
                    onclick="return confirm('Voulez vous vraiment effectuer cette action ?')">
                        Supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>