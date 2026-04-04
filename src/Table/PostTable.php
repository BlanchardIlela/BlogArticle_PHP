<?php
namespace App\Table;

use App\Model\Post;
use App\paginatedQuery;
use Exception;

class PostTable extends Table{

    protected $table = "post";
    protected $class = Post::class;

    public function update (Post $post): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug, created_at = :created, content = :content WHERE id = :id");
        $ok = $query->execute([
            'id' => $post->getID(),
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        if ($ok === false) {
            throw new Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
            
        }
    }

    public function delete (int $id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if ($ok === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
            
        }
    }

    public function findPaginated ()
    {
        $paginationQuery = new paginatedQuery(
        "SELECT * FROM {$this->table} ORDER BY created_at DESC",
        "SELECT COUNT(id) FROM {$this->table}",
        $this->pdo
        );
        $posts = $paginationQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginationQuery];
    }

    public function findPaginatedForCategory (int $categoryID)
    {
        $paginationQuery = new paginatedQuery(
            "SELECT p.* 
            FROM post p
            JOIN post_category pc ON pc.post_id = p.id 
            WHERE pc.category_id = {$categoryID}
            ORDER BY created_at DESC",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}"
        );
        $posts = $paginationQuery->getItems($this->class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginationQuery];
    }

}