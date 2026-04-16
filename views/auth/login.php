<?php

use App\Connexion;
use App\HTML\Form;
use App\Model\User;
use App\Table\Exception\NotFoundExcept;
use App\Table\UserTable;

$user = new User();
$errors = [];
if (!empty($_POST)) {
    $user->setUsername($_POST['username']);
    $errors['password'] = 'Identifiant ou mot de passe incorrect';

    if (!empty($_POST['username']) || !empty ($_POST['password'])) {
        $table = new UserTable(Connexion::getPDO());
        try {
            $u = $table->findByUsername($_POST['username']);
            if(password_verify($_POST['password'], $u->getPassword()) === true) {
                session_start();
                $_SESSION['auth'] = $u->getId();
                header('Location: ' . $router->url('admin_posts'));
                exit();
            }
        } catch (NotFoundExcept $e) {
        }
    }
}

$form = new Form($user, $errors);
?>

<h1>Se conecter</h1>

<?php if(isset($_GET['forbidden'])): ?>
    <div class="alert alert-danger">
        Vous ne pouvez pas accèder à cette page
    </div>
<?php endif ?>

<form action="<?= $router->url('login') ?>" method="post">
    <?= $form->input('username', 'Nom d\'utilisateur') ?>
    <?= $form->input('password', 'Mot de passe') ?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>