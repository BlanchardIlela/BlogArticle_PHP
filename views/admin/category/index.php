<?php

use App\Auth;
use App\Connexion;
use App\Table\CategoryTable;

Auth::check();

$router->layout = "admin/layouts/default";
$title = "Gestion des catégories";
$pdo = Connexion::getPDO();
$link = $router->url('admin_categories');
$items = (new CategoryTable($pdo))->all();
?>


<?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'enregistrement a bien été supprimé
    </div>
<?php endif ?>


<table class="table">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>URL</th>
        <th>
            <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">Nouvelle Catégorie</a>
        </th>
    </thead>
    <tbody>
        <?php foreach($items as $item): ?>
            <tr>
                <td>#<?= $item->getID() ?></td>
                <td>
                    <a href="<?= $router->url('admin_category', ['id' => $item->getID()]) ?>">
                        <?= htmlentities($item->getName()) ?>
                    </a>
                </td>
                <td><?= $item->getSlug() ?></td>
                <td>
                    <a href="<?= $router->url('admin_category', ['id' => $item->getID()]) ?> " class="btn btn-primary">
                        Editer
                    </a>
                    <form action="<?= $router->url('admin_category_delete', ['id' => $item->getID()]) ?> " method="POST"
                         onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display: inline;">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
