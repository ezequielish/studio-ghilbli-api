<?php

namespace App\Traits;

/**
 *
 */
trait ScopeTrait
{

    /**
     * Valida los campos y devuelve el primero que falle
     */
    public function publicScope($validatedData)
    {
        $comments = ['comment:view', 'comment:create', 'comment:update', 'comment:delete'];
        $scope = [...$comments];

        return $scope;
    }

}
