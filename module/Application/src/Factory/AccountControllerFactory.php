<?php
/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 29/11/2016
 * Time: 14:02
 */

namespace Application\Factory;

class AccountControllerFactory
{
    public function __invoke($sm) {
        $user = $sm->get(\Application\Model\User::class);
        return new \Application\Controller\AccountController($user);
    }
}