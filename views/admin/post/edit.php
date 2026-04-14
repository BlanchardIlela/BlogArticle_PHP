<?php

use App\Auth;
use App\Connexion;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\PostTable;
use App\Validators\PostValidator;

$pdo = Connexion::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;

Auth::check();

$errors = [];

if (!empty($_POST)) {
    $v = new PostValidator($_POST, $postTable, $post->getID());
    ObjectHelper::hydrae($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    if ($v->validate()) {
        $postTable->updatePost($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
?>

<?php if($success): ?>
    <div class="alert alert-success">
        L'article a bien été modifié
    </div>
<?php endif ?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success">
        L'article a bien été créé
    </div>
<?php endif ?>


<?php if($errors): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être modifié, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Editer l'article <?= $post->getName() ?></h1>

<?php require('_form.php') ?>