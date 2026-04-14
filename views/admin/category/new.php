<?php

use App\Auth;
use App\Connexion;
use App\HTML\Form;
use App\Model\Category;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

Auth::check();

$errors = [];
/**
 * Je crée une catégorie qui n'existe pas encore
 */
$item = new Category();

if (!empty($_POST)) {
    $pdo = Connexion::getPDO();
    $table = new CategoryTable($pdo);
    $v = new CategoryValidator($_POST, $table);
    ObjectHelper::hydrae($item, $_POST, ['name', 'slug']);
    if ($v->validate()) {
        $table->create([
            'name' => $item->getName(),
            'slug' => $item->getSlug()
        ]);
        header('Location: ' . $router->url('admin_categories') . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($item, $errors);
?>

<?php if($errors): ?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu être enregistrée, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Créer une nouvelle catégorie</h1>

<?php require('_form.php') ?>
