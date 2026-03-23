<?php
namespace App\Table\Exception;

use Exception;

class NotFoundExcept extends Exception{

    public function __construct(string $table, int $id)
    {
        $this->message = "Aucun enregistrement ne correspond à l'id #$id dans la table '$table'";
    }

}