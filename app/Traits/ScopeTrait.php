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
    public static function publicScope()
    {
        $comments = ['comment_view', 'comment_create', 'comment_update', 'comment_delete'];
        $scope = [...$comments];

        return $scope;
    }

}
