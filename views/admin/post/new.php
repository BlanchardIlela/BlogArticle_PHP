<?php

use App\Auth;
use App\Connexion;
use App\HTML\Form;
use App\Model\Post;
use App\ObjectHelper;
use App\Table\PostTable;
use App\Validators\PostValidator;

Auth::check();

$errors = [];
/**
 * Je crée mon aricle qui n'existe pas encore
 */
$post = new Post();
/**
 * Définissons de la date du jour
 */
$post->setCreatedAt(date('Y-m-d H:i:s'));

if (!empty($_POST)) {
    $pdo = Connexion::getPDO();
    $postTable = new PostTable($pdo);
    $v = new PostValidator($_POST, $postTable, $post->getID());
    ObjectHelper::hydrae($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    if ($v->validate()) {
        $postTable->createPost($post);
        header('Location: ' . $router->url('admin_posts', ['id' => $post->getID()]) . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
?>

<?php if($errors): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être enregistré, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Créer un nouvel article</h1>

<?php require('_form.php') ?>
