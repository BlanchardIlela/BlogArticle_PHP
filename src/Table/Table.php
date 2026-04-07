<?php
namespace App\Table;

use App\Table\Exception\NotFoundExcept;
use Exception;
use PDO;

abstract class Table {

    protected $pdo;

    protected $table = null;

    protected $class = null;

    public function __construct(PDO $pdo)
    {
        if ($this->table === null) {
            throw new Exception("La class " . get_class($this) . " n'a pas de propriété table \$table");
            
        }
        if ($this->class === null) {
            throw new Exception("La class " . get_class($this) . " n'a pas de propriété table \$class");
            
        }
        $this->pdo = $pdo;
    }

     public function find(int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' .$this->table .' WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundExcept($this->table, $id);
            
        }
        return $result;
    }

    /**
     * Vérifie si une valeur existe dans la table 
     * @param string $field champs à rechercher
     * @param mixed $value la valeur associée au champs
     */
    public function exists (string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if ($except != null) {
            $sql .= "AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

}