<?php
namespace App;

class ObjectHelper {

    public static function hydrae ($object, array $data, array $fiedls): void
    {
        foreach($fiedls as $fiedl){
            $methode = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $fiedl)));
            $object->$methode($data[$fiedl]);
        }
    }

}