<?php
$pdo = new PDO('mysql:dbname=tutoblog;host=localhost', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$pdo->exec('TRUCATE TABLE post_category');
$pdo->exec('TRUCATE TABLE post');
$pdo->exec('TRUCATE TABLE category');
$pdo->exec('TRUCATE TABLE user');
