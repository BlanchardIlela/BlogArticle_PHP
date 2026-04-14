<?php
namespace App\Table;

use App\Model\Category;
use PDO;

class CategoryTable extends Table {

    protected $table = "category";
    protected $class = Category::class;

    /**
     * @param App\Model\Post[] $posts
     */
    public function hydratePosts (array $posts): void
    {
        $postsByID = [];
        foreach ($posts as $post) {
            $postsByID[$post->getID()] = $post;
        }
        $categories = $this->pdo
            ->query('SELECT c.*, pc.post_id
                    FROM post_category pc
                    JOIN category c ON c.id = pc.category_id
                    WHERE pc.post_id IN (' . implode(',', array_keys($postsByID)) . ')'
                    )->fetchAll(PDO::FETCH_CLASS, $this->class);
        // On parcours les catégories
        foreach ($categories as $category) {
            // On trouve l'article $posts correspondant à ligne
            // On trouve la catégorie à l'article
            $postsByID[$category->getPostID()]->addCategory($category);
        }
    }
   

}