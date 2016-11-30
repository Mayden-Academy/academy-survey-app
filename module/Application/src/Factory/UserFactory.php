<?php
/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 29/11/2016
 * Time: 12:10
 */

namespace Application\Factory;

class UserFactory
{
    public function __invoke($sm)
    {
        $pdo = $sm->get('pdo');
        return new \Application\Model\User($pdo);
    }
}