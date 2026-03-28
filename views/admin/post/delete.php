<?php

use App\Auth;
use App\Connexion;
use App\Table\PostTable;

Auth::check();

$pdo = Connexion::getPDO();
$table = new PostTable($pdo);
//$table->delete($params['id']);
header('Location: ' . $router->url('admin_posts') . '?delete=1');
?>
