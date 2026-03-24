<?php

use App\Connexion;
use App\Table\PostTable;

$title = "Administration";
$pdo = Connexion::getPDO();
$posts = (new PostTable($pdo))->findPaginated();
?>