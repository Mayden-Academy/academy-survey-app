<?php
/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 29/11/2016
 * Time: 12:10
 */

namespace Application\Factory;

class UserModelFactory
{
    public function __invoke($sm)
    {
        $pdo = $sm->get('pdo');
        return new \Application\Model\UserModel($pdo);
    }
}