<?php

use App\Auth;
use App\Connexion;
use App\Table\CategoryTable;

Auth::check();

$pdo = Connexion::getPDO();
$table = new CategoryTable($pdo);
$table->delete($params['id']);
header('Location: ' . $router->url('admin_categories') . '?delete=1');
?>
