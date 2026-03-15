<?php

use App\Connexion;

require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = Connexion::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');   
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');   

$posts = [];
$categories = [];


// 1. On prépare la requête une seule fois (en dehors de la boucle)
$query = $pdo->prepare("INSERT INTO post (name, slug, content, created_at) VALUES (:name, :slug, :content, :created_at)");

for ($i = 0; $i < 50; $i++) {
    // 2. On exécute avec les données de Faker
    $query->execute([
        'name'       => $faker->sentence(),
        'slug'       => $faker->slug(),
        'content'    => $faker->paragraphs(3, true),
        'created_at' => $faker->date() . ' ' . $faker->time()
    ]);
    $posts[] = $pdo->lastInsertId();
}

echo "La table post remplie avec succès ! \n";

// 1. On prépare la requête une seule fois (en dehors de la boucle)
$query = $pdo->prepare("INSERT INTO category (name, slug) VALUES (:name, :slug)");

for ($i = 0; $i < 5; $i++) {
    // 2. On exécute avec les données de Faker
    $query->execute([
        'name'       => $faker->sentence(3),
        'slug'       => $faker->slug()
    ]);
    $categories[] = $pdo->lastInsertId();
}

echo "La table category remplie avec succès ! \n";


foreach ($posts as $post) {
    $radomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach ($radomCategories as $category) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}

//On veut hash notre password
$password = password_hash('admin', PASSWORD_BCRYPT);
// 1. On prépare la requête 
$query = $pdo->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");

// 2. On exécute les données 
$query->execute([
    'username'  => 'admin',
    'password'  =>  $password
]);

echo "La table user remplie avec succès !";