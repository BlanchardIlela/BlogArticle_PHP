<?php
require '../vendor/autoload.php';

use App\Router;

$router = new App\Router(dirname(__DIR__) . '/views');
$router
    ->get('/blog', 'post/index', 'blog')
    ->get('/blog/category', 'category/show', 'category')
    ->run();
?>