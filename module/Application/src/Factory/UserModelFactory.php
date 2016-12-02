<?php
/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 29/11/2016
 * Time: 12:10
 */

namespace Application\Factory;
use Application\Model\UserModel;

class UserModelFactory
{
    public function __invoke($sm)
    {
        $pdo = $sm->get('pdo');
        return new UserModel($pdo);
    }
}