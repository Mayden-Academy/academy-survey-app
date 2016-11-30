<?php
/**
 * Created by PhpStorm.
 * User: academy
 * Date: 30/11/2016
 * Time: 11:00
 */

namespace Application\Factory;


class UserAuthenticationControllerFactory
{
    public function __invoke($sm) {
        $user = $sm->get(\Application\Model\UserModel::class);
        return new \Application\Controller\UserAuthenticationController($user);
    }
}