<?php

use App\Helpers\Text;
use App\Model\Post;

$title = 'Mon blog';
$pdo = new PDO('mysql:dbname=tutoblog;host=localhost', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
//Numéro de page courante
$currentPage = (int)($_GET['page'] ?? 1);
if ($currentPage <= 0) {
    throw new Exception('Numéro de page invalide');
}
//Compter les ids
$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
$perPage = 12;
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}
$query = $pdo->query('SELECT * FROM post ORDER BY created_at DESC LIMIT ' . $perPage);
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
?>

<h1>Mon blog</h1>

<div class="row">
    <?php foreach($posts as $post): ?>
        <div class="col-md-3">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach ?>
</div>
