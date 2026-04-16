<form action="" method="POST">
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    <?= $form->select('categories', 'Catégories') ?>
    <?= $form->textarea('content', 'contenu') ?>
    <?= $form->input('created_at', 'Date de création') ?>
    <button type="submit" class="btn btn-primary">
        <?php if($post->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif ?>
    </button>
</form>