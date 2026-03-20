<?php

use App\Connexion;
use App\Helpers\Text;
use App\Model\Post;
use App\paginatedQuery;
use App\URL;

$title = 'Mon blog';
$pdo = Connexion::getPDO();

$paginationQuery = new paginatedQuery(
    "SELECT * FROM post ORDER BY created_at DESC",
    "SELECT COUNT(id) FROM post"
);
$posts = $paginationQuery->getItems(Post::class);
$link = $router->url('home');
?>

<h1>Mon blog</h1>

<div class="row">
    <?php foreach($posts as $post): ?>
        <div class="col-md-3">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach ?>
</div>


<div class="d-flex justify-content-between my-4">
    <?= $paginationQuery->previousLink($link) ?>
    <?= $paginationQuery->nextLink($link) ?>
</div>



